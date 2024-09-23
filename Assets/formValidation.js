class formValidation {

  static checkForm() {

    let errMsgHTML = '';
    const alertContainer = document.getElementById('alert');
    var form = document.getElementById('product_form');
    let isValid = true;
    let isCorrect = true;
    const productType = document.getElementById('productType');
    productType.classList.toggle('is-invalid', !productType.value);
    !productType.value ? isValid = false : null;

    form.querySelectorAll('input').forEach(input => {
      var areFieldsPresent = input.parentElement.style.display !== 'none' && !input.value;
      areFieldsPresent ? isValid = false : null;
      input.classList.toggle('is-invalid', areFieldsPresent);

      var correctInputLength = Number(input.value.length) > 30
      if (correctInputLength) {
        isCorrect = false;
        input.classList.toggle('is-invalid', correctInputLength);
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
        const skuPattern = /^[a-zA-Z0-9]+$/;//regular expression checking text and numbers for SKUs and Names
        let isTextNumber = skuPattern.test(input.value);
        if (!isTextNumber) {
          isCorrect = false;
          input.classList.toggle('is-invalid', !isTextNumber);
        }
      }
    })
    

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
