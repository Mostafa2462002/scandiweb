class formValidation {
  // every product will have sku, name, price
  // but for scalability the types might increase, features of these types might increase aswell'
  #sku;
  #name;
  #price;
  constructor(name, sku, price) {
    this.#name = name;
    this.#price = price;
    this.#sku = sku;
  }
  get name() {
    return this.#name;
  }

  get sku() {
    return this.#sku;
  }

  get price() {
    return this.#price;
  }

  static checkForm() {
   
    //this code copes with adding more types or more attributes to each type-- checks if inputs are empty
    var form = document.getElementById('product_form');
    var sku = document.getElementById('sku');
    var isValid = true;
    var isCorrect = true;
    var productType = document.getElementById('productType');
    productType.classList.toggle('is-invalid', !productType.value);
    !productType.value ? isValid = false : null;

    form.querySelectorAll('input').forEach(input => {
      var areFieldsPresent = input.parentElement.style.display !== 'none' && !input.value;
      areFieldsPresent ? isValid = false : null;
      input.classList.toggle('is-invalid', areFieldsPresent);

      var correctInputLength = Number(input.value.length) > 30
      if(correctInputLength)
        {
          isCorrect = false;
          input.classList.toggle('is-invalid',correctInputLength);
        }



      
    })
    
    document.querySelectorAll('input').forEach(input => {
      if (input.type == 'number' && input.value != '') {
        var positiveNumberRegex = /^[0-9]+(\.[0-9]+)?$/; //regular expression checking for positive numbers, floats
        var isPositiveNumber = positiveNumberRegex.test(input.value)
        if (!isPositiveNumber) {
          isCorrect = false;
          input.classList.toggle('is-invalid', !isPositiveNumber);
        }

      }

      else if (input.type == 'text' && input.value != '') {
        const skuPattern =/^[a-zA-Z0-9]+$/;//regular expression checking text and numbers for SKUs and Names
        var isTextNumber = skuPattern.test(input.value);
        if (!isTextNumber) {
          isCorrect = false;
          input.classList.toggle('is-invalid', !isTextNumber);
        }

      }
    }
    )
    

    var errMsgHTML = '';

    if (!isValid) {
      errMsgHTML = `
        <div class="alert alert-danger alert-dismissible fade show col-3" role="alert">
        Please, <strong>submit required data</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `




    }
    if (!isCorrect) {
      errMsgHTML = `
       <div class="alert alert-danger alert-dismissible fade show col-3" role="alert">
       Please, <strong>provide the data of indicated type</strong>
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>
     `
    }

    const alertContainer = document.getElementById('alert');
    alertContainer.innerHTML = errMsgHTML;
    
    if (isCorrect && isValid) {
      form.submit()
    }


  }



  static showTypeAttributes() {
    let productType = document.getElementById('productType').value;
    document.getElementById('productType').querySelectorAll('option').forEach(option => {
      let type = document.getElementById(option.value);
      if (type) {
        type.style.display = 'none';
        type.querySelectorAll('input').forEach(input => { input.value = '' })
        if ((type.id == productType)) {
          type.style.display = 'block';
        }
      }
    });


  }


}
