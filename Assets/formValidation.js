class formValidation {

  static checkForm() {
    const alertContainer = document.getElementById('alert');
    var form = document.getElementById('product_form');

    let isValid = this.checkRequiredFields(form);
    let isCorrect = this.validateFieldValues(form);

    this.updateAlertMessage(isValid, isCorrect, alertContainer);

    if (isValid && isCorrect) {
      form.submit();
    }
  }

  static checkRequiredFields(form) {
    let isValid = true;
    const productType = document.getElementById('productType');
    productType.classList.toggle('is-invalid', !productType.value);
    !productType.value ? isValid = false : null;

    form.querySelectorAll('input').forEach(input => {
      var areFieldsPresent = input.parentElement.style.display !== 'none' && !input.value;
      areFieldsPresent ? isValid = false : null;
      input.classList.toggle('is-invalid', areFieldsPresent);
    });

    return isValid;
  }

  static validateFieldValues(form) {
    let isCorrect = true;

    form.querySelectorAll('input').forEach(input => {
      var correctInputLength = Number(input.value.length) > 30;
      if (correctInputLength) {
        isCorrect = false;
        input.classList.toggle('is-invalid', correctInputLength);
      }
    });

    document.querySelectorAll('input').forEach(input => {
      if (input.type === 'number' && input.value !== '') {
        isCorrect = this.validateNumberInput(input, isCorrect);
      } else if (input.type === 'text' && input.value !== '') {
        isCorrect = this.validateTextInput(input, isCorrect);
      }
    });

    return isCorrect;
  }

  // Helper function to validate number input fields
  static validateNumberInput(input, isCorrect) {
    var positiveNumberRegex = /^[0-9]+(\.[0-9]+)?$/; // Regular expression for positive numbers
    var isPositiveNumber = positiveNumberRegex.test(input.value);
    if (!isPositiveNumber) {
      isCorrect = false;
      input.classList.toggle('is-invalid', !isPositiveNumber);
    }
    return isCorrect;
  }

  // Helper function to validate text input fields (for SKU, Name)
  static validateTextInput(input, isCorrect) {
    const skuPattern = /^[a-zA-Z0-9]+$/; // Regular expression for text and numbers
    let isTextNumber = skuPattern.test(input.value);
    if (!isTextNumber) {
      isCorrect = false;
      input.classList.toggle('is-invalid', !isTextNumber);
    }
    return isCorrect;
  }

  // Function to update the alert message
  static updateAlertMessage(isValid, isCorrect, alertContainer) {
    let errMsgHTML = '';

    if (!isValid) {
      errMsgHTML = `
        <div class="alert alert-danger alert-dismissible fade show col-3" role="alert">
        Please, <strong>submit required data</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;
    } else if (!isCorrect) {
      errMsgHTML = `
        <div class="alert alert-danger alert-dismissible fade show col-3" role="alert">
        Please, <strong>provide the data of indicated type</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;
    }

    alertContainer.innerHTML = errMsgHTML;
  }

  static showTypeAttributes() {
    let productType = document.getElementById('productType').value;
    document.getElementById('productType').querySelectorAll('option').forEach(option => {
      let type = document.getElementById(option.value);
      if (type) {
        type.style.display = 'none';
        type.querySelectorAll('input').forEach(input => { input.value = '' });
        if (type.id === productType) {
          type.style.display = 'block';
        }
      }
    });
  }
}
