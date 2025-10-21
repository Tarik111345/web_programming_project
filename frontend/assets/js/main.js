$(document).ready(function () {
  window.app = $.spapp({
    defaultView: "home",
    templateDir: "./views/",
  });

  app.route({ view: "home",           load: "home.html" });
  app.route({ view: "products_list",  load: "products_list.html" });
  app.route({ view: "cart",           load: "cart.html" });
  app.route({ view: "checkout",       load: "checkout.html" });
  app.route({ view: "dashboard_user", load: "dashboard_user.html" });
  app.route({ view: "login",          load: "login.html" });
  app.route({ view: "register",       load: "register.html" });

  app.run();

  // After SPApp starts, handle the current route (and on every route change)
  handleRouteRender();
  $(window).on("hashchange", handleRouteRender);
});

// Helpers


// Waits until a selector exists in DOM, then runs fn.
// Solves the "view not yet injected by SPApp when we try to render" problem.
function renderWhenReady(selector, fn, attempts = 40) {
  if ($(selector).length) {
    fn();
  } else if (attempts > 0) {
    setTimeout(() => renderWhenReady(selector, fn, attempts - 1), 50);
  }
}

// Route-aware rendering for views that need DOM nodes present
function handleRouteRender() {
  const hash = window.location.hash || "#home";
  if (hash === "#cart") {
    renderWhenReady("#cartItems", renderCart);
  } else if (hash === "#checkout") {
    renderWhenReady("#checkoutSummary", renderCheckout);
  } else if (hash === "#dashboard_user") {
    renderWhenReady("#dashboardUserName", renderDashboard);
  }
}


// Mock products 
const products = [
  { id: 1, name: "Whey Protein", price: "$29.99", img: "assets/img/protein1.jpg.png", description: "High-quality whey protein for muscle growth.", details: ["24g protein", "Serving Size: 1 scoop", "Availability: In Stock"] },
  { id: 2, name: "Multivitamins", price: "$19.99", img: "assets/img/vitamins.jpg.png", description: "Daily essential vitamins and minerals to keep your body healthy.", details: ["100% daily values", "Serving Size: 1 tablet", "Availability: In Stock"] },
  { id: 3, name: "Creatine Monohydrate", price: "$24.99", img: "assets/img/creatine.jpg.png", description: "Boost strength and endurance during high-intensity workouts.", details: ["5g creatine per serving", "Serving Size: 1 scoop", "Availability: In Stock"] },
  { id: 4, name: "BCAA", price: "$21.99", img: "assets/img/bcaa.jpg.png", description: "Branched-chain amino acids to support muscle recovery.", details: ["6g BCAA", "Serving Size: 1 scoop", "Availability: In Stock"] },
  { id: 5, name: "Pre-Workout", price: "$27.99", img: "assets/img/preworkout.jpg.png", description: "Increase energy and focus before training sessions.", details: ["Caffeine 200mg", "Serving Size: 1 scoop", "Availability: In Stock"] },
  { id: 6, name: "Omega 3", price: "$17.99", img: "assets/img/omega3.jpg.png", description: "Supports heart, brain, and joint health.", details: ["1000mg fish oil", "Serving Size: 1 softgel", "Availability: In Stock"] },
  { id: 7, name: "Glutamine", price: "$22.99", img: "assets/img/glutamine.jpg.png", description: "Promotes muscle recovery and immune system support.", details: ["5g glutamine", "Serving Size: 1 scoop", "Availability: In Stock"] },
  { id: 8, name: "Protein Bar", price: "$9.99", img: "assets/img/proteinbar.jpg.png", description: "Convenient high-protein snack for on-the-go nutrition.", details: ["20g protein", "Serving Size: 1 bar", "Availability: In Stock"] },
];


// Product modal (View Details)
$("#spapp").on("click", ".view-details", function () {
  const productId = $(this).closest(".product-card").data("id");
  const product = products.find((p) => p.id === productId);
  if (!product) return;

  $("#productModalLabel").text(product.name);
  $("#productModalPrice").text(product.price);
  $("#productModalImage").attr("src", product.img);
  $("#productModalDescription").text(product.description);

  const detailsList = $("#productModalDetails");
  detailsList.empty();
  product.details.forEach((d) => detailsList.append(`<li>${d}</li>`));

  const modal = new bootstrap.Modal(document.getElementById("productModal"));
  modal.show();

  $("#modalAddToCart")
    .off("click")
    .on("click", function () {
      addToCart(product.id);
      modal.hide();
    });
});


// Cart system

// Load existing cart from localStorage
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// Save cart to localStorage
function saveCart() {
  localStorage.setItem("cart", JSON.stringify(cart));
}

// Render cart table
function renderCart() {
  const cartItems = $("#cartItems");
  if (cartItems.length === 0) return; 
  cartItems.empty();
  let total = 0;

  if (cart.length === 0) {
    cartItems.html(`<tr><td colspan="5" class="text-center">Your cart is empty.</td></tr>`);
    $("#cartTotal").text("0.00");
    return;
  }

  cart.forEach((item, index) => {
    const itemTotal = item.price * item.quantity;
    total += itemTotal;

    cartItems.append(`
      <tr>
        <td>
          <img src="${item.img}" alt="${item.name}" width="60" class="me-2 rounded">
          ${item.name}
        </td>
        <td>$${item.price.toFixed(2)}</td>
        <td>
          <input type="number" min="1" value="${item.quantity}" class="form-control form-control-sm quantity-input" data-index="${index}">
        </td>
        <td>$${itemTotal.toFixed(2)}</td>
        <td>
          <button class="btn btn-danger btn-sm remove-item" data-index="${index}">Remove</button>
        </td>
      </tr>
    `);
  });

  $("#cartTotal").text(total.toFixed(2));
  saveCart();
}

