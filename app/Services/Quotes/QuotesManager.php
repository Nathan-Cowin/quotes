<?php

namespace App\Services\Quotes;

use App\Interfaces\QuotesApiDriver;
use Illuminate\Support\Manager;

class QuotesManager extends Manager implements QuotesApiDriver
{
    public function createKayneDriver(): QuotesApiDriver
    {
        return new KayneDriver();
    }

    public function getDefaultDriver(): string
    {
        return 'kayne';
        //TODO return $this->config->get('kayne.driver');
    }

    public function getQuotes(): array
    {
        return $this->driver()->getQuotes();
    }

    public function setCount($count): KayneDriver
    {
        $this->driver()->setCount($count);
    }
    public function clearCache(): KayneDriver
    {
        $this->driver()->clearCache();
    }
}
