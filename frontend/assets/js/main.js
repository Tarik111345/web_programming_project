$(document).ready(function() {
    var app = $.spapp({
        defaultView: "home",
        templateDir: "./views/"
    });

    app.route({ view: "home", load: "home.html" });
    app.route({ view: "products_list", load: "products_list.html" });
    app.route({ view: "cart", load: "cart.html" });
    app.route({ view: "checkout", load: "checkout.html" });
    app.route({ view: "dashboard_user", load: "dashboard_user.html" });
    app.route({ view: "login", load: "login.html" });
    app.route({ view: "register", load: "register.html" });

    app.run();
});



const products = [
  { id: 1, name: "Whey Protein", price: "$29.99", img: "assets/img/protein1.jpg.png", description: "High-quality whey protein for muscle growth.", details: ["24g protein", "Serving Size: 1 scoop", "Availability: In Stock"] },
  { id: 2, name: "Multivitamins", price: "$19.99", img: "assets/img/vitamins.jpg.png", description: "Daily essential vitamins and minerals to keep your body healthy.", details: ["100% daily values", "Serving Size: 1 tablet", "Availability: In Stock"] },
  { id: 3, name: "Creatine Monohydrate", price: "$24.99", img: "assets/img/creatine.jpg.png", description: "Boost strength and endurance during high-intensity workouts.", details: ["5g creatine per serving", "Serving Size: 1 scoop", "Availability: In Stock"] },
  { id: 4, name: "BCAA", price: "$21.99", img: "assets/img/bcaa.jpg.png", description: "Branched-chain amino acids to support muscle recovery.", details: ["6g BCAA", "Serving Size: 1 scoop", "Availability: In Stock"] },
  { id: 5, name: "Pre-Workout", price: "$27.99", img: "assets/img/preworkout.jpg.png", description: "Increase energy and focus before training sessions.", details: ["Caffeine 200mg", "Serving Size: 1 scoop", "Availability: In Stock"] },
  { id: 6, name: "Omega 3", price: "$17.99", img: "assets/img/omega3.jpg.png", description: "Supports heart, brain, and joint health.", details: ["1000mg fish oil", "Serving Size: 1 softgel", "Availability: In Stock"] },
  { id: 7, name: "Glutamine", price: "$22.99", img: "assets/img/glutamine.jpg.png", description: "Promotes muscle recovery and immune system support.", details: ["5g glutamine", "Serving Size: 1 scoop", "Availability: In Stock"] },
  { id: 8, name: "Protein Bar", price: "$9.99", img: "assets/img/proteinbar.jpg.png", description: "Convenient high-protein snack for on-the-go nutrition.", details: ["20g protein", "Serving Size: 1 bar", "Availability: In Stock"] }
];

$("#spapp").on("click", ".view-details", function() {
  const productId = $(this).closest(".product-card").data("id");
  const product = products.find(p => p.id === productId);
  
  $("#productModalLabel").text(product.name);
  $("#productModalPrice").text(product.price);
  $("#productModalImage").attr("src", product.img);
  $("#productModalDescription").text(product.description);

  const detailsList = $("#productModalDetails");
  detailsList.empty();
  product.details.forEach(d => detailsList.append(`<li>${d}</li>`));

  const modal = new bootstrap.Modal(document.getElementById('productModal'));
  modal.show();

  $("#modalAddToCart").off("click").on("click", function() {
    alert(product.name + " added to cart!");
    modal.hide();
  });
});
