<?php

namespace App;

use App\Exceptions\FileIsNotExistsException;
use App\Exceptions\OpenFileException;

class CsvParser
{
    /**
     * @param string $file
     *
     * @throws FileIsNotExistsException
     *
     * @return array
     */
    public function load(string $file): array
    {
        if (!file_exists($file)) {
            throw new FileIsNotExistsException('Can\'t find file: '.$file);
        }

        $result = [];

        $csv = fopen($file, 'r');
        while (!feof($csv)) {
            $line = fgetcsv($csv, 0, ';');
            $result[] = [
                (int) $line[0],
                (int) $line[1],
            ];
        }
        fclose($csv);

        return $result;
    }

    /**
     * @param string $file
     * @param array  $data
     *
     * @throws OpenFileException
     */
    public function save(string $file, array $data): void
    {
        $csv = fopen($file, 'w');
        if (false === $csv) {
            throw new OpenFileException('Error opening file: '.$file);
        }

        foreach ($data as $line) {
            fputcsv($csv, $line, ';');
        }

        fflush($csv);
        fclose($csv);
    }
}
