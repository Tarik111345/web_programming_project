// ProductService - handles all product API calls with JWT
const ProductService = {
  API_URL: 'https://hadrofit-vxizr.ondigitalocean.app/backend/api',

  // Get all products
  getAll: function(successCallback, errorCallback) {
    $.ajax({
      url: `${this.API_URL}/products`,
      type: 'GET',
      beforeSend: function(xhr) {
        const token = AuthService.getToken();
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
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
        const token = AuthService.getToken();
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
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
        const token = AuthService.getToken();
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: successCallback,
      error: errorCallback
    });
  },

  // Update product (admin only)
  update: function(id, productData, successCallback, errorCallback) {
    $.ajax({
      url: `${this.API_URL}/products/${id}`,
      type: 'PUT',
      contentType: 'application/json',
      data: JSON.stringify(productData),
      beforeSend: function(xhr) {
        const token = AuthService.getToken();
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: successCallback,
      error: errorCallback
    });
  },

  // Delete product (admin only)
  delete: function(id, successCallback, errorCallback) {
    $.ajax({
      url: `${this.API_URL}/products/${id}`,
      type: 'DELETE',
      beforeSend: function(xhr) {
        const token = AuthService.getToken();
        if (token) {
          xhr.setRequestHeader('Authorization', 'Bearer ' + token);
        }
      },
      success: successCallback,
      error: errorCallback
    });
  }
};