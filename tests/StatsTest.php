<?php

use Illuminate\Support\Facades\Artisan;

class StatsTest extends TestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');

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
