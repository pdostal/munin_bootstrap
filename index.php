<?php
  require_once('config.php');
  $data = exec('uptime');
  $uptime = preg_replace('/^.+ up |, .+$/i', ' ', $data);
  $load = explode(' ', $data);
  $load = $load[count($load)-3]." ".$load[count($load)-2]." ".$load[count($load)-1];
  $uname = php_uname();
  $uname = explode(' ', $uname);
  $uname = $uname[2];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Munin template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/lightbox.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <nav class='navbar navbar-default navbar-fixed-top' role='navigation'>
      <div class='navbar-header'>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <h1 class='navbar-brand'><?php echo gethostname(); ?></h1>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              Categories <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
<?php
  $i = 0;
  foreach ($config['group'] as $group) {
    echo "\t\t\t<li><a class='scroll' data-speed='300' data-easing='easeInOutCubic' href='#category".$i."'>".$group."</a></li>\n";
    $i++;
  }
?>
            </ul>
            </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"><span class="glyphicon glyphicon-arrow-up"></span></a></li>
        </ul>
    </div>
  </nav>
<?php
  foreach ($config['url'] as $url) {
    $i = 0;
    $j = 0;
    foreach ($config['service'] as $service) {
      if ( $config['service'][$j]['group'] !== $config['service'][$j-1]['group'] ) {
        echo "\t\t<section class='category' id='category".$service['group']."'>\n";
        echo "\t\t\t<div class='container'>\n";
      }
      if ($i==0) echo "\t\t\t\t<div class='row'>\n";
      echo "\t\t\t\t\t<div class='col-md-4 munin_plugin'>\n";
      echo "\t\t\t\t\t\t<h2>".$service['name']."</h2>\n";
      foreach ($config['time'] as $time) {
        echo "\t\t\t\t\t\t<a href='".$url.$service['id']."-".$time.".png' class='graph_wrapper' data-lightbox='".$service['id']."' title='".$service['name']." last ".$time."'><img class='lazy' src='' data-src='".$url.$service['id']."-".$time.".png' alt='".$service['name']." last ".$time."' /></a>\n";
      }
      echo "\t\t\t\t\t</div>\n";
      if ( $i == 2 || $config['service'][$j]['group'] !== $config['service'][$j+1]['group'] ) {
        echo "\t\t\t\t</div>\n";
        $i = 0;
      } else {
        $i++;
      }
      if ( $config['service'][$j]['group'] !== $config['service'][$j+1]['group'] ) {
        echo "\t\t\t\t<hr />\n";
        echo "\t\t\t</div>\n";
        echo "\t\t</section>\n";
      }
      $j++;
    }
  }
?>
    <footer class='container'>
      <span>Source: <a href='<?php echo $config['url']; ?>'>Munin</a></span>
    </footer>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/smooth-scroll.js"></script>
    <script src="js/lightbox.min.js"></script>
    <script src="js/lazy.min.js"></script>
    <script>
      jQuery(document).ready(function() {
        jQuery("img.lazy").lazy();
      });
    </script>
  </body>
</html>