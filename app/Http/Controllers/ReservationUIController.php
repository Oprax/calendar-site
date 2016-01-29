<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ReservationRequest;
use App\Http\Controllers\ReservationController;

use Carbon\Carbon;


class ReservationUIController extends ReservationController
{
    /**
     * Instantiate a new ReservationController instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['create', 'store', 'show', 'index']]);
        Carbon::setToStringFormat('Y-m-d');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        extract(parent::index($request));

        $reservations = $reservations->items();

        $title = "Réservations";

        return view('reservations.index', compact('title', 'reservations'));
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

        $context['title'] = "Réservation formulaire";
        return view('reservations.create', $context);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ReservationRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationRequest $request)
    {
        extract(parent::store($request));

        return redirect()->route('reservations.show', $reservation);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        extract(parent::show($id));

        $title = "Réservation";

        $reservation->arrive_at = Carbon::parse($reservation->arrive_at);
        $reservation->leave_at = Carbon::parse($reservation->leave_at);

        return view('reservations.show', compact('title', 'reservation'));
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
        return view('reservations.edit', compact('title', 'reservation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationRequest $request, $id)
    {
        extract(parent::update($request, $id));

        return redirect()->route('reservations.show', $reservation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        extract(parent::destroy($id));
        return back();
    }
}
