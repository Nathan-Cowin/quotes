<?php

namespace App\Services\Quotes;

use App\Interfaces\QuotesApiDriver;

class KayneDriver implements QuotesApiDriver
{
    public function test(string $test): string
    {
        return $test;
    }
}
