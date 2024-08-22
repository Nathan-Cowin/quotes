<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testQuotesReturns() {

       $response =  $this->json('get', 'api/quotes');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data'
                ]
            );
    }
}
