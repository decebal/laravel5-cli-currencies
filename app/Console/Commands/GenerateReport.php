<?php namespace App\Console\Commands;

use App\Contracts\CurrencyConverter;
use App\Models\Merchant;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class GenerateReport
 *
 * @package ReportDemo\Console\Commands
 */
class GenerateReport extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates sales report for vendor.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $currencyConverter = new CurrencyConverter(
            $this->option('currency'),
            $this->option('advanced-detect')
        );
        $merchant = new Merchant($currencyConverter);
        list($headers, $rows) = $merchant->getTransactionsById($this->argument('vendor-id'));

        $this->table($headers, $rows);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['vendor-id', InputArgument::REQUIRED, 'Id of desired vendor'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['currency', 'c', InputOption::VALUE_OPTIONAL, 'International Short, defaults to GBP; Available at this time: GBP, USD, EUR', 'GBP'],
            ['advanced-detect', 'ad', InputOption::VALUE_OPTIONAL, 'Advanced Currency Detection', 0],  //this uses the regex engine, so it is not recommended for large data
        ];
    }
}
