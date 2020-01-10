<?php
  if(array_key_exists('city', $_GET)) {
    $url = "https://www.weather-forecast.com/locations/".str_replace(" ", "-", ucwords($_GET["city"]))."/forecasts/latest";
    $url_headers = @get_headers($url);
    if(!$url_headers || $url_headers[0] == 'HTTP/1.1 404 Not Found') {
      $todaysForecast = "Not Found";
    }
    else {
      $forecastPage = file_get_contents($url);
      $forecastPageArray1 = explode('<h2 class="location-summary__heading">'.ucwords($_GET["city"]).' Weather Today</h2> (1&ndash;3 days):</div><p class="location-summary__text"><span class="phrase">', $forecastPage);
      $forecastPageArray2 = explode('</span></p></div><div class="location-summary__item location-summary__item--js is-truncated">', $forecastPageArray1[1]);
      $todaysForecast = $forecastPageArray2[0];
    }
  }

  //echo ucfirst($_GET["city"]);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/fonts.css">
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap-jquery.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <style>

    /*
      .container {
        width: 100%;
        height: auto;
        padding: 0;
      }

      .row {
        width: 100%;
        height: auto;
        margin: 0;
        padding-top: 1em;
      }

      .col-md-10.col-md-offset-2 {
        background-image: url("sunset.jpg");
      }

      */

      html {
        background: url("assets/images/sunset.jpg") no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }

      body {
        background: none;
      }

      .container {
        margin-top: 3em;
        margin-left: auto;
        margin-right: auto;
        width: 60%;
        text-align: center;
      }

      /*
      .btn.btn-primary {
        width: 60%;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
      }

      #button_div {
        width: 60%;
        margin-left: auto;
        margin-right: auto;
      }

      */

      h1 {
        margin-bottom: 1em;
      }

    </style>
  </head>
  <body>
    <div class="container">
      <h1>What's the weather?</h1>
      <div id="error"><? echo $errorMessage.$successMessage ?></div>
        <form id="weatherForm" method="get">
          <div class="form-group">
            <label for="city">Enter the name of a city</label>
            <input type="text" class="form-control" name="city" id="city" value="<?php if ($_GET["city"]) { echo $_GET["city"]; } ?>" placeholder="E.g. London, Paris, Istanbul...">
          </div>
          <div class="form-group">
            <label for="forecast">Forecast</label>
            <textarea class="form-control" name="forecast" id="forecast" rows="3" readonly><?php if ($todaysForecast) { echo $todaysForecast; } ?></textarea>
          </div>
          <div class="form-group">
              <button type="submit" id="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
  </body>
  <script>
    $('#submit').click(function(e) {
      $('#weatherForm').submit();
    });
  </script>
</html>
