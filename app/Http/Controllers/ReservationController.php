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
        $this->middleware('auth', ['except' => ['create', 'store', 'show']]);
        Carbon::setToStringFormat('d/m/Y');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = "Réservations";
        $reservations = Reservation::get();
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

        $this->sendMail('emails.new', $reservation->toArray(), ['romuller67@hotmail.fr']);
        
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

    public function saveOld()
    {
        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Fernand',
            'email' => 'null',
            'arrive_at' => '2013-04-22',
            'leave_at' => '2013-05-05',
            'nb_people' => 1,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Berthold',
            'forename' => 'Patricia',
            'email' => 'null',
            'arrive_at' => '2013-05-17',
            'leave_at' => '2013-05-26',
            'nb_people' => 2,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Fernand',
            'email' => 'null',
            'arrive_at' => '2013-06-30',
            'leave_at' => '2013-09-01',
            'nb_people' => 2,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Wendling',
            'forename' => 'Philippe',
            'email' => 'null',
            'arrive_at' => '2013-07-06',
            'leave_at' => '2013-07-12',
            'nb_people' => 4,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Brigitte',
            'email' => 'null',
            'arrive_at' => '2013-07-16',
            'leave_at' => '2013-08-02',
            'nb_people' => 2,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Muller',
            'forename' => 'Eric',
            'email' => 'null',
            'arrive_at' => '2013-08-10',
            'leave_at' => '2013-08-18',
            'nb_people' => 3,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Demeyer',
            'forename' => 'Claude',
            'email' => 'null',
            'arrive_at' => '2013-08-16',
            'leave_at' => '2013-08-19',
            'nb_people' => 4,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Fernand',
            'email' => 'null',
            'arrive_at' => '2014-04-18',
            'leave_at' => '2014-05-04',
            'nb_people' => 1,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Muller',
            'forename' => 'Sylvie',
            'email' => 'null',
            'arrive_at' => '2014-04-28',
            'leave_at' => '2014-05-04',
            'nb_people' => 6,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Berthold',
            'forename' => 'Patricia',
            'email' => 'null',
            'arrive_at' => '2014-05-17',
            'leave_at' => '2014-06-01',
            'nb_people' => 2,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Berthold',
            'forename' => 'Céline',
            'email' => 'null',
            'arrive_at' => '2014-05-22',
            'leave_at' => '2014-05-25',
            'nb_people' => 1,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Muller',
            'forename' => 'Sylvie',
            'email' => 'null',
            'arrive_at' => '2014-07-10',
            'leave_at' => '2014-07-19',
            'nb_people' => 3,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Brigitte',
            'email' => 'null',
            'arrive_at' => '2014-07-13',
            'leave_at' => '2014-08-02',
            'nb_people' => 1,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Fernand',
            'email' => 'null',
            'arrive_at' => '2014-06-28',
            'leave_at' => '2014-08-31',
            'nb_people' => 1,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Killich',
            'forename' => 'Nicolas',
            'email' => 'null',
            'arrive_at' => '2014-06-30',
            'leave_at' => '2014-08-02',
            'nb_people' => 1,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Muller',
            'forename' => 'Laura',
            'email' => 'null',
            'arrive_at' => '2014-07-11',
            'leave_at' => '2014-07-19',
            'nb_people' => 1,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Fernand',
            'email' => 'null',
            'arrive_at' => '2015-02-22',
            'leave_at' => '2015-03-08',
            'nb_people' => 1,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Berthold',
            'forename' => 'Patricia',
            'email' => 'null',
            'arrive_at' => '2015-05-10',
            'leave_at' => '2015-05-25',
            'nb_people' => 2,
            'is_valid' => true
        ])->save();

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Fernand',
            'email' => 'null',
            'arrive_at' => '2015-04-26',
            'leave_at' => '2015-05-10',
            'nb_people' => 2,
            'is_valid' => true
        ])->save();
    }
}
