<?php
  require_once('config.php');
  function randomColors($range) { 
    $range = $range[rand(0,count($range)-1)];
    $color = str_split($range, 2);
    $background = '#';
    $foreground = '#';
    for($i=0;$i<3;$i++) {
      if (empty($range)) {
        $rand = rand(0,255);
      } else {
        $rand = hexdec($color[$i]);
      }
      if ($rand < 16) $background .= '0';
      $background .= dechex($rand);
      if ($rand > 239) $foreground .= '0';
      $foreground .= dechex(255-$rand);
    }
    return array($background, $foreground);
  }
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
<?php
  $i = 0;
  foreach ($config['group'] as $group) {
    echo "\t\t\t<li><a href='#section".$i."'>".$group."</a></li>\n";
    $i++;
  }
?>
        </ul>
        <div class="nav navbar-nav navbar-right">
          <div class="navbar-text"><span>Uptime: </span><span><?php echo $uptime; ?></span></div>
          <div class="navbar-text"><span>Uname: </span><span><?php echo $uname; ?></span></div>
          <div class="navbar-text"><span>Load: </span><span><?php echo $load; ?></span></div>
        </div>
    </div>
  </nav>
<?php
  foreach ($config['url'] as $url) {
    $i = 0;
    $j = 0;
    foreach ($config['service'] as $service) {
      if ( $config['service'][$j]['group'] !== $config['service'][$j-1]['group'] ) {
        $rand = randomColors(array('AAAAAA', 'BBBBBB', 'CCCCCC', 'DDDDDD', 'EEEEEE'));
        echo "\t\t<section id='section".$service['group']."' style='background-color: ".$rand[0]."; color: ".$rand[1].";'>\n";
        echo "\t\t\t<div class='container'>\n";
      }
      if ($i==0) echo "\t\t\t\t<div class='row'>\n";
      echo "\t\t\t\t\t<div class='col-md-4 munin_plugin'>\n";
      echo "\t\t\t\t\t\t<h2 style='color: ".$rand[1].";'>".$service['name']."</h2>\n";
      foreach ($config['time'] as $time) {
        echo "\t\t\t\t\t\t<img src='".$url."/".$service['id']."-".$time.".png' alt='' />\n";
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
  </body>
</html>