<?php

namespace App;

use App\Exceptions\FileIsNotExistsException;

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

    public function save(array $data): void
    {
        // TODO
    }
}
