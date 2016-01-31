<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatsTest extends TestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(App\User::class)->create();
    }

    public function testIndex()
    {
        $this->actingAs($this->user)
             ->visit("/stats")
             ->see("Satistiques");
    }

    public function testChart()
    {
        $year = date('Y');

        $this->actingAs($this->user)
             ->visit("/stats/$year")
             ->see("$year");
    }
}
