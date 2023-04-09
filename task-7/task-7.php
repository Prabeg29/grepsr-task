<?php

declare(strict_types=1);

class Task7
{
  private string $_url;
  private string $_csvFilename;

  public function __construct(string $url, string $csvFilename)
  {
    $this->_url = $url;
    $this->_csvFilename = $csvFilename;
  }

  public function execute(): void
  {
    $data = $this->getContentsFromUrl();
    $csvContent = $this->writeToBuffer($data);
    $this->writeToCsv($csvContent);
  }

  private function getContentsFromUrl(): array
  {
    $jsonData = file_get_contents($this->_url);

    if (!$jsonData) {
      return [];
    }

    return json_decode($jsonData, true);
  }

  private function writeToBuffer(array $data): string
  {
    if (empty($data)) {
      throw new Exception('No content. Please provide a valid URL');
    }

    ob_start();

    $buffer = fopen('php://output', 'w+');
    fputcsv($buffer, ['Title', 'Price', 'Brand']);

    foreach ($data['products'] as $product) {
      fputcsv($buffer, [
        $product['title'] ?? 'N/A',
        $product['price'] ?? 'N/A',
        $product['brand'] ?? 'N/A',
      ]);
    }

    return ob_get_clean();
  }

  private function writeToCsv(string $csvContent)
  {
    $file = fopen($this->_csvFilename, 'w');
    fwrite($file, $csvContent);
    fclose($file);
  }
}

try {
  $url = 'https://dummyjson.com/products/search?q=Laptop';
  $csvFilename = 'laptop.csv';

  $task7 = new Task7($url, $csvFilename);
  $task7->execute();

  echo 'Contents extracted to CSV successfully.';
} catch (Exception $exception) {
  var_dump($exception->getMessage());
}
