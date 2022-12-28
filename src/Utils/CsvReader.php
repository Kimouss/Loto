<?php

namespace App\Utils;

class CsvReader
{
    public function readCsv(string $filePath): array
    {
        $row = 1;
        $result = [];
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 3000, ";")) !== FALSE) {
                if ($row === 1) {
                    $header = $data;
                } else {
                    if (empty($data[array_key_first($data)])) {
                        continue;
                    }
                    if (count($data) > count($header)) {
                        $header[] = '';
                    }
                    $result[] = array_combine($header, $data);
                }
                $row++;
            }
            fclose($handle);
        }

        return $result;
    }
}
