<?php
namespace App\Core;
class ProductView
{
    // Main render method
    public function render(string $view, array|null $items = []): void
    {
        switch ($view) {
            case 'Products':
                $contents = $this->renderView('Views/Products.php', $this->renderProducts($items)); //contents variable for Layout
                break;
            
            case 'addProduct':
                $contents = $this->renderView('Views/AddProducts.php'); //for layout
                break;
        }

        // Always include the layout template
        include('views/Layout.php');
    }

    // Render the products with dynamic type-specific partials
    private function renderProducts(array|null $items): string|null
    {
        if ($items == null) 
        {   
            return null;
        }

        $error ='';
        ob_start();
        foreach ($items as $item) {
            $type = $item['type'];

            if (method_exists($this, $type)) {
                $this->$type($item);  // Call the dynamic method (DVD, Book, Furniture)
            } else {
                $error  = 'The type of the product doesn\'t exist'. PHP_EOL;
            }
        }
        if($error){
            error_log( 'Error in line 38 of ProductView.php file: '. $error . PHP_EOL ,3,'errors.log');
        }

        return ob_get_clean();
    }

    // Reusable method to render specific views
    private function renderView(string $viewPath, string|null $content = ''): string
    {
            ob_start();
            include($viewPath);
            return ob_get_clean();
    }

    // DVD partial view
    private function DVD($item): void
    {
        include('Views/DvdPartial.php');
    }

    // Book partial view
    private function Book($item): void
    {
        include('Views/BookPartial.php');
    }

    // Furniture partial view
    private function Furniture($item): void
    {
        include('Views/FurniturePartial.php');
    }
}
