<?php
namespace App\Models;

use App\Models\DataBase;


use App\Models\Book;
use App\Models\Furniture;
use App\Models\DVD;


abstract class Product
{
    protected $db;
    protected $conn;
    protected $sku;
    protected $name;
    protected $price;

    public function __construct($sku, $name, $price)
    {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
        $this->conn = DataBase::getInstance()->getConnection();
    }

    abstract protected function save(array $list): ?bool;
    abstract protected function validate(array $list):bool;
    abstract protected function sanitize(array &$list):array;
    abstract protected function setProductData(array $list):void;
    abstract protected function getProductData():array;

    public static function getProducts(): array|null
    {
        $conn = DataBase::getInstance()->getConnection();
        if ($conn) {
            $query = 'SELECT * FROM products ORDER BY SKU';
            $result = mysqli_query($conn, $query);
            $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $conn->close();
        }
        return $results ?? null;
    }

    public static function deleteSelectedItems($items_to_delete)
    {
        $conn = DataBase::getInstance()->getConnection();
        if ($conn) {
            foreach ($items_to_delete as $item) {
                $query = "DELETE FROM products WHERE sku = '$item'";
                $conn->query($query);
            }
        }
    }
}

