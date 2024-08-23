<?php

namespace App\Http\Controllers;

use App\Facades\Quote;
use Illuminate\Http\JsonResponse;
use App\Traits\ApiResponses;

class QuoteController extends Controller
{
    use ApiResponses;

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
        $quoteDriver = Quote::driver($driverName)->setCount($count);

        if ($refresh) {
            $quoteDriver->clearCache();
        }

        $quotes = $quoteDriver
            ->getQuotes();

        return $this->successResponse($quotes);
    }

    private function _getDriver($name)
    {
        //todo validate driver name, throw exception & test both
        return $name;
    }

}
