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
        <div class="row">
          <div class="col-md-4 munin_plugin">
            <h2>Sample</h2>
            <img src="http://hom.pdostal.cz/munin/hom/hom/apache_accesses-day.png" alt="" />
            <img src="http://hom.pdostal.cz/munin/hom/hom/apache_accesses-week.png" alt="" />
            <img src="http://hom.pdostal.cz/munin/hom/hom/apache_accesses-month.png" alt="" />
            <img src="http://hom.pdostal.cz/munin/hom/hom/apache_accesses-year.png" alt="" />
          </div>
          <div class="col-md-4 munin_plugin">
            <h2>Sample</h2>
            <img src="http://hom.pdostal.cz/munin/hom/hom/apache_accesses-day.png" alt="" />
            <img src="http://hom.pdostal.cz/munin/hom/hom/apache_accesses-week.png" alt="" />
            <img src="http://hom.pdostal.cz/munin/hom/hom/apache_accesses-month.png" alt="" />
            <img src="http://hom.pdostal.cz/munin/hom/hom/apache_accesses-year.png" alt="" />
          </div>
          <div class="col-md-4 munin_plugin">
            <h2>Sample</h2>
            <img src="http://hom.pdostal.cz/munin/hom/hom/apache_accesses-day.png" alt="" />
            <img src="http://hom.pdostal.cz/munin/hom/hom/apache_accesses-week.png" alt="" />
            <img src="http://hom.pdostal.cz/munin/hom/hom/apache_accesses-month.png" alt="" />
            <img src="http://hom.pdostal.cz/munin/hom/hom/apache_accesses-year.png" alt="" />
          </div>
          <hr />
        </div>
      </article>
    </section>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>