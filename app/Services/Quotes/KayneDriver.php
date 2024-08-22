<?php

namespace App\Services\Quotes;

use App\Interfaces\QuotesApiDriver;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class KayneDriver implements QuotesApiDriver
{
    private int $count;

    public function setCount(int $count): KayneDriver
    {
        $this->count = $count;
        return $this;
    }
    public function getQuotes(): array
    {
        if(!isset($this->count)){
            //todo throw exception and test this
            return 'set the count';
        }
        $cacheKey = 'quotes_' . $this->count;

        return Cache::remember($cacheKey, now()->addMinutes(5), function () {

            $quotes = ['quotes' => []];
            for ($i = 0; $i < $this->count; $i++) {
                $quote = $this->_getQuote();
                //todo $this->_checkQuoteIsUnique(); create method to check for duplicates then call itself if so
                $quotes['quotes'][] = $quote;
            }
            return $quotes;
        });
    }

    public function clearCache(): void
    {
        Cache::forget('quotes');
    }

    private function _getQuote(): string
    {
        $endpoint = config('services.quotes.kanye.endpoint_text');
        $response = Http::get($endpoint);
        return $response->body();
    }
}
