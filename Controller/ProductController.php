<?php

declare(strict_types=1);

namespace App\Controller;

use App\Models\Product;
use App\Core\ProductView;


class ProductController
{

    public static function index(): void
    {
        $productView = new ProductView();
        $results = Product::getProducts();
        $productView->render('Products', $results);
    }

    public static function addProduct(): void
    {
        $productView = new ProductView();
        $productView->render('addProduct');
    }
    public static function deleteProducts(array $items_to_delete): void
    {
        Product::deleteSelectedItems(array_keys($items_to_delete));
    }
    public static function create(array $product): void
    {
        //validate
        $product['productType'] = 'App\\Models\\' . $product['productType'];
        $productToAdd = new  $product['productType']($product['sku'], $product['name'], (float)$product['price']);
        $productToAdd->save($product);
    }
}
