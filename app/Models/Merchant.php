<?php namespace App\Models;

use App\Contracts\CurrencyConverter;
use League\Csv\Reader;

/**
 * Class Merchant
 */
class Merchant
{
    /**
     * dummy file path with data
     *
     * @var string
     */
    private $filename = '';

    /**
     * Csv Reader Instance
     *
     * @var Reader
     */
    private $inputCsv = null;

    /**
     * @var CurrencyConverter
     */
    private $currencyConverter = null;

    /**
     * Init Merchant Details
     *
     * @param CurrencyConverter $currencyConverter
     */
    public function __construct(CurrencyConverter $currencyConverter)
    {
        $this->currencyConverter = $currencyConverter;
        $this->filename = base_path() . '/storage/files/data.csv';
        $this->loadData();
    }

    /**
     * initialize csv reader
     */
    public function loadData()
    {
        $inputCsv = Reader::createFromPath(new \SplFileObject($this->filename));
        $inputCsv->setDelimiter(';');
        $inputCsv->setEncodingFrom("iso-8859-15");
        $this->inputCsv = $inputCsv;
    }

    /**
     * @param $vendorId
     * @return array
     */
    public function getTransactionsById($vendorId)
    {
        $headers = $this->inputCsv->fetchOne(0);
        $contents = $this->inputCsv
            ->addFilter(function (
                $row,
                $index
            ) {
                return $index > 0; //we don't take into account the header
            })
            ->addFilter(function ($row) {
                return isset($row[0], $row[1], $row[2]); //we make sure the data are present
            })
            ->addFilter(function ($row) use ($vendorId) {
                return $row[0] == $vendorId; //return transaction data by vendor
            })
            ->fetchAssoc();

        $contents = $this->convertValues($contents);

        return array(
            $headers,
            $contents
        );
    }

    /**
     * Use CurrencyConverter to decide and convert currency values
     *
     * @param $transactions array
     * @return mixed
     */
    private function convertValues($transactions)
    {
        foreach ($transactions as &$transaction) {
            $transaction['value'] = $this->currencyConverter->convertCurrency($transaction['value']);
        }

        return $transactions;
    }
}