$(document).ready(function() {
    var app = $.spapp({
        defaultView: "home",
        templateDir: "frontend/views/"
    });
    app.run();
});
