<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>ZHTC - Home</title>
        <?php include 'includes/header.php';
              include 'includes/dbconnect.php';
              //include 'includes/sidebar.php';?>

              <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = 'https://connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v2.11';
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));</script>

            <div class="container">
              <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                  <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                  <li data-target="#myCarousel" data-slide-to="1"></li>
                  <li data-target="#myCarousel" data-slide-to="2"></li>
                  <li data-target="#myCarousel" data-slide-to="3"></li>
                  <li data-target="#myCarousel" data-slide-to="4"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <div class="carousel-item active" role="listbox">
                    <?php
                    $stmt = $pdo->prepare('SELECT *
          					FROM slider');
                              $stmt->execute();
                              $data = $stmt->fetchAll();
                    ?>
                    <img src="images/slider/Batavierenrace.jpg" alt="De Batavierenrace">
                    <div class="carousel-caption">
                    <h3><?php print($data["fototitel"]); ?></h3>
                      <p><?php print($data["tekst"]);?></p>
                    </div>
                  </div>

                  <div class="carousel-item">
                    <img class="d-block img-fluid" src="images/slider/"<?php print($data["afbeelding"]); ?> alt="De Bierweek">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block img-fluid" src="images/slider/Highlandgames.jpg" alt="De Highlandgames">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block img-fluid" src="images/slider/Introweek.jpg" alt="De Introweek">
                  </div>
                  <div class="carousel-item">
                    <img class="d-block img-fluid" src="images/slider/Netwerkbijeenkomst.jpg" alt="De Netwerkbijeenkomst">
                  </div>

                </div>

                <!-- Left and right controls -->
                <!-- <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a> -->
              </div>
            </div> <?php // NOTE:?>

            <div class="container"><br>
              <!--TODO : Netjes neerzetten <div id="fb-root"></div>-->
              <div class="fb-page" data-href="https://www.facebook.com/asvzhtc/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true"
              data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/asvzhtc/" class="fb-xfbml-parse-ignore">
                <a href="https://www.facebook.com/asvzhtc/">ZHTC</a></blockquote></div>

            </div>

              <a href="https://zhtc.nl/lustrumshop/">Ga naar de Lustrumshop</a>


    <?php include 'includes/footer.php'; ?>
</html>
