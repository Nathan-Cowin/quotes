<?php
namespace App\Interfaces;

use Carbon\CarbonInterface;

interface QuotesApiDriver
{
    public function setCount(int $count): void;

    public function getMultipleQuotes(int $count): string;
}
