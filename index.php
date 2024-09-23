<?php
namespace App;

require __DIR__. '/vendor/autoload.php';


use Bramus\Router\Router;
use App\Controller\ProductController;
use App\Models\Furniture;


$router = new Router();
$router->get('/',function(){
    ProductController::index();
});

$router->get('/index.php',function(){
        header('Location:/scandiweb/');
        ProductController::index();
});

$router->get('/add-product',function(){
    ProductController::addProduct();
});

$router->post('/delete', function(){
    $data = $_POST;
    ProductController::deleteProducts($data);
    header('Location:/');
});

$router->post('/new-product', function(){
    $data= $_POST;
    ProductController::create($data);
    header('Location:/');
});

$router->run();

