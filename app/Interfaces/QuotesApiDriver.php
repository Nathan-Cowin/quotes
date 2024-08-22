<?php
namespace App\Interfaces;

use App\Services\Quotes\KayneDriver;
use Carbon\CarbonInterface;

interface QuotesApiDriver
{
    public function setCount(int $count): KayneDriver;

    public function getQuotes(): array;
}
