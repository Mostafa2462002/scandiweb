<?php

include_once 'DataBase.php';
include_once 'Book.php';
include_once 'Furniture.php';
include_once 'DVD.php';

abstract class Product {
    protected $db;
    protected $conn;
    protected $sku;
    protected $name;
    protected $price;
    
    public function __construct($sku, $name, $price) {
        $this->sku = $sku;
        $this->name = $name;
        $this->price = $price;
    }

    abstract public function save($list);

    public static function displayProducts() {
        $db = new DataBase();
        $conn = $db->getConnection();
        if ($conn) {
            $query = 'SELECT SKU, NAME, PRICE, TYPE FROM products ORDER BY SKU';
            $result = mysqli_query($conn, $query);
            $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
            foreach ($results as $result) {
                $productToDisplay = new $result['TYPE']($result['SKU'], $result['NAME'], $result['PRICE']);
                $productToDisplay->display();
            }
            $conn->close();
        }
        return $results ?? null;
    }

    public static function deleteSelectedItems($x) {
        foreach ($x as $index => $posty) {
            $index = str_replace('_', ' ', htmlspecialchars($index)); // replace underscores
            $db = new DataBase();
            $conn = $db->getConnection();
            $index = mysqli_real_escape_string($conn, $index); // Escape the index for SQL

            $sql = "DELETE FROM products WHERE SKU = '$index'";
            mysqli_query($conn, $sql);

            $conn->close();
        }
    }

    // getters
    public function getSku() {
        return $this->sku;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sku']) && isset($_POST['name'])) {
    // Sanitize and validate core product inputs
    $sku = filter_input(INPUT_POST, 'sku', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $productType = filter_input(INPUT_POST, 'productType', FILTER_SANITIZE_SPECIAL_CHARS);

    // Validate core inputs
    $errors = [];
    
    // Validate SKU: Only alphanumeric characters
    if (!preg_match('/^[a-zA-Z0-9]+$/', $sku)) {
        $errors[] = 'SKU must only contain letters and numbers.';
    }
    
    // Validate Name: Only letters and spaces
    if (!preg_match('/^[a-zA-Z0-9]+$/', $name)) {
        $errors[] = 'Name must only contain letters and numbers.';
    }
    
    // Validate Price: Must be a non-negative number
    if (!is_numeric($price) || $price < 0) {
        $errors[] = 'Price must be a non-negative number.';
    }
    
    // Validate productType
    if (!class_exists($productType)) {
        $errors[] = 'Invalid product type.';
    }
    
    if (!empty($errors)) {
        // Log error messages
        error_log('Validation Errors: ' . implode(', ', $errors), 3, 'errors.log');
        
        // Redirect without error message
        header('Location: add-product.php');
        exit();
    }

    // Sanitize inputs again for safe use
    $sku = htmlspecialchars($sku, ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    $price = htmlspecialchars($price, ENT_QUOTES, 'UTF-8');
    $productType = htmlspecialchars($productType, ENT_QUOTES, 'UTF-8');

    try {
        foreach ($_POST as $input) {
            if (strlen($input) > 30) {
                throw new Exception('Input length exceeds allowed limit.');
            }
        }
        $product = new $productType($sku, $name, $price);

        // Save the product and get the result
        $productToAdd = $_POST;
        $return_value = $product->save($productToAdd);
        echo $return_value;
    } catch (Throwable $e) {
        // Log exception message
        error_log('Exception: ' . $e->getMessage(), 3, 'errors.log');
        
        // Redirect without error message
        header('Location: add-product.php');
        exit();
    }
}
?>
