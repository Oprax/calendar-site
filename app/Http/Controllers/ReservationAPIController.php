<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Reservation;
use App\Http\Requests;
use App\Http\Requests\ReservationRequest;
use App\Http\Controllers\ReservationController;

use Carbon\Carbon;

/**
 * Class ReservationAPIController use for REST API
 * with data sending in JSON.
 *
 * @see \App\Http\Controllers\ReservationController
 * @package App\Http\Controllers
 */
class ReservationAPIController extends ReservationController
{
    /**
     * Use CORS {@link https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS CORS},
     * and force HTTPS on API.
     */
    public function __construct()
    {
        $this->middleware('cors');
        $this->middleware('secure');
        Carbon::setToStringFormat('d/m/Y');
    }

    /**
     * Display a listing of the reservation
     * with pagination and specific header
     * (`Content-Range` and `Accept-Range`).
     *
     * Data are sending in JSON.
     *
     * @see \App\Http\Controllers\ReservationController::index()
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
     * Store a newly created reservation in storage.
     * Send the URL of the newly reservation.
     *
     * @see \App\Http\Controllers\ReservationController::store()
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
     * Display the specified reservation.
     *
     * @see \App\Http\Controllers\ReservationController::show()
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
     * Update the specified reservation in storage.
     *
     * @see \App\Http\Controllers\ReservationController::update()
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
     * Remove the specified reservation from storage.
     *
     * @see \App\Http\Controllers\ReservationController::destroy()
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
