// AuthService - handles all authentication API calls
const AuthService = {
  API_URL: 'https://hadrofit-vxizr.ondigitalocean.app/backend',
  
  // Register new user
  register: function(userData, successCallback, errorCallback) {
    $.ajax({
      url: `${this.API_URL}/auth/register`,
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(userData),
      success: successCallback,
      error: errorCallback
    });
  },
  
  // Login user
  login: function(credentials, successCallback, errorCallback) {
    $.ajax({
      url: `${this.API_URL}/auth/login`,
      method: 'POST',
      contentType: 'application/json',
      data: JSON.stringify(credentials),
      success: function(response) {
        // Save token and user to localStorage
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('currentUser', JSON.stringify(response.data));
        successCallback(response);
      },
      error: errorCallback
    });
  },
  
  // Logout
  logout: function() {
    localStorage.removeItem('token');
    localStorage.removeItem('currentUser');
    window.location.hash = '#login';
  },
  
  // Get current user
  getCurrentUser: function() {
    const user = localStorage.getItem('currentUser');
    return user ? JSON.parse(user) : null;
  },
  
  // Get token
  getToken: function() {
    return localStorage.getItem('token');
  },
  
  // Check if user is logged in
  isLoggedIn: function() {
    return !!this.getToken();
  }
};