// Add product to cart
function addToCart(productId) {
  const product = products.find((p) => p.id === productId);
  if (!product) return;
  const existing = cart.find((p) => p.id === product.id);
  const numericPrice = parseFloat(product.price.replace("$", ""));

  if (existing) {
    existing.quantity += 1;
  } else {
    cart.push({
      ...product,
      price: numericPrice,
      quantity: 1,
    });
  }

  saveCart();
  alert(`${product.name} added to cart!`);
}

// Add-to-cart buttons in products list
$(document).on("click", ".add-to-cart", function () {
  const productId = $(this).closest(".product-card").data("id");
  addToCart(productId);
});

// Quantity change
$(document).on("input", ".quantity-input", function () {
  const index = $(this).data("index");
  const newQty = parseInt($(this).val(), 10);
  cart[index].quantity = newQty > 0 ? newQty : 1;
  saveCart();
  renderCart();
});

// Remove item
$(document).on("click", ".remove-item", function () {
  const index = $(this).data("index");
  cart.splice(index, 1);
  saveCart();
  renderCart();
});

// Checkout system

function renderCheckout() {
  const summary = $("#checkoutSummary");
  if (summary.length === 0) return;

  summary.empty();
  let total = 0;

  if (cart.length === 0) {
    summary.html(`<li class="list-group-item text-center">Your cart is empty.</li>`);
    $("#checkoutTotal").text("$0.00");
    return;
  }

  cart.forEach((item) => {
    const itemTotal = item.price * item.quantity;
    total += itemTotal;
    summary.append(`
      <li class="list-group-item d-flex justify-content-between align-items-center">
        <span>${item.name} (x${item.quantity})</span>
        <span>$${itemTotal.toFixed(2)}</span>
      </li>
    `);
  });

  $("#checkoutTotal").text(`$${total.toFixed(2)}`);
}

// Place order 
$(document).on("submit", "#checkoutForm", function (e) {
  e.preventDefault();

  if (cart.length === 0) {
    alert("Your cart is empty!");
    return;
  }

  const name = $("#name").val().trim();
  const email = $("#email").val().trim();
  const address = $("#address").val().trim();
  const payment = $("#payment").val();

  if (!name || !email || !address || !payment) {
    alert("Please fill in all fields!");
    return;
  }

  alert(`✅ Thank you ${name}! Your order has been placed successfully.`);

  cart = [];
  saveCart();

  window.location.hash = "#home";
});

// Register system

$(document).on("submit", "#registerForm", function (e) {
  e.preventDefault();

  const name = $("#regName").val().trim();
  const email = $("#regEmail").val().trim().toLowerCase();
  const password = $("#regPassword").val();
  const confirm = $("#regConfirm").val();

  if (!name || !email || !password || !confirm) {
    alert("Please fill in all fields!");
    return;
  }

  if (password !== confirm) {
    alert("Passwords do not match!");
    return;
  }

  let users = JSON.parse(localStorage.getItem("users")) || [];

  if (users.some((u) => u.email === email)) {
    alert("An account with this email already exists!");
    return;
  }

  const newUser = { name, email, password };
  users.push(newUser);
  localStorage.setItem("users", JSON.stringify(users));

  alert("✅ Registration successful! You can now log in.");
  window.location.hash = "#login";
});


// Login system 
$(document).on("submit", "#loginForm", function (e) {
  e.preventDefault();

  const email = $("#loginEmail").val().trim().toLowerCase();
  const password = $("#loginPassword").val();

  if (!email || !password) {
    alert("Please fill in all fields!");
    return;
  }

  let users = JSON.parse(localStorage.getItem("users")) || [];
  const user = users.find((u) => u.email === email && u.password === password);

  if (!user) {
    alert("Invalid email or password!");
    return;
  }

  localStorage.setItem("currentUser", JSON.stringify(user));
  alert(`✅ Welcome back, ${user.name}!`);

  // Move to dashboard; rendering will be handled by handleRouteRender + renderWhenReady
  window.location.hash = "#dashboard_user";
});


// Dashboard
function renderDashboard() {
  const user = JSON.parse(localStorage.getItem("currentUser"));
  if (!user) {
    alert("⚠ You must login first!");
    window.location.hash = "#login";
    return;
  }

  $("#dashboardUserName").text(user.name);
  $("#dashboardUserEmail").text(user.email);

  const cartBody = $("#dashboardCartBody");
  const cartTotalEl = $("#dashboardCartTotal");
  const localCart = JSON.parse(localStorage.getItem("cart")) || [];
  cartBody.empty();
  let total = 0;

  if (localCart.length === 0) {
    cartBody.append(`<tr><td colspan="3" class="text-center">Your cart is empty.</td></tr>`);
    cartTotalEl.text("0.00");
    return;
  }

  localCart.forEach((item) => {
    const itemTotal = item.price * item.quantity;
    total += itemTotal;
    cartBody.append(`
      <tr>
        <td>${item.name}</td>
        <td>${item.quantity}</td>
        <td>$${itemTotal.toFixed(2)}</td>
      </tr>
    `);
  });

  cartTotalEl.text(total.toFixed(2));
}

// Logout
$(document).on("click", "#logoutBtn", function () {
  localStorage.removeItem("currentUser");
  alert("✅ You have been logged out!");
  window.location.hash = "#login";
});
