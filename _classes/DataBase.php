<?php 

class DataBase{


// Define database connection constants
private  $DB_SERVER = 'localhost';
private $DB_USERNAME = 'root';
private $DB_PASSWORD = '';
private $DB_NAME = 'scandiweb';
public $conn ; //connection object

// Create connection
function getConnection(){
    $this->conn = null;

    try {
        $this->conn = new mysqli($this->DB_SERVER, $this->DB_USERNAME, $this->DB_PASSWORD, $this->DB_NAME);

    } catch (Exception $e) {
        echo "Connection error: php database file" ;
    }

    return $this->conn;
     
}
}

?>
