// ProductService - handles all product API calls with JWT
const ProductService = {
  API_URL: 'http://localhost/hadrofit/backend/api',
  
  // Get all products
  getAll: function(successCallback, errorCallback) {
    $.ajax({
      url: `${this.API_URL}/products`,
      type: 'GET',
      beforeSend: function(xhr) {
        xhr.setRequestHeader('Authentication', AuthService.getToken());
      },
      success: successCallback,
      error: errorCallback
    });
  },
  
  // Get product by ID
  getById: function(id, successCallback, errorCallback) {
    $.ajax({
      url: `${this.API_URL}/products/${id}`,
      type: 'GET',
      beforeSend: function(xhr) {
        xhr.setRequestHeader('Authentication', AuthService.getToken());
      },
      success: successCallback,
      error: errorCallback
    });
  },
  
  // Create product (admin only)
  create: function(productData, successCallback, errorCallback) {
    $.ajax({
      url: `${this.API_URL}/products`,
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(productData),
      beforeSend: function(xhr) {
        xhr.setRequestHeader('Authentication', AuthService.getToken());
      },
      success: successCallback,
      error: errorCallback
    });
  }
};