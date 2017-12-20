<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>ZHTC - Home</title>
        <?php include 'includes/header.php';
              include 'includes/dbconnect.php';
              //include 'includes/sidebar.php';?>
              <div id="fb-root"></div>
              <script>(function(d, s, id) {
                  var js, fjs = d.getElementsByTagName(s)[0];
                  if (d.getElementById(id)) return;
                  js = d.createElement(s); js.id = id;
                  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11';
                  fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));
              </script>
              <script>
              $(document).ready(function(){
                $(".carousel-item").first().addClass("active");

              });
              </script>

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
                  <?php
                  $stmt = $pdo->prepare('SELECT * FROM slider');
                  $stmt->execute();
                  $data = $stmt->fetchall();
                  foreach ($data as $data) {
                      ?>
                  <div class="carousel-item" role="listbox">
                    <img class="d-block img-fluid" src="images/slider/<?php print($data['afbeelding']); ?>" alt="<?php print(strtolower($data['fototitel'])); ?>">
                    <div class="carousel-caption">
                    <h3><?php strtoupper(print($data["fototitel"])); ?></h3>
                      <p><?php print($data["tekst"]); ?></p>
                    </div>
                  </div>
                  <?php
                  } ?>
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
            </div>

            <div class="container"><br>
              <div class="fb-page" data-href="https://www.facebook.com/asvzhtc" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="false">
                <blockquote cite="https://www.facebook.com/asvzhtc" class="fb-xfbml-parse-ignore">
                  <a href="https://www.facebook.com/asvzhtc">ZHTC</a>
                </blockquote>
              </div>
              <!-- InstaWidget -->
<a href="https://instawidget.net/v/user/asvzhtc" id="link-5fff1ec5c31a9609de1275d00fbb28a1933c4eac00ad9216e8bb6a7b5d24b5b9">@asvzhtc</a>
<script src="https://instawidget.net/js/instawidget.js?u=5fff1ec5c31a9609de1275d00fbb28a1933c4eac00ad9216e8bb6a7b5d24b5b9&width=300px"></script>
            </div>


              <!-- <a href="https://zhtc.nl/lustrumshop/">Ga naar de Lustrumshop</a> -->

    <?php include 'includes/footer.php'; ?>
</html>
