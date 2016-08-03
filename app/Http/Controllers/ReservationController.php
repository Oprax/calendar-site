<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ReservationRequest;
use App\Http\Controllers\Controller;

use App\Reservation;

use Validator;

use Carbon\Carbon;

/**
 * Logical part of Reservation module,
 * separated to a better handle of URI and middleware,
 * return only data (array).
 *
 * Class ReservationController
 * @package App\Http\Controllers
 */
class ReservationController extends Controller
{
    /**
     * Get a listing of reservations.
     * Have filter and some preference.
     *
     * @param  Request  $request
     * @return array
     */
    public function index(Request $request)
    {
        $reservations = $this->buildFilterQuery($request->all());

        return compact('reservations');
    }

    /**
     * Store and check a newly created reservations in storage,
     * and send an email to administrators for information.
     *
     * @param ReservationRequest|Request $request
     * @return array
     */
    public function store(ReservationRequest $request)
    {
        $reservation = new Reservation($request->all());
        $reservation->is_valid = false;

        $reservation->save();

        $dest = explode(',', env('MAIL_ADMIN'));

        $this->sendMail('emails.new', $reservation->toArray(), $dest);

        return compact('reservation');
    }

    /**
     * Display the specified reservation.
     *
     * @param  int $id
     * @return array
     */
    public function show($id)
    {
        $reservation = Reservation::findOrFail($id);

        return compact('reservation');
    }

    /**
     * Update and check the specified resource in storage.
     * Send an email to user if reservation is accepted.
     *
     * @param ReservationRequest|Request $request
     * @param  int $id
     * @return array
     */
    public function update(ReservationRequest $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $is_valid = $reservation->is_valid;
        $reservation->update($request->all());
        $reservation->save();

        $reservationMail = $reservation->toArray();

        $reservationMail['arrive_at'] = Carbon::parse($reservation['arrive_at'])->format('d/m/Y');
        $reservationMail['leave_at'] = Carbon::parse($reservation['leave_at'])->format('d/m/Y');

        if($reservation->is_valid and $reservation->is_valid != $is_valid) {
            $this->sendMail('emails.confirm', $reservationMail);
        }

        return compact('reservation');
    }


    /**
     * Remove the specified reservation from storage.
     * Informe with email to user the reservation is delete.
     *
     * @param  int  $id
     * @return array
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);

        $reservationMail = $reservation->toArray();

        $reservationMail['arrive_at'] = Carbon::parse($reservation['arrive_at'])->format('d/m/Y');
        $reservationMail['leave_at'] = Carbon::parse($reservation['leave_at'])->format('d/m/Y');

        $reservation->delete();

        $r = $this->sendMail('emails.refuse', $reservationMail);

        return compact('r');
    }

    /**
     * Helper to send Email
     * 
     * @param  string        $view    The name of blade view
     * @param  array         $data    Array contains information like email or name
     * @param  string|array  $to      'To' array, if empty use data email
     * @return Validator
     */
    protected function sendMail($view, array $data, $to = null)
    {
        if(is_null($to)) {
            $to = $data['email'];
        }

        return \Mail::queue([$view, $view.'-txt'], $data, function ($message) use ($to)
        {
            $message->to($to);
        });
    }

    /**
     * Helper to build DataBase Query
     * with filter and fields selection.
     * 
     * @param  array  $params
     * @return Illuminate\Database\Eloquent\Collection
     */
    protected function buildFilterQuery(array $params)
    {
        $ops = [
            'eq'  => '=',
            'lte' => '<=',
            'gte' => '>=',
            'lt'  => '<',
            'gt'  => '>',
        ];

        $fields = ['name', 'forename', 'arrive_at', 'leave_at', 'nb_people'];

        $limit = 10;
        $page = null;

        if (isset($params['limit']) and $params['limit'] > 0 and $params['limit'] < 100) {
            $limit = (int) $params['limit'];
        }

        if (isset($params['page']) and $params['page'] > 0) {
            $page = (int) $params['page'];
        }

        $select = ['*'];

        if (!empty($params['fields'])) {
            $select = explode(',', $params['fields']);
        }

        $reservation = Reservation::select($select);
        $reservation->addSelect('id');

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

        if (!empty($params['valid'])) {
            $valid = $params['valid'] == 'true' ? true : false;
            $reservation = $reservation->where('is_valid', '=', $valid);
        }

        return $reservation->paginate($perPage = $limit, $columns = array('*'), $pageName = 'page', $page = $page);
    }
}
