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

    public function getDefaultDriver()
    {
        return 'kayne';
        //TODO return $this->config->get('kayne.driver');
    }

    public function test($test): string
    {
        return $this->driver()->test($test);
    }
}
