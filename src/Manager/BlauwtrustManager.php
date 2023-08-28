<?php

namespace App\Manager;

use DateTime;


class BlauwtrustManager
{
    /**
     * @param $outputFileName
     * @param $output
     * @return string|void
     */
    public function calculateSalesPayrollDates($outputFileName, $output = null)
    {
        $year = date('Y');
        $SalesCsvData = [['Month Name', 'Salary Payment Date', 'Bonus Payment Date']];

        for ($month = 1; $month <= 12; $month++) {
            //the last day of month
            $baseSalaryDate = new DateTime("last day of $year-$month");
            //the 15th day of month
            $bonusDate = new DateTime("$year-$month-15");

            //If the last day of month >= 6 is Saturday or 7 is Sunday
            if ($baseSalaryDate->format('N') >= 6) {
                $baseSalaryDate->modify('last friday');
            }
            //If the 15th day of month >= 6 is Saturday or 7 is Sunday
            if ($bonusDate->format('N') >= 6) {
                $bonusDate->modify('next wednesday');
            }

            $SalesCsvData[] = [
                $baseSalaryDate->format('F'),
                $baseSalaryDate->format('Y-m-d'),
                $bonusDate->format('Y-m-d')
            ];
        }
        $salesCsvFile = fopen($outputFileName, 'w');
        foreach ($SalesCsvData as $row) {
            fputcsv($salesCsvFile, $row);
        }
        fclose($salesCsvFile);
        if ($output) {
            $output->writeln($outputFileName . ' file with payment dates has been generated.');
        } else {
            return $outputFileName . ': File successfully generated';
        }

    }
}
