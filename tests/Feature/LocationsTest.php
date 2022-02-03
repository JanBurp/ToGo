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
    var $testID       = -1;


    public function test_location_crud() {

        // POST
        $response = $this->postJson('/api/locations',[ 'location' => $this->testLocation ]);
        $responseData = $response->getOriginalContent();
        $this->testID = $responseData['id'];
        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('location')
                    ->where('location', $this->testLocation )
                    ->where('visited', false )
                    ->etc()
            );

        // PATCH
        $response = $this->patchJson('/api/locations/' . $this->testID ,[ 'visited' => true ]);
        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('location')
                    ->where('location', $this->testLocation )
                    ->where('visited', true )
                    ->etc()
            );


        // GET
        $response = $this->getJson('/api/locations');
        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('locations')
                    ->has('openrout_apikey')
            );


        // DELETE
        $response = $this->deleteJson('/api/locations/' . $this->testID);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('deleted')
            );

    }


}
