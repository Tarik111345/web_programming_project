// Frontend Validation Setup for Milestone 5
// jQuery Validation + BlockUI integration

$(document).ready(function() {

  // ==================== LOGIN FORM VALIDATION ====================
  $("#loginForm").validate({
    rules: {
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 6
      }
    },
    messages: {
      email: {
        required: "Please enter your email address",
        email: "Please enter a valid email address"
      },
      password: {
        required: "Please enter your password",
        minlength: "Password must be at least 6 characters long"
      }
    },
    errorElement: 'span',
    errorClass: 'text-danger small',
    errorPlacement: function(error, element) {
      error.insertAfter(element);
    }
  });

  // ==================== REGISTER FORM VALIDATION ====================
  $("#registerForm").validate({
    rules: {
      name: {
        required: true,
        minlength: 3
      },
      email: {
        required: true,
        email: true
      },
      password: {
        required: true,
        minlength: 6,
        maxlength: 20
      },
      confirmPassword: {
        required: true,
        equalTo: "#regPassword"
      }
    },
    messages: {
      name: {
        required: "Please enter your full name",
        minlength: "Name must be at least 3 characters long"
      },
      email: {
        required: "Please enter your email address",
        email: "Please enter a valid email address"
      },
      password: {
        required: "Please enter a password",
        minlength: "Password must be at least 6 characters long",
        maxlength: "Password cannot be longer than 20 characters"
      },
      confirmPassword: {
        required: "Please confirm your password",
        equalTo: "Passwords do not match"
      }
    },
    errorElement: 'span',
    errorClass: 'text-danger small',
    errorPlacement: function(error, element) {
      error.insertAfter(element);
    }
  });

  // ==================== ADD PRODUCT FORM VALIDATION ====================
  $("#addProductForm").validate({
    rules: {
      name: {
        required: true,
        minlength: 3
      },
      price: {
        required: true,
        number: true,
        min: 0.01
      },
      category_id: {
        required: true,
        digits: true,
        min: 1
      },
      stock: {
        required: true,
        digits: true,
        min: 0
      },
      image: {
        url: true
      }
    },
    messages: {
      name: {
        required: "Please enter product name",
        minlength: "Product name must be at least 3 characters"
      },
      price: {
        required: "Please enter product price",
        number: "Please enter a valid number",
        min: "Price must be greater than 0"
      },
      category_id: {
        required: "Please enter category ID",
        digits: "Please enter a valid category ID",
        min: "Category ID must be at least 1"
      },
      stock: {
        required: "Please enter stock quantity",
        digits: "Please enter a valid number",
        min: "Stock cannot be negative"
      },
      image: {
        url: "Please enter a valid URL"
      }
    },
    errorElement: 'span',
    errorClass: 'text-danger small',
    errorPlacement: function(error, element) {
      error.insertAfter(element);
    }
  });

  // ==================== EDIT PRODUCT FORM VALIDATION ====================
  $("#editProductForm").validate({
    rules: {
      name: {
        required: true,
        minlength: 3
      },
      price: {
        required: true,
        number: true,
        min: 0.01
      },
      category_id: {
        required: true,
        digits: true,
        min: 1
      },
      stock: {
        required: true,
        digits: true,
        min: 0
      },
      image: {
        url: true
      }
    },
    messages: {
      name: {
        required: "Please enter product name",
        minlength: "Product name must be at least 3 characters"
      },
      price: {
        required: "Please enter product price",
        number: "Please enter a valid number",
        min: "Price must be greater than 0"
      },
      category_id: {
        required: "Please enter category ID",
        digits: "Please enter a valid category ID",
        min: "Category ID must be at least 1"
      },
      stock: {
        required: "Please enter stock quantity",
        digits: "Please enter a valid number",
        min: "Stock cannot be negative"
      },
      image: {
        url: "Please enter a valid URL"
      }
    },
    errorElement: 'span',
    errorClass: 'text-danger small',
    errorPlacement: function(error, element) {
      error.insertAfter(element);
    }
  });

});
