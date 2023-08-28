<?php

namespace App\Command;

use App\Manager\BlauwtrustManager;
use App\Tool\CsvTool;
use DateTime;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'app:sales-payroll-dates')]
class SalesPayrollDatesCommand extends Command
{
    /**
     * @var CsvTool
     */
    private $csvTool;
    /**
     * @var BlauwtrustManager
     */
    private $blauwtrustManager;

    /**
     * @param CsvTool $csvTool
     * @param BlauwtrustManager $blauwtrustManager
     */
    public function __construct(CsvTool $csvTool, BlauwtrustManager $blauwtrustManager)
    {
        $this->csvTool = $csvTool;
        $this->blauwtrustManager = $blauwtrustManager;
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setDescription('Generate a CSV file containing sales department payment data')
            ->addArgument('output_file', InputArgument::REQUIRED, 'The output CSV file name for the sales department.');

    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //Get out put file name
        $outputFileName = $input->getArgument('output_file');
        $verificationCsvName = $this->csvTool->verificationCsvName($outputFileName);
        if ($verificationCsvName) {
            $this->blauwtrustManager->calculateSalesPayrollDates($outputFileName, $output);
        } else {
            $output->writeln('Error:' . $outputFileName . ' The file name does not contain .csv');
            return Command::FAILURE;
        }


        return Command::SUCCESS;
    }
}
