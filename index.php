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
    $j = 0;
    foreach ($config['service'] as $service) {
      if ($i==0) echo "\t\t<div class='row'>\n";
      echo "\t\t\t<div class='col-md-4 munin_plugin'>\n";
      echo "\t\t\t\t<h2>".$service['name']."</h2>\n";
      foreach ($config['time'] as $time) {
        echo "\t\t\t\t<img src='".$url."/".$service['id']."-".$time.".png' alt='' />\n";
      }
      echo "\t\t\t</div>\n";
      if ( $i == 2 || $config['service'][$j]['group'] !== $config['service'][$j+1]['group'] ) {
        echo "\t\t</div>\n";
        $i = 0;
      } else {
        $i++;
      }
      if ( $config['service'][$j]['group'] !== $config['service'][$j+1]['group'] ) echo "\t\t<hr />\n";
      $j++;
    }
  }
?>
      </article>
    </section>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>