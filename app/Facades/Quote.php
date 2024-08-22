<?php

namespace App\Facades;

use App\Services\Quotes\QuotesManager;
use Illuminate\Support\Facades\Facade;

class Quote extends Facade
{
    /**
     * @method static string driver(string $driver = null)
     * @method static string getMultipleQuotes(int $count)
     *
     * @see QuotesManager
     */
    protected static function getFacadeAccessor()
    {
        return QuotesManager::class;
    }

}
