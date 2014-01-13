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
    <title>Munin graphs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/lightbox.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/smooth-scroll.js"></script>
    <script src="js/lightbox.min.js"></script>
    <script src="js/lazy.min.js"></script>
    <script src="js/script.js"></script>
  </head>
  <body>
    <nav id='header' class='navbar navbar-default navbar-fixed-top scroll-header' role='navigation'>
      <div class='navbar-header'>
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <h1 class='navbar-brand'>Munin graphs</h1>
      </div>
      <div class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              Servers <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
<?php
  $i = 0;
  foreach ($config['url'] as $url) {
    echo "\t\t\t\t<li><a href='javascript:;' class='scroll menu-server' data-server='server".$i."' data-speed='300' data-easing='easeInOutCubic' data-url='false'>".$url['name']."</a></li>\n";
    $i++;
  }
?>
            </ul>
          </li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              Categories <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
<?php
  $i = 0;
  foreach ($config['group'] as $group) {
    $k = 0;
    foreach ($config['url'] as $url) {
      if ($k != 0) $style = 'display: none;';
      echo "\t\t\t\t<li><a href='javascript:;' id='menu-category".$i."-server".$k."' class='scroll menu-category menu-category-server".$k."' data-category='server".$k."category".$i."' data-speed='300' data-easing='easeInOutCubic' style='".$style."'>".$group."</a></li>\n";
      unset($style);
      $k++;
    }
    $i++;
  }
?>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href='#header' class='scroll' data-speed='300' data-easing='easeInOutCubic'><span class="glyphicon glyphicon-arrow-up"></span></a></li>
        </ul>
      </div>
    </nav>
<?php
  $k = 0;
  foreach ($config['url'] as $url) {
    $i = 0;
    $j = 0;
    if ($k != 0) $style = 'display: none;';
    echo "\t\t<div class='server' id='server".$k."' style='".$style."'>\n";
    unset($style);
    foreach ($config['service'] as $service) {
      if ( $config['service'][$j]['group'] !== $config['service'][$j-1]['group'] ) {
        echo "\t\t\t<section class='category' id='server".$k."category".$service['group']."'>\n";
        echo "\t\t\t\t<div class='container'>\n";
        echo "\t\t\t\t\t<h1>".$config['group'][$i]."</h1>\n";
      }
      echo "\t\t\t\t\t\t<div class='row'>\n";
      echo "\t\t\t\t\t\t\t<h2>".$service['name']."</h2>\n";
      foreach ($config['time'] as $time) {
        echo "\t\t\t\t\t\t\t<a href='".$url['url'].$service['id']."-".$time.".png' class='graph_wrapper col-md-4' data-lightbox='".$service['id']."' title='".$service['name']." last ".$time."'><img class='lazy' src='' data-src='".$url['url'].$service['id']."-".$time.".png' alt='".$service['name']." last ".$time."' /></a>\n";
      }
      echo "\t\t\t\t\t\t</div>\n";
      if ( $config['service'][$j]['group'] !== $config['service'][$j+1]['group'] ) {
        echo "\t\t\t\t\t<hr />\n";
        echo "\t\t\t\t</div>\n";
        echo "\t\t\t</section>\n";
        $i++;
      }
      $j++;
    }
    echo "\t\t</div>\n";
    $k++;
  }
?>
    <footer class='container'>
      <span>
        <a href='http://getbootstrap.com/'>Bootstrap</a>
        <a href='http://jquery.com'>jQuery</a>
        <a href='http://www.php.net'>PHP</a>
        <a href='http://munin-monitoring.org'>Munin</a>
        <a href='http://oss.oetiker.ch/rrdtool/'>RRDtool</a>
        <a href='http://lokeshdhakar.com/projects/lightbox2/'>Lightbox</a>
        <a href='http://www.appelsiini.net/projects/lazyload'>Lazy load</a>
        <a href='http://cferdinandi.github.io/smooth-scroll/'>Smooth scroll</a>
      </span>
    </footer>
  </body>
</html>