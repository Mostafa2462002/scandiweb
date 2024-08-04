<?php try {
       include_once '_classes/DataBase.php';
       include '_classes/Product.php';
} catch (error $e) {
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
       <meta charset="UTF-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
       <title>Scandiweb Test</title>
       <link rel="icon" href="circle-32.png" type="image/png">

</head>

<body style="background-color:#ebebe0">
       <nav class=" navbar navbar-expand-sm navbar-light  mb-5 mt-1 ">
              <div class="container ">
                     <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                     </button>
                     <div class="collapse navbar-collapse">
                            <strong style='font-size:30px;'>Product List</strong>
                     </div>
                     <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                            <ul class="navbar-nav">
                                   <li class="nav-item">
                                          <a href="add-product.php" class="btn btn-outline-success m-2">ADD</a>
                                   </li>
                                   <li class="nav-item">
                                          <button type="submit" class="btn btn-outline-danger m-2" onclick="document.getElementById('items-form').submit()" id='delete-product-button'>MASS DELETE</button>
                                   </li>
                            </ul>
                     </div>
              </div>
       </nav>

       <form id="items-form" method="POST" action="index.php">
              <?php if (isset($_POST)) {
                     $x = $_POST;
                     Product::deleteSelectedItems($x);
              } ?>
              <main>
                     <div class="container">
                            <div class="row">

                                   <?php
                                   $results = Product::displayProducts();
                                   ?>
                            </div>
                     </div>
              </main>
       </form>
       <script>

       </script>



       <!-- Bootstrap JS -->
       <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
       <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>



</body>

</html>
