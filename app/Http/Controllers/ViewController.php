<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ViewController extends Controller
{
    private const API_BASE_URL = 'http://127.0.0.1:3001/api/kayne/';

    //This whole thing is a horrible hack please ignore, just wanted something on frontend
    public function index(): View
    {
        $quotes = $this->fetchQuotes();

        return view('welcome')->with('quotes', $quotes);
    }

    public function refresh(Request $request): View
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
        $endpoint = self::API_BASE_URL . ($count ? 'refresh/' : 'quotes/') . $count;
        $response = Http::withHeader('Authorisation', env('LOCAL_API_TOKEN'))->timeout(5)->get($endpoint);

        return $this->extractQuotes($response);
    }

    private function extractQuotes($response)
    {
        $data = json_decode($response->body(), true);
        return $data['data']['quotes'] ?? [];
    }
}
