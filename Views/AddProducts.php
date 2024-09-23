<nav class="navbar navbar-expand-sm navbar-light mb-5 mt-1">
    <div class="container">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse">
        <strong style='font-size:30px;'>Product Add</strong>
      </div>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <button  id="buttonno" type="button" class="btn btn-outline-primary m-2" onclick="formValidation.checkForm()">Save</button>
          </li>
          <li class="nav-item">
            <button type="button" class="btn btn-outline-danger m-2" onclick="location.href='/scandiweb/'">Cancel</button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container ">
    <div id="alert" class="row justify-content-center">
    </div>
        
 
    <div class="row justify-content-center">  
    <form id="product_form" action="/scandiweb/new-product/" method="POST" class=" p-4 rounded shadow-sm col-4 " style="background-color:#f4e1c1" >  
    <div class="mb-3">
        <label for="sku" class="form-label">SKU:</label>
        <input type="text" class="form-control" id="sku" name="sku">
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Name:</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="mb-3">
        <label for="price" class="form-label ">Price:</label>
        <input type="number" step="1" class="form-control" id="price" name="price" required>
      </div>
      <div class="mb-3">
        <label for="productType" class="form-label">Type:</label>
        <select id="productType" class="form-control" name="productType" onchange="formValidation.showTypeAttributes()" required>
          <option value="" disabled selected>Select type</option>
          <option value="DVD" >DVD</option>
          <option value="Book" >Book</option>
          <option value="Furniture" >Furniture</option>
        </select>
      </div>
      <div id="DVD" class="mb-3" style="display: none;">
        <label for="size" class="form-label">Size (MB):</label>
        <input type="number" class="form-control" id="size" name="size">
        <div> Please, Provide Size in (MB)</div>
      </div>
      <div id="Book" class="mb-3" style="display: none;">
        <label for="weight" class="form-label">Weight (KG):</label>
        <input type="number" class="form-control" id="weight" name="weight" >
        <div> Please, Provide Weight in (KG)</div>

      </div>
      <div id="Furniture" class="mb-3" style="display: none;">
        <label for="height" class="form-label">Height (CM):</label>
        <input type="number" class="form-control" id="height" name="height" >
        <label for="width" class="form-label">Width (CM):</label>
        <input type="number" class="form-control" id="width" name="width">
        <label for="length" class="form-label">Length (CM):</label>
        <input type="number" class="form-control" id="length" name="length">
        <br>
        <div> Please, Provide the Height, Width and Lenght for the Furniture</div>

      </div>
     

    </form>
    </div>
  </div>
  </div>
 

  <script src='assets/formValidation.js'></script>