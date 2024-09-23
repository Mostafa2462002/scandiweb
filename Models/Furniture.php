<?php

namespace App\Models;


class Furniture extends Product
{
    protected $width;
    protected $height;
    protected $length;
    protected $type = 'Furniture';

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
                $sql = "INSERT INTO products (sku, name, price, type, height, width, length) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);

                // Bind parameters
                $stmt->bind_param("ssdsddd", ...$this->getProductData());

                if (!$stmt->execute()) {
                    error_log(PHP_EOL . 'SQL insert statement wasn\'t successful' . PHP_EOL, 3, 'errors.log');
                    throw new \Exception('Failed to insert into database');
                }

                $stmt->close();
            }
        } catch (\Exception $e) {
            error_log(PHP_EOL . 'Line37-FurnitureModel: ' . $e->getMessage() . PHP_EOL, 3, 'errors.log');
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
            $this->width,
            $this->height,
            $this->length,
        ];
    }

    protected function setProductData(array $list): void
    {
        $this->sku = $list['sku'];
        $this->name = $list['name'];
        $this->price = $list['price'];
        $this->width = $list['width'];
        $this->height = $list['height'];
        $this->length = $list['length'];
    }

    protected function sanitize(array &$list): array
    {
        $list['sku'] = htmlspecialchars($list['sku'], ENT_QUOTES, 'UTF-8');
        $list['name'] = htmlspecialchars($list['name'], ENT_QUOTES, 'UTF-8');
        $list['price'] = filter_var($list['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $list['width'] = filter_var($list['width'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $list['height'] = filter_var($list['height'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $list['length'] = filter_var($list['length'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        return $list;
    }

    protected function validate(array $list): bool
    {
        $errors = [];
        $required_keys = ['sku', 'name', 'price', 'width', 'height', 'length'];

        foreach ($required_keys as $key) {
            if (!isset($list[$key]) || empty($list[$key])) {
                $errors[] = "Missing or invalid attribute: $key";
            }
        }

        if (!filter_var($list['width'], FILTER_VALIDATE_FLOAT) || $list['width'] <= 0) {
            $errors[] = 'Invalid width';
        }
        if (!filter_var($list['height'], FILTER_VALIDATE_FLOAT) || $list['height'] <= 0) {
            $errors[] = 'Invalid height';
        }
        if (!filter_var($list['length'], FILTER_VALIDATE_FLOAT) || $list['length'] <= 0) {
            $errors[] = 'Invalid length';
        }
        if (!filter_var($list['price'], FILTER_VALIDATE_FLOAT) || $list['price'] <= 0) {
            $errors[] = 'Invalid price';
        }

        if (!empty($errors)) {
            error_log(PHP_EOL . 'Line104-FurnitureModel-Validation: ' . implode(', ', $errors) . PHP_EOL, 3, 'errors.log');
            throw new \Exception(implode($errors));
        }

        return true;
    }
}
