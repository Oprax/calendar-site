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
            'arrive_at' => '22/04/2013',
            'leave_at' => '05/05/2013',
            'nb_people' => 1,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Berthold',
            'forename' => 'Patricia',
            'email' => 'null',
            'arrive_at' => '17/05/2013',
            'leave_at' => '26/05/2013',
            'nb_people' => 2,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Fernand',
            'email' => 'null',
            'arrive_at' => '30/06/2013',
            'leave_at' => '01/09/2013',
            'nb_people' => 2,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Wendling',
            'forename' => 'Philippe',
            'email' => 'null',
            'arrive_at' => '06/07/2013',
            'leave_at' => '12/07/2013',
            'nb_people' => 4,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Brigitte',
            'email' => 'null',
            'arrive_at' => '16/07/2013',
            'leave_at' => '02/08/2013',
            'nb_people' => 2,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Muller',
            'forename' => 'Eric',
            'email' => 'null',
            'arrive_at' => '10/08/2013',
            'leave_at' => '18/08/2013',
            'nb_people' => 3,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Demeyer',
            'forename' => 'Claude',
            'email' => 'null',
            'arrive_at' => '16/08/2013',
            'leave_at' => '19/08/2013',
            'nb_people' => 4,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Fernand',
            'email' => 'null',
            'arrive_at' => '18/04/2014',
            'leave_at' => '04/05/2014',
            'nb_people' => 1,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Muller',
            'forename' => 'Sylvie',
            'email' => 'null',
            'arrive_at' => '28/04/2014',
            'leave_at' => '04/05/2014',
            'nb_people' => 6,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Berthold',
            'forename' => 'Patricia',
            'email' => 'null',
            'arrive_at' => '17/05/2014',
            'leave_at' => '01/06/2014',
            'nb_people' => 2,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Berthold',
            'forename' => 'Céline',
            'email' => 'null',
            'arrive_at' => '22/05/2014',
            'leave_at' => '25/05/2014',
            'nb_people' => 1,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Muller',
            'forename' => 'Sylvie',
            'email' => 'null',
            'arrive_at' => '10/07/2014',
            'leave_at' => '19/07/2014',
            'nb_people' => 3,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Brigitte',
            'email' => 'null',
            'arrive_at' => '13/07/2014',
            'leave_at' => '02/08/2014',
            'nb_people' => 1,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Fernand',
            'email' => 'null',
            'arrive_at' => '28/06/2014',
            'leave_at' => '31/08/2014',
            'nb_people' => 1,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Killich',
            'forename' => 'Nicolas',
            'email' => 'null',
            'arrive_at' => '30/26/2014',
            'leave_at' => '02/08/2014',
            'nb_people' => 1,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Muller',
            'forename' => 'Laura',
            'email' => 'null',
            'arrive_at' => '11/07/2014',
            'leave_at' => '19/07/2014',
            'nb_people' => 1,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Fernand',
            'email' => 'null',
            'arrive_at' => '22/02/2015',
            'leave_at' => '08/03/2015',
            'nb_people' => 1,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Berthold',
            'forename' => 'Patricia',
            'email' => 'null',
            'arrive_at' => '10/05/2015',
            'leave_at' => '25/05/2015',
            'nb_people' => 2,
            'is_valid' => true
        ]);

        Reservation::create([
            'name' => 'Schneider',
            'forename' => 'Fernand',
            'email' => 'null',
            'arrive_at' => '26/04/2015',
            'leave_at' => '10/05/2015',
            'nb_people' => 2,
            'is_valid' => true
        ]);
    }
}
