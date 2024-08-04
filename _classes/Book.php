<?php
include_once 'DataBase.php'; 
include_once 'Product.php'; 

class Book extends Product {
    protected $weight;
    static $attribute = 'weight';
    static $type = 'Book';

    public function __construct($sku, $name, $price) {
        parent::__construct($sku, $name, $price);
    }

    public function getWeight() {
        return $this->weight;
    }

    public function __destruct() {
        if (isset($this->conn)) {
            $this->conn->close();
        }
    }

    public function display() {
        $db = new DataBase();
        $conn = $db->getConnection();
        $sku = mysqli_real_escape_string($conn, $this->getSku());
        $sql = "SELECT VALUE, ATTRIBUTE
                FROM products p 
                JOIN product_attributes pa ON p.SKU = pa.SKU 
                WHERE pa.SKU = '$sku'
                ORDER BY ATTRIBUTE";
        $results = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

        foreach ($results as $result) {
            $attributeName = $result['ATTRIBUTE'];
            $this->$attributeName = $result['VALUE'];
        }
        echo '<div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-4">
            <div class="card" style="background-color:#f4e1c1">
                <input type="checkbox" class="delete-checkbox mt-5" name="' . htmlspecialchars($this->getSku()) . '">
                <div class="card-body d-flex flex-column p-3 m-3 align-items-center">
                    <h5 class="card-title">SKU: ' . htmlspecialchars($this->getSku()) . '</h5>
                    <strong><div class="card-title">Name: ' . htmlspecialchars($this->getName()) . '</strong></div>
                    <div class="card-text">Price: ' . htmlspecialchars($this->getPrice()). ' $' . '</div>
                    <div class="card-text">' . Book::$attribute . ': ' . htmlspecialchars($this->getWeight()) .' Kg' .'</div>
                </div>
            </div>
        </div>';
    }

    public function save($list) {
        if (!array_key_exists('weight', $list)) {
            return null;
        }

        $this->weight = filter_var($list['weight'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if ($this->getWeight() === false || $this->getWeight() < 0) {
            return null;
        }

        try {
            $db = new DataBase();
            $this->conn = $db->getConnection();

            $query = "INSERT INTO products (SKU, NAME, PRICE, TYPE) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssis", $this->sku, $this->name, $this->price, Book::$type);
            $stmt->execute();

            $query = "INSERT INTO product_attributes (SKU, ATTRIBUTE, VALUE) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssi", $this->sku, Book::$attribute, $this->weight);
            $stmt->execute();

            header('Location:index.php');
            return null;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                return null;
            } else {
                return null;
            }
        } catch (Exception $e) {
            return null;
        }
    }
}
?>
