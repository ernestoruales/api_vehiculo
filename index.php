<?php
include_once './config.php';
?>
<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Documentacion API</title>
    <link rel="stylesheet" type="text/css" href="./lib/swagger-ui.css" />
    <link rel="stylesheet" type="text/css" href="./lib/index.css" />
    <link rel="icon" type="image/png" href="./lib/favicon.ico"/>
  </head>

  <body>
    <div id="swagger-ui"></div>
    <script src="./lib/swagger-ui-bundle.js" charset="UTF-8"> </script>
    <script src="./lib/swagger-ui-standalone-preset.js" charset="UTF-8"> </script>
    <script>
        var tt = new Date().getTime();
        var urls = [
            {"url":"<?php echo SERVER; ?>/vehiculo/documentacion/openapi.json?tiempo="+tt, "name":"API VEHICULO"}
        ];
        window.onload = function() {
            window.ui = SwaggerUIBundle({
              urls: urls,
              dom_id: '#swagger-ui',
              deepLinking: true,
              presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
              ],
              plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
              ],
              layout: "StandaloneLayout"
            });

            //</editor-fold>
          };
    </script>
  </body>
</html>
