<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Reservation;

use Carbon\Carbon;

/**
 * Class CalendarController handle and generate calendar.
 * @package App\Http\Controllers
 */
class CalendarController extends Controller
{
    /**
     * List of day
     * @var array
     */
    private $days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];

    /**
     * List of month
     * @var array
     */
    private $months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];

    /**
     * Dispatcher
     *
     * @see App\Http\Controllers\CalendarController::year()
     * @see App\Http\Controllers\CalendarController::month()
     * @see App\Http\Controllers\CalendarController::day()
     * @param int $year
     * @param null|int $month
     * @param null|int $day
     * @return \Illuminate\View\View
     */
    public function main($year, $month = null, $day = null)
    {
        $year = (int) $year;

        if (is_null($month) and is_null($day)) {
            return $this->year($year);
        }

        if (!is_null($month) and is_null($day)) {
            $month = (int) $month;
            return $this->month($year, $month);
        }

        if (!is_null($month) and !is_null($day)) {
            $month = (int) $month;
            $day = (int) $day;
            return $this->day($year, $month, $day);
        }

        abort(400);
    }

    /**
     * Return view with Month choice.
     *
     * @param $year
     * @return \Illuminate\View\View
     */
    private function year($year)
    {
        return view('calendar.year', ['year' => $year, 'months' => $this->months]);
    }

    /**
     * Generate a calendar table (bootstrap style)
     * who can select day of month given.
     *
     * @param $year
     * @param $month
     * @return \Illuminate\View\View
     */
    private function month($year, $month)
    {
        $dt = Carbon::createFromDate($year, 1, 1);
        $dt_diff = Carbon::createFromDate($year, 1, 1)->endOfYear();

        $reservations = Reservation::whereBetween('arrive_at', [$dt, $dt_diff])->get();

        $tmp = [];

        foreach ($reservations as $reservation) {
            if($reservation->is_valid) {
                $reservation->arrive_at = Carbon::parse($reservation->arrive_at);
                $reservation->leave_at = Carbon::parse($reservation->leave_at);
                $tmp[] = $reservation;
            }
        }

        $reservations = $tmp;
        unset($tmp);

        $isTaken = [];

        if (count($reservations) > 0)
        {
            foreach($reservations as $reservation)
            {
                $current = Carbon::createFromDate($year, $month, 1);

                while ($current->month == $month) {
                    $leave_at = Carbon::instance($reservation->leave_at);
                    if($current->between($reservation->arrive_at, $leave_at->addDay())) {
                        $isTaken[] = $current->day;
                    }
                    $current->addDay();
                }
            }
        }

        $isTaken = array_unique($isTaken, SORT_NUMERIC);

        $dt = Carbon::createFromDate($year, $month, 1);

        $daysInMonth = [];

        while($dt->month == $month)
        {
            $daysInMonth[$dt->day] = str_replace('0', '7', $dt->dayOfWeek);
            $dt->addDay();
        }

        $table = '<table class="ui table"><thead><tr>';
        
        foreach($this->days as $d)
        {
            $table .= '<th><h4 class="ui center aligned header">' .substr($d, 0, 3). '</h4></th>';
        }

        $table .= '</tr></thead><tbody><tr>';

        foreach($daysInMonth as $d => $w)
        {
            if($d == 1 && ($w - 1) != 0) {
                $table .= '<td colspan="'.($w - 1).'"></td>';
            }
            
            $url = route('calendar.main', ['year' => $year, 'month' => $month, 'day' => $d]);

            if(in_array($d, $isTaken)) {
                $table .= '<td class="center aligned"><a class="ui button primary" href="'.$url.'">' .$d. '</a></td>';
            } else {
                $table .= '<td class="center aligned"><a class="ui button" href="'.$url.'">' .$d. '</a></td>';
            }
            
            
            end($daysInMonth);
            if($w == 7 && $d != key($daysInMonth)) {
                $table .= '</tr><tr>';
            }
        }
        
        $end = end($daysInMonth);
        if($end != 7)
        {
            $table .= '<td colspan="'.(7 - $end).'"></td>';
        }
        
        $table .= '</tr></tbody></table>';

        
        $monthLitt = $this->months[$month - 1];
        return view('calendar.month', compact('month', 'monthLitt', 'year', 'table'));
    }

    /**
     * List of Reservation in date given.
     *
     * @param $year
     * @param $month
     * @param $day
     * @return \Illuminate\View\View
     */
    private function day($year, $month, $day)
    {
        $dt = Carbon::createFromDate($year, 1, 1);
        $dt_diff = Carbon::createFromDate($year, 1, 1)->endOfYear();

        $reservations = Reservation::whereBetween('arrive_at', [$dt, $dt_diff])->get();

        $tmp = [];

        foreach ($reservations as $reservation) {
            if($reservation->is_valid) {
                $reservation->arrive_at = Carbon::parse($reservation->arrive_at);
                $reservation->leave_at = Carbon::parse($reservation->leave_at);
                $tmp[] = $reservation;
            }
        }

        $reservations = $tmp;

        $dt = Carbon::createFromDate($year, $month, $day);
        $isTaken = [];

        if (count($reservations) > 0)
        {
            foreach($reservations as $reservation)
            {
                $arrive_at = $reservation->arrive_at;
                $leave_at = $reservation->leave_at;
                if($dt->between($arrive_at, $leave_at->addDay(), true)) {
                    $isTaken[] = $reservation;
                }
            }
        }

        
        $monthLitt = $this->months[$month - 1];
        $months = $this->months;
        return view('calendar.day', compact('month', 'months', 'monthLitt', 'year', 'day', 'isTaken'));
    }
}
