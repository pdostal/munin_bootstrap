<?php
  require_once('config.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Munin template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <section class="container">
      <article>
        <h1><?php echo gethostname(); ?></h1>
<?php
  foreach ($config['url'] as $url) {
    $i = 0;
    foreach ($config['service'] as $service) {
      echo "\t\t<h2>".$service."</h2>\n";
      if ($i==0) echo "\t\t<div class='row'>\n";
      echo "\t\t\t<div class='col-md-4 munin_plugin'>\n";
      foreach ($config['time'] as $time) {
        echo "\t\t\t\t<img src='".$url."/".$service."-".$time.".png' alt='' />\n";
      }
      echo "\t\t\t</div>\n";
      if ( $i == 2 || $i == count($service)-1 ) echo "\t\t</div>\n";
      $i++;
    }
  }
?>
      </article>
    </section>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>