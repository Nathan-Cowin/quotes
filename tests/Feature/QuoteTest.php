<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
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

    /**
     * @dataProvider provideEndpoints
     */
    public function testQuotesReturns($endpoint, $file, $expected)
    {
        $body = file_get_contents('tests/Fixtures/' . $file);
        HTTP::fake([
            'https://api.kanye.rest/*' => Http::response($body, 200),
        ]);

       $response = $this->json('get', $endpoint);

       $response->assertExactJson(
           $expected
       );
    }

    public static function provideEndpoints(): array
    {
        return [
            'good endpoint with count of 1' => [
                'api/kayne/quotes/1',
                'kayne_quote.json',
                [
                    'success' => true,
                    'data' => [
                        'quotes' => [
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n"
                        ]
                    ]
                ]
            ],
            'good endpoint with count of 2' => [
                'api/kayne/quotes/2',
                'kayne_quote.json',
                [
                    'success' => true,
                    'data' => [
                        'quotes' => [
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n",
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n"
                        ]
                    ]
                ]
            ],
            'test endpoint with default count of 5' => [
                'api/kayne/quotes',
                'kayne_quote.json',
                [
                    'success' => true,
                    'data' => [
                        'quotes' => [
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n",
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n",
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n",
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n",
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n",
                        ]
                    ]
                ]
            ],
            'test refresh endpoint with count' => [
                'api/kayne/quotes/3/refresh',
                'kayne_quote.json',
                [
                    'success' => true,
                    'data' => [
                        'quotes' => [
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n",
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n",
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n",
                        ]
                    ]
                ]
            ],
        ];
    }
}
