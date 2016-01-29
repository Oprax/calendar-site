<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Reservation;
use App\Http\Requests;
use App\Http\Requests\ReservationRequest;
use App\Http\Controllers\ReservationController;

use Carbon\Carbon;

class ReservationAPIController extends ReservationController
{
    /**
     * Instantiate a new ReservationController instance.
     *
     */
    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('secure');
        Carbon::setToStringFormat('d/m/Y');
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

        $statues = 200;

        if($reservations->hasMorePages()) {
            $statues = 206;
        }

        $count = count($reservations->items());

        return response()
            ->json($reservations, $statues)
            ->header('Content-Range', "{$reservations->firstItem()}-{$reservations->lastItem()}/$count")
            ->header('Accept-Range', "reservations {$reservations->total()}");
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

        return response(null, 201)
            ->header('Location', route('api.reservations.show', $reservation));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function show($id)
    {
        try {
            extract(parent::show($id));
        } catch(ModelNotFoundException $e) {
            return response()
                ->json([
                    'error' => 'not_found',
                    'error_description' => "The reservation with the id '$id' doesn't exist.",
                ], 404);
        }

        return response()
            ->json($reservation, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ReservationRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ReservationRequest $request, $id)
    {
        try {
            extract(parent::update($request, $id));
        } catch(ModelNotFoundException $e) {
            return response()
                ->json([
                    'error' => 'not_found',
                    'error_description' => "The reservation with the id '$id' doesn't exist.",
                ], 404);
        }

        return response(null, 204)
            ->header('Location', route('api.reservations.show', $reservation));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function destroy($id)
    {
        try {
            extract(parent::destroy($id));
        } catch(ModelNotFoundException $e) {
            return response()
                ->json([
                    'error' => 'not_found',
                    'error_description' => "The reservation with the id '$id' doesn't exist.",
                ], 404);
        }

        return response(null, 204);
    }
}
