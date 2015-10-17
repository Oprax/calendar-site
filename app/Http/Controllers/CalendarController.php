<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Reservation;

use Carbon\Carbon;

class CalendarController extends Controller
{
    private $days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
    private $months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
    
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

        return abort(404);
    }

    private function year($year)
    {
        return view('calendar.year', ['year' => $year, 'months' => $this->months]);
    }

    private function month($year, $month)
    {
        $dt = Carbon::createFromDate($year, 1, 1);
        $dt_diff = Carbon::createFromDate($year, 1, 1)->endOfYear();

        $reservations = Reservation::whereBetween('arrive_at', [$dt, $dt_diff])->get();

        $tmp = [];

        foreach ($reservations as $reservation) {
            if($reservation->is_valid) {
                $tmp[] = $reservation;
            }
        }

        $reservations = $tmp;

        $isTaken = [];

        if (count($reservations) > 0)
        {
            foreach($reservations as $reservation)
            {
                $current = Carbon::createFromDate($year, $month, 1);

                while ($current->month == $month) {
                    if($current->between($reservation->arrive_at, $reservation->leave_at->addDay(), true)) {
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

        $table = '<table class="table table-striped text-center"><thead><tr>';
        
        foreach($this->days as $d)
        {
            $table .= '<td><h5>' .substr($d, 0, 3). '</h5></td>';
        }

        $table .= '</tr></thead><tbody><tr>';

        foreach($daysInMonth as $d => $w)
        {
            if($d == 1 && ($w - 1) != 0) {
                $table .= '<td colspan="'.($w - 1).'"></td>';
            }
            
            $url = route('calendar.main', ['year' => $year, 'month' => $month, 'day' => $d]);
            if(in_array($d, $isTaken)) {
                $table .= '<td><a class="btn btn-primary" href="'.$url.'">' .$d. '</a></td>';
            } else {
                $table .= '<td><a class="btn" href="'.$url.'">' .$d. '</a></td>';
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

    private function day($year, $month, $day)
    {
        $dt = Carbon::createFromDate($year, 1, 1);
        $dt_diff = Carbon::createFromDate($year, 1, 1)->endOfYear();

        $reservations = Reservation::whereBetween('arrive_at', [$dt, $dt_diff])->get();

        $tmp = [];

        foreach ($reservations as $reservation) {
            if($reservation->is_valid) {
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
