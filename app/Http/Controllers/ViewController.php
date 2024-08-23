<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ViewController extends Controller
{
    private const API_BASE_URL = 'http://127.0.0.1:3001/api/kayne/quotes/';
    //This whole thing is a horrible hack please ignore, just wanted something on frontend
    public function index()
    {
        $quotes = $this->fetchQuotes();

        return view('welcome')->with('quotes', $quotes);
    }

    public function refresh(Request $request)
    {
        $request->validate([
            'count' => 'required|integer|min:1',
        ]);

        $count = $request->input('count');
        $quotes = $this->fetchQuotes($count);

        return view('welcome')->with('quotes', $quotes);
    }

    private function fetchQuotes($count = '')
    {
        $user = User::factory()->create();
        $token = $user->generateToken();

        $endpoint = self::API_BASE_URL . $count . ($count ? '/refresh' : '');
        $response = Http::withHeader('Authorisation', $token)->timeout(5)->get($endpoint);

        return $this->extractQuotes($response);
    }
    private function extractQuotes($response)
    {
        $data = json_decode($response->body(), true);
        return $data['data']['quotes'] ?? [];
    }
}
