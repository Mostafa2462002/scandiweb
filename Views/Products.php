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
                                          <a href="/scandiweb/add-product" class="btn btn-outline-success m-2">ADD</a>
                                   </li>
                                   <li class="nav-item">
                                          <button type="submit" class="btn btn-outline-danger m-2" onclick="document.getElementById('items-form').submit()" id='delete-product-button'>MASS DELETE</button>
                                   </li>
                            </ul>
                     </div>
              </div>
       </nav>

       <main>
              <form id="items-form" action="/scandiweb/delete" method='POST'>
              <div class="container">
                     <div class="row">
                            <?= $content ?? null ?>
                       
                     </div>
              </div>
              </form>
       </main>
