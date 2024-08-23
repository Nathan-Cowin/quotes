<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    #[DataProvider('provideEndpoints')]
    public function test_quotes_returns_with_authenticated_user(string $endpoint, string $file, array $expected)
    {
        $user = $this->createAuthenticatedUser();

        $this->mockKanyeRestApiResponse($file);
        $this->assertQuotesResponse($endpoint, $user->generateToken(), $expected);
    }

    public function test_quotes_are_being_cached()
    {
        $user = $this->createAuthenticatedUser();
        $token = $user->generateToken();
        $this->mockMultipleKanyeRestApiResponses();

        $expectedJson = [
            'status' => 200,
            'data' => [
                'quotes' => [
                    "People say it's enough and I got my point across ... the point isn't across until we cross the point\n",
                    "I'm giving all Good music artists back the 50% share I have of their masters\n"
                ]
            ]
        ];

        $this->assertQuotesResponse('api/kayne/quotes/2', $token, $expectedJson);
        $this->assertQuotesResponse('api/kayne/quotes/2', $token, $expectedJson);
    }

    public function test_refresh_clears_cache()
    {
        $user = $this->createAuthenticatedUser();
        $token = $user->generateToken();
        $this->mockMultipleKanyeRestApiResponses();

        $initialExpectedJson = [
            'status' => 200,
            'data' => [
                'quotes' => [
                    "People say it's enough and I got my point across ... the point isn't across until we cross the point\n",
                    "I'm giving all Good music artists back the 50% share I have of their masters\n"
                ]
            ]
        ];

        $refreshedExpectedJson = [
            'status' => 200,
            'data' => [
                'quotes' => [
                    "I'm giving all Good music artists back the 50% share I have of their masters\n",
                    "People say it's enough and I got my point across ... the point isn't across until we cross the point\n"
                ]
            ]
        ];

        $this->assertQuotesResponse('api/kayne/quotes/2', $token, $initialExpectedJson);
        $this->assertQuotesResponse('api/kayne/quotes/2/refresh', $token, $refreshedExpectedJson);
    }

    public function test_quotes_returns_with_non_authenticated_user()
    {
        $response = $this->getJson('api/kayne/quotes/1', [
            'Authorisation' => '',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    private function mockKanyeRestApiResponse(string $fixtureFile): void
    {
        $responseBody = $this->getFixtureFileContent($fixtureFile);
        HTTP::fake([
            'https://api.kanye.rest/*' => Http::response($responseBody, 200),
        ]);
    }

    private function mockMultipleKanyeRestApiResponses(): void
    {
        $responseBody = $this->getFixtureFileContent('kayne_quote.json');
        $responseBodySecondary = $this->getFixtureFileContent('kayne_quote_2.json');

        HTTP::fake([
            'https://api.kanye.rest/*' => Http::sequence()
                ->push($responseBody, 200)
                ->push($responseBodySecondary, 200)
                ->push($responseBodySecondary, 200)
                ->push($responseBody, 200)
        ]);
    }

    private function getFixtureFileContent(string $filename): string
    {
        return file_get_contents('tests/Fixtures/' . $filename);
    }

    private function assertQuotesResponse(string $endpoint, string $token, array $expectedJson): void
    {
        $response = $this->getJson($endpoint, [
            'Authorisation' => $token,
        ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson($expectedJson);
    }

    private function createAuthenticatedUser(): User
    {
        return User::factory()->create();
    }

    public static function provideEndpoints(): array
    {
        return [
            'kayne quotes with count' => [
                'api/kayne/quotes/1',
                'kayne_quote.json',
                [
                    'status' => 200,
                    'data' => [
                        'quotes' => [
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n"
                        ]
                    ]
                ]
            ],
            'kayne quotes with count multiple' => [
                'api/kayne/quotes/2',
                'kayne_quote.json',
                [
                    'status' => 200,
                    'data' => [
                        'quotes' => [
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n",
                            "People say it's enough and I got my point across ... the point isn't across until we cross the point\n"
                        ]
                    ]
                ]
            ],
            'kayne quotes with default count' => [
                'api/kayne/quotes',
                'kayne_quote.json',
                [
                    'status' => 200,
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
            'kayne quotes with with refresh to clear cache' => [
                'api/kayne/quotes/3/refresh',
                'kayne_quote.json',
                [
                    'status' => 200,
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
