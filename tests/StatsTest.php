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

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $this->actingAs($this->user)
             ->visit("/stats")
             ->see("Satistiques");
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testChart()
    {
        $year = date('Y');

        $this->actingAs($this->user)
             ->visit("/stats/$year")
             ->see("$year");
    }
}
