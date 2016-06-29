<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ReservationAPITest extends TestCase
{
    use WithoutMiddleware;

    private $payloads;

    public function setUp()
    {
        parent::setUp();

        Artisan::call('migrate');

        $this->payloads = factory(App\Reservation::class)->make()->toArray();
    }

    public function testStore()
    {
        $response = $this->call('POST', '/api/reservations', $this->payloads);
        $this->assertEquals(201, $response->status());
        return $response;
    }

    public function testIndex()
    {
        $this->testStore();
        $this->get('/api/reservations')
            ->seeJson($this->payloads);
    }

    public function testShowOK()
    {
        $response = $this->testStore();

        $uri = $this->getLocation($response->__toString());

        $this->get($uri)
            ->seeJson($this->payloads);
    }

    public function testShowNotFound()
    {
        $uri = str_replace("http://localhost", '', route('api.reservations.show', ['id' => 1337]));

        $this->get($uri)
            ->seeJson(['error' => 'not_found'])
            ->assertResponseStatus(404);
    }

    public function testUpdate()
    {
        $response = $this->testStore();

        $uri = $this->getLocation($response->__toString());

        $payloads = $this->payloads;

        $payloads['name'] = "Smith";
        $payloads['forename'] = "John";

        $this->put($uri, $payloads)
            ->assertResponseStatus(204);

        $this->get($uri)
            ->seeJson($payloads);
    }

    public function testUpdateNotFound()
    {
        $uri = str_replace("http://localhost", '', route('api.reservations.update', ['id' => 1337]));

        $payloads = $this->payloads;

        $payloads['name'] = "Smith";
        $payloads['forename'] = "John";

        $this->put($uri, $payloads)
            ->seeJson(['error' => 'not_found'])
            ->assertResponseStatus(404);
    }

    public function testDelete()
    {
        $response = $this->testStore();

        $uri = $this->getLocation($response->__toString());

        $this->delete($uri)->assertResponseStatus(204);

        $this->get($uri)->assertResponseStatus(404);
    }


    private function getLocation($headers)
    {
        $responseRaw = explode("\r\n", $headers);

        $uri = '/';

        foreach ($responseRaw as $header) {
            if(Str::contains($header, 'Location')){
                $uri = str_replace("http://localhost", '', $header);
                $uri = trim(explode(':', $uri)[1]);
            }
        }

        return $uri;
    }
}
