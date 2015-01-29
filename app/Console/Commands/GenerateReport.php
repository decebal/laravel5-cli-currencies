<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateReport extends Command {

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
		//$this->argument('vendorId')
		//$this->option('currency')
		//get vendor model
//		$headers = $this->vendor->getHeaders();
//		$rows = getData($this->vendorId);
//		$this->table($headers, $rows, 0);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['vendorId', InputArgument::REQUIRED, 'Id of desired vendor; Check the vendors with the command show:vendors'],
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
			['currency', 'c', InputOption::VALUE_OPTIONAL, 'International Short, defaults to GBR', 'GBR'],
		];
	}

}
