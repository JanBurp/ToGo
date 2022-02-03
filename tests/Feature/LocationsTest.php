<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use App\Models\Locations;

class LocationsTest extends TestCase
{

    var $testLocation = 'Nederland';

    public function test_post() {

        $response = $this->postJson('/api/locations',[ 'location' => $this->testLocation ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('location')
                    ->where('location', $this->testLocation )
                    ->where('visited', false )
                    ->etc()
            );

    }


    public function test_patch() {

        $response = $this->patchJson('/api/locations/1',[ 'visited' => true ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('location')
                    ->where('location', $this->testLocation )
                    ->where('visited', true )
                    ->etc()
            );

    }

    public function test_get() {

        $response = $this->getJson('/api/locations');

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('locations')
                    ->has('openrout_apikey')
            );

    }


    public function test_delete() {

        $response = $this->deleteJson('/api/locations/1');

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('deleted')
            );

    }




}
