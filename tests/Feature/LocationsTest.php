<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

use App\Models\Locations;

class LocationsTest extends TestCase
{


    public function test_location_crud() {

        $testLocation = Locations::factory()->make();

        // POST
        $response = $this->postJson('/api/locations', $testLocation->toArray() );
        $responseData = $response->getOriginalContent();
        $testID = $responseData['id'];
        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('location')
                    ->where('location', $testLocation->location )
                    ->where('visited', $testLocation->visited )
                    ->etc()
            );

        // PATCH
        $response = $this->patchJson('/api/locations/' . $testID ,[ 'visited' => true ]);
        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('location')
                    ->where('location', $testLocation->location )
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


        // PAGE test
        $response = $this->get('/location/' . $testID);
        $response->assertStatus(200);


        // DELETE
        $response = $this->deleteJson('/api/locations/' . $testID);
        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->has('deleted')
            );

    }


    public function test_location_page() {

        $response = $this->get('/location/should_give_nice_error');
        $response->assertStatus(200);

        $first = Locations::first();
        if ($first) {
            $response = $this->get('/location/' . $first->id);
            $response->assertStatus(200);
        }

    }


}
