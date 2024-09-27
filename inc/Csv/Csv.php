<?php

namespace basetemplate\Csv;

use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\Writer;
use RuntimeException;

class Csv
{
    private Writer $csvWriter;

    /**
     * CSVBuilder constructor initializes the CSV writer from an empty string.
     */
    public function __construct()
    {
        $this->csvWriter = Writer::createFromString('');
    }

    /**
     * Set the headers for the CSV.
     *
     * @param array $headers
     * @return $this
     *
     * @example
     * $csv->set_headers(
     *      ['Name', 'Email', 'Phone']
     * );
     *
     */
    public function set_headers(array $headers): self
    {
        try {
            $this->csvWriter->insertOne($headers);
        } catch (CannotInsertRecord|Exception $e) {
            error_log($e->getMessage());
        }
        return $this;
    }

    /**
     * Add a row to the CSV.
     *
     * @param array $row
     * @return $this
     * @throws CannotInsertRecord|Exception
     *
     * @example
     * $csv->add_row(
     *     ['John Doe', 'john@example.com', '1234567890']
     * );
     *
     */
    public function add_row(array $row): self
    {
        $this->csvWriter->insertOne($row);
        return $this;
    }

    /**
     * Add multiple rows to the CSV.
     *
     * @param array $rows
     * @return $this
     * @throws CannotInsertRecord|Exception
     *
     * @example
     * $csv->add_rows([
     *      ['John Doe', 'john@email.com', '1234567890'],
     *      ['Jane Doe', 'john@email.com', '1234567890']
     * ]);
     *
     */
    public function add_rows(array $rows): self
    {
        foreach ($rows as $row) {
            $this->csvWriter->insertOne($row);
        }
        return $this;
    }

    /**
     * Get the CSV content as a string.
     *
     * @return string
     * @throws Exception
     *
     * @example
     * $csv_content = $csv->get_csv_content();
     * echo $csv_content;
     *
     */
    public function get_csv_content(): string
    {
        return $this->csvWriter->toString();
    }

    /**
     * Save the CSV content to a file and return the file path.
     *
     * @param string $fileName
     * @return string
     * @throws Exception
     *
     * @example
     * $file_path = $csv->save_as_tmp_file('file.csv');
     * echo $file_path; // you can add it to attachment in email for example
     *
     */
    public function save_as_tmp_file(string $fileName): string
    {
        $filePath = sys_get_temp_dir() . '/' . $fileName;
        file_put_contents($filePath, $this->get_csv_content());
        return $filePath;
    }

    /**
     * Download the CSV file.
     *
     * @param string $filePath
     * @throws RuntimeException
     *
     * @example
     * $file_path = $csv->save_as_tmp_file('file.csv');
     * $csv->download_tmp_file($file_path);
     *
     */
    public function download_tmp_file(string $filePath): void
    {

        if (!file_exists($filePath)) {
            throw new \RuntimeException("File not found: {$filePath}");
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        unlink($filePath);
        exit;
    }

}
