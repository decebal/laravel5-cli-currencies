<?php namespace App\Contracts;

/**
 * Uses CurrencyWebservice
 */
class CurrencyConverter
{
    private $defaultCurrency = '';
    private $useAdvancedCurrencyDetection = false;

    /**
     * @var array dummy data to be used on detecting currencies
     */
    public $availableCurrencies = array(
        array(
            'symbol' => '$',
            'name' => 'us dollar',
            'short' => 'USD'
        ),
        array(
            'symbol' => '€',
            'name' => 'euro',
            'short' => 'EUR'
        ),
        array(
            'symbol' => '£',
            'name' => 'pound',
            'short' => 'GBP'
        )
    );

    /**
     * @param $defaultCurrency string
     * @param $advancedDetect  boolean
     */
    public function __construct($defaultCurrency, $advancedDetect)
    {
        $this->defaultCurrency = $defaultCurrency;
        $this->useAdvancedCurrencyDetection = $advancedDetect;
    }

    /**
     * Decision making in terms of currency
     * Decides if there is a need for conversion
     * or the current value is in the desired currency already
     *
     * @param $value string
     *
     * @return string
     * @throws
     */
    public function convertCurrency($value)
    {
        if ($this->useAdvancedCurrencyDetection) {
            $valueCurrency = $this->advancedCurrencyDetection($value);
        } else {
            $valueCurrency = $this->currencyDetection($value);
        }

        $currencies = $this->getCurrencies();

        if ($valueCurrency == $currencies[$this->defaultCurrency]['symbol']) {
            return $value;
        } else {
            return $this->convert(
                $value,
                $valueCurrency,
                $currencies[$this->defaultCurrency]['symbol']
            );
        }
    }

    /**
     * Convert currency from given string to a new string with the desired currency
     *
     * @param $value        string
     * @param $fromCurrency string  current currency symbol
     * @param $toCurrency   string  currency symbol to be converted to
     *
     * @return string new value with currency
     */
    private function convert($value, $fromCurrency, $toCurrency)
    {
        $removedSymbol = trim($value, $fromCurrency);

        $currencies = $this->getCurrenciesSymbol();
        $fromCurrencyShort = $currencies[$fromCurrency]['short'];
        $toCurrencyShort = $currencies[$toCurrency]['short'];

        $exchangeRate = CurrencyWebservice::getExchangeRate($fromCurrencyShort, $toCurrencyShort);
        $converted = $removedSymbol * $exchangeRate;

        //no topic option, but can be due in a further update
        $newSymbol = sprintf('%s%s', $toCurrency, $converted);

        return $newSymbol;
    }

    /**
     * Detect currency symbol from string using the regex engine
     *
     * @param $string string
     *
     * @return string currency symbol from string
     * @throws
     */
    private function advancedCurrencyDetection($string)
    {
        $valueCurrency = '';

        if (preg_match('/^(\D*)\s*([\d,\.]+)\s*(\D*)$/', trim($string), $matches)) {
            $valueCurrency = $matches[1];
        } else {
            throw new \Exception(
                sprintf(
                    "The string doesn't contain any currency! %s",
                    $string
                )
            );
        }

        return $valueCurrency;
    }

    /**
     * Detect currency Symbol using a list of symbols
     *
     * @param $string string
     *
     * @return string currency symbol from string
     * @throws
     */
    private function currencyDetection($string)
    {
        $currencyList = array_keys($this->getCurrenciesSymbol());
        foreach ($currencyList as $symbol) {
            if (strpos($string, $symbol) !== false) {
                return $symbol;
            }
        }

        throw new \Exception(
            sprintf(
                "The string doesn't contain any currency! %s",
                $string
            )
        );
    }

    /**
     * Return available currencies mapped by currency short name
     *
     * @return array
     */
    private function getCurrencies()
    {
        $array = array();
        foreach ($this->availableCurrencies as $currencyDetails) {
            $array[$currencyDetails['short']] = $currencyDetails;
        }
        return $array;
    }

    /**
     * Return available currencies mapped by currency symbol
     *
     * @return array
     */
    private function getCurrenciesSymbol()
    {
        $array = array();
        foreach ($this->availableCurrencies as $currencyDetails) {
            $array[$currencyDetails['symbol']] = $currencyDetails;
        }
        return $array;
    }
}