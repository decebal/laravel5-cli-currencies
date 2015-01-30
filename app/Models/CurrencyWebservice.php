<?php

/**
 * Dummy web service returning random exchange rates
 *
 */
class CurrencyWebservice
{
    private $exchangeRates = array(
        'GBP' => 1,
        'USD' => 0.8,
        'EUR' => 0.9
    );

    /**
     * @param $currency string currency identifier
     * @return int      random value here for basic currencies like GBP USD EUR (simulates real API)
     */
    public function getExchangeRate($currency)
    {
        $exchangeRate  = isset($this->exchangeRates[$currency])
            ? $this->exchangeRates[$currency]
            : 1;

        return $exchangeRate;
    }
}