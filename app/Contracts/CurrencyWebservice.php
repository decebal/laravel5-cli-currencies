<?php namespace App\Contracts;

/**
 * Dummy web service returning random exchange rates
 *
 */
class CurrencyWebservice
{
    /**
     * @var array dummy data with exchange rates for pound
     */
    private static $exchangeRates = array(
        array(
            'to' => 'GBP',
            'from' => 'USD',
            'rate' => 0.66
        ),
        array(
            'to' => 'GBP',
            'from' => 'EUR',
            'rate' => 0.74
        )
    );

    /**
     * @param $fromCurrency string accepts currency short name
     * @param $toCurrency   string accepts currency short name
     *
     * @return mixed        exchange rate
     * @throws \Exception
     */
    public static function getExchangeRate($fromCurrency, $toCurrency)
    {
        foreach (self::$exchangeRates as $rateDetails) {
            if (
                $rateDetails['from'] == $fromCurrency
                && $rateDetails['to'] == $toCurrency
            ) {
                return $rateDetails['rate'];
            }
        }

        throw new \Exception(
            sprintf(
                'No rate defined for the current exchange: %s - %s',
                $fromCurrency,
                $toCurrency
            )
        );
    }
}