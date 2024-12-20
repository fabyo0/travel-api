<?php

namespace Tests\Feature;

use App\Models\Travel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TravelsListTest extends TestCase
{
    use RefreshDatabase;

    public function test_travels_list_return_pagination()
    {
        Travel::factory(16)->create(['is_public' => true]);

        $response = $this->get('http://travel-api.test/api/v1/travels');
        $response->assertStatus(200);

        // Check data count
        $response->assertJsonCount(15, 'data');

        // Check total pages
        $response->assertJsonPath('meta.last_page', 2);
    }

    public function test_travels_list_shows_only_public_records()
    {
        $nonPublicTravel = Travel::factory()->create(['is_public' => false]);
        $publicTravel = Travel::factory()->create(['is_public' => true]);

        $response = $this->get('/api/v1/travels');
        $response->assertStatus(200);

        // Check only public record
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['id' => $publicTravel->id]);
        $response->assertJsonMissing(['id' => $nonPublicTravel->id]);
    }
}
