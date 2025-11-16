<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>HadroFit API Docs</title>
  <link rel="stylesheet" type="text/css" href="swagger-ui.css" />
  <link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
  <style>
    html { box-sizing: border-box; overflow-y: scroll; }
    *, *:before, *:after { box-sizing: inherit; }
    body { margin:0; background: #f6f8fa; }
  </style>
</head>

<body>
  <div id="swagger-ui"></div>

  <script src="swagger-ui-bundle.js"></script>
  <script src="swagger-ui-standalone-preset.js"></script>
  <script>
    const ui = SwaggerUIBundle({
      url: "swagger.php",
      dom_id: '#swagger-ui',
      deepLinking: true,
      presets: [
        SwaggerUIBundle.presets.apis,
        SwaggerUIStandalonePreset
      ],
      layout: "BaseLayout"
    })
  </script>
</body>
</html>
