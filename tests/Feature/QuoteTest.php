<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    #[DataProvider('provideEndpoints')]
    public function testQuotesReturnWithAuthenticatedUser(string $endpoint, string $file, array $expected)
    {
        $user = $this->createAuthenticatedUser();

        $this->mockKanyeRestApiResponse($file);
        $response = $this->getJson($endpoint, [
            'Authorisation' => $user->generateToken(),
        ]);

        $response->assertExactJson(
            $expected
        );
    }

    private function mockKanyeRestApiResponse(string $fixtureFile): void
    {
        $responseBody = $this->getFixtureFileContent($fixtureFile);
        HTTP::fake([
            'https://api.kanye.rest/*' => Http::response($responseBody, 200),
        ]);
    }

    private function getFixtureFileContent(string $filename): string
    {
        return file_get_contents('tests/Fixtures/' . $filename);
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
                    'success' => 200,
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
                    'success' => 200,
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
                    'success' => 200,
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
            'kayne quotes with refresh' => [
                'api/kayne/quotes/3/refresh',
                'kayne_quote.json',
                [
                    'success' => 200,
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
