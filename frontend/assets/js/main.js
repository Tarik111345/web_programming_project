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
