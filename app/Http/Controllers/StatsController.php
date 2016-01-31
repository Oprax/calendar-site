<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Reservation;

use Carbon\Carbon;


/**
 * Class StatsController process statistics data.
 * @package App\Http\Controllers
 */
class StatsController extends Controller
{
    /**
     * Max person could be accepted.
     * @var int
     */
    public static $MAX = 11;

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
     * Instantiate a new StatsController instance.
     * Statistics is for Administrators.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Return list of year have statistics data.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $title = "Statistiques";
        return view('stats.index', compact('title'));
    }

    /**
     * Process and generate data could be accepted by
     * {@link http://www.highcharts.com/ Charts}
     * for a given year.
     *
     * @param $year
     * @return \Illuminate\View\View
     */
    public function chart($year)
    {
        $dt = Carbon::createFromDate($year, 1, 1);
        $dt_diff = Carbon::createFromDate($year, 1, 1)->endOfYear();

        $reservations = Reservation::whereBetween('arrive_at', [$dt, $dt_diff])->where('is_valid', true)->get();

        $tmp = [];

        foreach($reservations as $reservation)
        {
            $arrive_at = $reservation->arrive_at;
            $leave_at = $reservation->leave_at;

            while ($arrive_at->lte($leave_at))
            {
                $month = $this->months[$arrive_at->month - 1];

                if (empty($tmp[$arrive_at->month][$arrive_at->day])) {
                    $tmp[$arrive_at->month][$arrive_at->day] = 0;
                }

                $tmp[$arrive_at->month][$arrive_at->day] += $reservation->nb_people;
                
                
                $arrive_at->addDay();
            }
        }

        $monthly = [
            'categories' => [],
            'data' => [],
        ];
        
        $daily = [];

        foreach($tmp as $month => $list)
        {
            foreach($list as $day => $nb)
            {
                $daily[$month]['categories'][] = $day;
                $daily[$month]['data'][] = round($nb / self::$MAX * 100);
            }

            $monthly['categories'][] = $month;
            $monthly['data'][] = round(max($list) / self::$MAX * 100);
        }


        ksort($daily);

        foreach($daily as $month => $value)
        {
            asort($value['categories']);
            $keys = array_keys($value['categories']);
            $tmp = [];
            foreach ($keys as $i => $key) {
                $tmp[$i] = $value['data'][$key];
            }
            $value['data'] = $tmp;
            $value['categories'] = array_values($value['categories']);
            $daily[$month] = $value;
        }


        asort($monthly['categories']);
        $keys = array_keys($monthly['categories']);
        $tmp = [];
        foreach ($keys as $i => $key) {
            $tmp[$i] = $monthly['data'][$key];
        }
        $monthly['data'] = $tmp;
        $monthly['categories'] = array_values($monthly['categories']);

        $months = $this->months;

        return view('stats.chart', compact('year', 'monthly', 'daily', 'months'));
    }
}
