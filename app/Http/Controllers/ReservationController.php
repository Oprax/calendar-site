<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ReservationRequest;
use App\Http\Controllers\Controller;

use App\Reservation;

use Validator;

use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Instantiate a new ReservationController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['create', 'store', 'show', 'index']]);
        Carbon::setToStringFormat('d/m/Y');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        $title = "Réservations";
        $reservations = $this->buildFilterQuery($request->all());
        
        if($request->ajax()) {
            return $reservation;
        }
        return view('reservation.index', compact('title', 'reservations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Request  $request
     * @return Response
     */
    public function create(Request $request)
    {
        $context = $request->all();

        if(array_key_exists('arrive_at', $context)) {
            $context['arrive_at'] = Carbon::parse($context['arrive_at']);
        }

        if(array_key_exists('leave_at', $context)) {
            $context['leave_at'] = Carbon::parse($context['leave_at']);
        }

        $context['title'] = "Réservation formulaire";
        return view('reservation.create', $context);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ReservationRequest $request)
    {
        $reservation = new Reservation($request->all());
        $reservation->is_valid  = false;

        $reservation->save();

        $dest = [];
        $env = app()->environment();

        if($env == 'production') {
            $dest = ['romuller67@hotmail.fr', 'schneider.fernand@evc.net'];
        } else {
            $dest = ['romuller67@hotmail.fr', 'aphrox.romuller@gmail.com'];
        }

        $this->sendMail('emails.new', $reservation->toArray(), $dest);
        
        if($request->ajax()) {
            return $reservation;
        }
        return redirect()->route('reservation.show', $reservation);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $title = "Réservation";

        if($request->ajax()) {
            return $reservation;
        }
        return view('reservation.show', compact('title', 'reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $reservation = Reservation::findOrFail($id);
        $title = "Modification";
        return view('reservation.edit', compact('title', 'reservation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ReservationRequest $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $is_valid = $reservation->is_valid;
        $reservation->update($request->all());
        $reservation->save();

        if($reservation->is_valid and $reservation->is_valid != $is_valid) {
            $this->sendMail('emails.confirm', $reservation->toArray());
        }

        if($request->ajax()) {
            return $reservation;
        }
        return redirect()->route('reservation.show', $reservation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        $this->sendMail('emails.refuse', $reservation->toArray());

        if($request->ajax()) {
            return $reservation;
        }
        return redirect()->route('reservation.index');
    }

    /**
     * Helper to send Email
     * 
     * @param  string        $view    The name of blade view
     * @param  array         $data    Array contains information like email or name
     * @param  string|array  $to      'To' array, if empty use data email
     * @return Validator
     */
    private function sendMail($view, array $data, $to = null)
    {
        if(is_null($to)) {
            $to = $data['email'];
        }

        return \Mail::send([$view, $view.'-txt'], $data, function ($message) use ($to)
        {
            $message->to($to);
        });
    }

    /**
     * Helper to build Query
     * 
     * @param  array  $params
     * @return Illuminate\Database\Eloquent\Collection
     */
    private function buildFilterQuery(array $params)
    {
        $ops = [
            'eq'  => '=',
            'lte' => '<=',
            'gte' => '>=',
            'lt'  => '<',
            'gt'  => '>',
        ];

        $fields = ['name', 'forename', 'arrive_at', 'leave_at', 'nb_people'];

        $limit = 50;
        $page = 1;

        if (isset($params['limit']) and $params['limit'] > 0 and $params['limit'] < 100) {
            $limit = (int) $params['limit'];
        }

        if (isset($params['page']) and $params['page'] > 0) {
            $page = (int) $params['page'];
        }

        $page -= 1;
        $skipping = (int) ($page * $limit);

        $reservation = Reservation::skip($skipping)->take($limit);

        foreach ($params as $param => $value)
        {
            $tmp = explode('__', $param);

            if (isset($tmp[0]) and in_array($tmp[0], $fields) and isset($tmp[1]) and in_array($tmp[1], array_keys($ops)))
            {
                $field = $tmp[0];
                $op = $ops[$tmp[1]];

                $reservation = $reservation->where($field, $op, $value);
            }
        }

        return $reservation->get();
    }
}
