<?php

namespace App\Models;

class Book extends Product
{
    protected $weight;
    protected $type = 'Book';

    public function __construct(string $sku, string $name, float $price)
    {
        parent::__construct($sku, $name, $price);
    }

    public function save(array $list): ?bool
    {
        try {
            $this->setProductData($this->sanitize($list));
            $this->validate($list);

            if ($this->conn) {
                $sql = "INSERT INTO products (SKU, NAME, PRICE, TYPE, weight) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("ssdsd", ...$this->getProductData());

                if (!$stmt->execute()) {
                    error_log(PHP_EOL . 'SQL insert statement wasn\'t successful' . PHP_EOL, 3, 'errors.log');
                    throw new \Exception('Failed to insert into database');
                }

                $stmt->close();
            }
        } catch (\Exception $e) {
            error_log(PHP_EOL . 'Line32-BookModel: ' . $e->getMessage() . PHP_EOL, 3, 'errors.log');
            return null;
        }

        return true;
    }

    protected function getProductData(): array
    {
        return [
            $this->sku,
            $this->name,
            $this->price,
            $this->type,
            $this->weight,
        ];
    }

    protected function setProductData(array $list): void
    {
        $this->sku = $list['sku'];
        $this->name = $list['name'];
        $this->price = $list['price'];
        $this->weight = $list['weight'];
    }

    protected function sanitize(array &$list): array
    {
        $list['sku'] = htmlspecialchars($list['sku'], ENT_QUOTES, 'UTF-8');
        $list['name'] = htmlspecialchars($list['name'], ENT_QUOTES, 'UTF-8');
        $list['price'] = filter_var($list['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $list['weight'] = filter_var($list['weight'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        return $list;
    }

    protected function validate(array $list): bool
    {
        $errors = [];
        $required_keys = ['sku', 'name', 'price', 'weight'];

        foreach ($required_keys as $key) {
            if (!isset($list[$key]) || empty($list[$key])) {
                $errors[] = "Missing or invalid attribute: $key";
            }
        }

        if (!filter_var($list['weight'], FILTER_VALIDATE_FLOAT, ["options" => ["min_range" => 1]])) {
            $errors[] = 'Invalid weight';
        }
        if (!filter_var($list['price'], FILTER_VALIDATE_FLOAT) || $list['price'] <= 0) {
            $errors[] = 'Invalid price';
        }

        if (!empty($errors)) {
            error_log(PHP_EOL . 'Line86-BookModel-Validation: ' . implode(', ', $errors) . PHP_EOL, 3, 'errors.log');
            throw new \Exception(implode($errors));
        }

        return true;
    }
}
