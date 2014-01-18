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
    <script>
      jQuery(document).ready(function() {
        jQuery("img.lazy").lazy();
      });
    </script>
  </head>
  <body id="body">
    <nav class='navbar navbar-default navbar-fixed-top scroll-header' role='navigation'>
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
              <li><a href='#server0' class='menu-server' data-speed='300' data-easing='easeInOutCubic' data-url='false'>All</a></li>
              <?php $m1 = 1; foreach ($config['url'] as $url) { ?>
              <li><a href='#server<?php echo $m1; ?>' class='menu-server' data-speed='300' data-easing='easeInOutCubic' data-url='false'><?php echo $url['name']; ?></a></li>
              <?php $m1++; } ?>
            </ul>
          </li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
              Categories <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <?php $m21 = 1; foreach ($config['url'] as $url) { $m22 = 0; foreach ($config['group'] as $group) { ?>
              <li><a href='<?php echo '#server'.$m21.'-category'.$m22; ?>' class='scroll menu-category' data-speed='300' data-easing='easeInOutCubic' data-url='false'><?php echo $group; ?></a></li>
              <?php $m22++; } $m21++; } ?>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a href='#body' class='scroll' data-speed='300' data-easing='easeInOutCubic'><span class="glyphicon glyphicon-arrow-up"></span></a></li>
        </ul>
      </div>
    </nav>
    <article class='server' id='server0'>
      <?php unset($style); $l1 = 0; foreach ($config['service'] as $service) { if ( $config['service'][$l1]['group'] !== $config['service'][$l1-1]['group'] ) { ?>
      <section id='server0-category<?php echo $service['group']; ?>' class='category category<?php echo $service['group']; ?>'>
        <div class='container'>
          <h1><?php echo $config['group'][$service['group']]; ?></h1>
        <?php } $l2 = 1; foreach ($config['url'] as $url) { ?>
          <div class='row'>
            <h2><?php echo $url['name']."s ".$service['name']; ?></h2>
            <?php foreach ($config['time'] as $time) { ?>
            <a href='<?php echo $url['url'].$service['id'].'-'.$time.'.png'; ?>' class='graph_wrapper col-md-4' data-lightbox='<?php echo $service['id']; ?>' title='<?php echo $service['name']; ?> last <?php echo $time; ?>'><img class='lazy' src='' data-src='<?php echo $url['url'].$service['id'].'-'.$time.'.png'; ?>' alt='<?php echo $service['name'].' last '.$time; ?>' /></a>
            <?php } ?>
          </div>
      <?php $l2++; } if ( $config['service'][$l1]['group'] !== $config['service'][$l1+1]['group'] ) { ?>
          <hr />
        </div>
      </section>
      <?php } $l1++; } ?>
    </article>
    <?php $k1 = 1; foreach ($config['url'] as $url) { ?>
    <article class='server' id='server<?php echo $k1; ?>'>
      <h1><?php echo $url['name']; ?></h1>
      <?php unset($style); $k2 = 0; foreach ($config['service'] as $service) { if ( $config['service'][$k2]['group'] !== $config['service'][$k2-1]['group'] ) { ?>
      <section id='server<?php echo $k1; ?>-category<?php echo $service['group']; ?>' class='category category<?php echo $service['group']; ?>'>
        <div class='container'>
          <h2><?php echo $config['group'][$service['group']]; ?></h2>
      <?php } ?>
          <div class='row'>
            <h3><?php echo $service['name']; ?></h3>
            <?php foreach ($config['time'] as $time) { ?>
            <a href='<?php echo $url['url'].$service['id'].'-'.$time.'.png'; ?>' class='graph_wrapper col-md-4' data-lightbox='<?php echo $service['id']; ?>' title='<?php echo $service['name']; ?> last <?php echo $time; ?>'><img class='lazy' src='' data-src='<?php echo $url['url'].$service['id'].'-'.$time.'.png'; ?>' alt='<?php echo $service['name'].' last '.$time; ?>' /></a>
            <?php } ?>
          </div>
      <?php if ( $config['service'][$k2]['group'] !== $config['service'][$k2+1]['group'] ) { ?>
          <hr />
        </div>
      </section>
      <?php } $k2++; } ?>
    </article>
    <?php $k1++; } ?>
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