<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CalendarTest extends TestCase
{
    private $days = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche"];
    private $months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];

    private $year, $month, $day;

    public function setUp()
    {
        parent::setUp();

        $this->year = (int) date('Y');
        $this->month = (int) date('m');
        $this->day = (int) date('d');
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testYear()
    {
        $this->visit("/calendar/$this->year")
             ->see($this->year);
    }

    public function testMonth()
    {
        $this->visit("/calendar/$this->year/$this->month")
             ->see($this->year)
             ->see($this->months[$this->month - 1]);
    }

    public function testDay()
    {
        $this->visit("/calendar/$this->year/$this->month/$this->day")
             ->see("$this->day " . $this->months[$this->month - 1] . " $this->year");
    }
}
