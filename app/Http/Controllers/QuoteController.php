<?php

namespace App\Http\Controllers;

use App\Facades\Quote;
use Illuminate\Http\JsonResponse;

class QuoteController extends Controller
{
    public function getQuotesWithoutRefresh($name, $count = 5): JsonResponse
    {
        return $this->getQuotes($name, $count);
    }

    public function getRefreshedQuotes($name, $count = 5): JsonResponse
    {
        return $this->getQuotes($name, $count, true);
    }

    private function getQuotes($name, $count = 5, $refresh = false): JsonResponse
    {
        $driverName = $this->_getDriver($name);

        $quoteDriver = Quote::driver($driverName);

        if ($refresh) {
            $quoteDriver->clearCache();
        }

        $quotes = $quoteDriver
            ->setCount($count)
            ->getQuotes();

        //todo extract the response
        return response()->json([
            'success' => true,
            'data' => $quotes,
        ]);
    }

    private function _getDriver($name)
    {
        //todo validate driver name, throw exception & test both
        return $name;
    }

}
