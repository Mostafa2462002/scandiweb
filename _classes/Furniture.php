<?php
include_once 'DataBase.php'; 
include_once 'Product.php'; 

class Furniture extends Product { 
    protected $width;
    protected $height;
    protected $length;


    static $type = 'Furniture';

    public function __construct($sku, $name, $price) {
        parent::__construct($sku, $name, $price);
    }
    public function getWidth() {
        return $this->width;
    }

    public function getHeight() {
        return $this->height;
    }

    public function getLength() {
        return $this->length;
    }

    public function __destruct() {
        // Destructor code
        if (isset($this->conn)) {
            $this->conn->close();
        }
    }
    public function display() {
        $db = new DataBase();
        $conn = $db->getConnection();
        $sku = mysqli_real_escape_string($conn, $this->getSku());
        // Create the SQL query with the sanitized SKU
        $sql = "SELECT VALUE,ATTRIBUTE
        FROM products p 
        JOIN product_attributes pa ON p.SKU = pa.SKU 
        WHERE pa.SKU = '$sku'
        ORDER BY ATTRIBUTE";
        $results = $conn->query($sql)->fetch_all(MYSQLI_ASSOC);

        foreach($results as $result)
        {  
            $attributeName = $result['ATTRIBUTE'];
            $this->$attributeName = $result['VALUE'];
        }        
        echo '<div class="col-12 col-md-6 col-lg-4 col-xl-4 mb-4">
            <div class="card" style="background-color:#f4e1c1">
                <input type="checkbox" class="delete-checkbox mt-5" name="' . htmlspecialchars($this->getSku()) . '"><!-- Passing the SKU as the index of the checkbox input -->
                <div class="card-body d-flex flex-column p-3 m-3 align-items-center">
                    <h5 class="card-title">SKU: ' . htmlspecialchars($this->getSku()) . '</h5>
                    <strong><div class="card-title">Name: ' . htmlspecialchars($this->getName()) . '</strong></div>
                    
                    <div class="card-text">Price: ' . htmlspecialchars($this->getPrice()) . ' $' . '</div>
                    <div class="card-text">Width: ' . htmlspecialchars($this->getWidth()) . '</div>
                    <div class="card-text">Height: ' . htmlspecialchars($this->getHeight()) . '</div>
                    <div class="card-text">Lenght: ' . htmlspecialchars($this->getLength()) . '</div>

                </div>
            </div>
        </div>';
    }


    public function save($list) {
        // Check if all required keys exist in the $list array
        $required_keys = ['width', 'height', 'length'];
        foreach ($required_keys as $key) {
            if (!array_key_exists($key, $list)) {
                 //return "Error: Invalid Data - Don't Play with the DOM Again -_-\".";

            return null;
            }
        }
    
        // Sanitize and validate inputs for the dimensions
        $this->width = filter_var($list['width'], FILTER_VALIDATE_INT);
        $this->height = filter_var($list['height'], FILTER_VALIDATE_INT);
        $this->length = filter_var($list['length'], FILTER_VALIDATE_INT);
    
        // Check if any value is false (invalid input) or if dimensions are negative
        if ($this->getWidth() === false || $this->getHeight() === false || $this->getLength() === false ||
            $this->getWidth() < 0 || $this->getHeight() < 0 || $this->getLength() < 0) {
             //return "Error: Invalid Data - Don't Play with the DOM Again -_-\".";
             return null;
        }
    
        // Try to save the product to the database
        try {
            $db = new DataBase();
            $this->conn = $db->getConnection();
    
            // Insert into products table
            $query = "INSERT INTO products (SKU, NAME, PRICE, TYPE) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("ssis", $this->sku, $this->name, $this->price, Furniture::$type);
            $stmt->execute();
    
            // Insert dimensions into product_attributes table
            $attributes = [
                'width' => $this->getWidth(),
                'height' => $this->getHeight(),
                'length' => $this->getLength(),
            ];
    
            foreach ($attributes as $attribute => $value) {
                $query = "INSERT INTO product_attributes (SKU, ATTRIBUTE, VALUE) VALUES (?, ?, ?)";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param("ssi", $this->sku, $attribute, $value);
                $stmt->execute();
                   
                
            }
            // all of the comments for future extentions to build the error log
            header('Location:index.php');
            return null;
            //return 'Successful Insertion'; 
        } catch (mysqli_sql_exception $e) {
            // Handle specific SQL errors
            if ($e->getCode() == 1062) {
               // return "Error: Duplicate entry for primary key.";
               return null;
            } else {
              //  return "Error: " . $e->getMessage();
              return null;
            }
        } catch (Exception $e) {
            // Handle other exceptions
           // return "Error1111: " . $e->getMessage();
           return null;
        }
    }
    
    
    
}
?>
