<?php

namespace App\Tool;


class CsvTool
{
    /**
     * @param $csvFileName
     * @return bool
     * Verification CSV name
     */
    public function verificationCsvName($csvFileName)
    {
        // Get the extension using pathinfo()
        $extension = pathinfo($csvFileName, PATHINFO_EXTENSION);
        // Test if the extension is "csv"
        if ($extension === 'csv') {
            return true;
        }
        return false;
    }
}
