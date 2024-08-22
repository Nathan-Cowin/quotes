<?php
namespace App\Interfaces;

use Carbon\CarbonInterface;

interface QuotesApiDriver
{
    public function test(string $test): string;
}
