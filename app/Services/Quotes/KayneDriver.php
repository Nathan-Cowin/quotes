<?php

namespace App\Services\Quotes;

use App\Interfaces\QuotesApiDriver;

class KayneDriver implements QuotesApiDriver
{
    private int $count;

    public function setCount(int $count): void
    {
        $this->count = $count;
    }
    public function getMultipleQuotes(int $count): string
    {
        if(!isset($this->count)){
            //todo throw exception and test this
            return 'set the count';
        }

        $quotes = [];
        for ($i = 0; $i < $this->count; $i++) {
            $quote = $this->_getQuote();
            //todo $this->_checkQuoteIsUnique($quote, $quotes);
            $quotes[] = $quote;
        }
        return $quotes;
    }

    private function _getQuote(){
        dd('et');
        //call api
    }
}
