<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>ZHTC - Home</title>
        <?php include 'includes/header.php';
              //include 'includes/sidebar.php';?>
              <!-- This script triggers the modal without a button -->
              <script type="text/javascript">
              	$(document).ready(function(){
              		$("#myModal").modal('show');
              	});
              </script>
              <script>(function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s); js.id = id;
                js.src = 'https://connect.facebook.net/nl_NL/sdk.js#xfbml=1&version=v2.11';
                fjs.parentNode.insertBefore(js, fjs);
              }(document, 'script', 'facebook-jssdk'));</script>


              <!-- Modal -->
              <?php // NOTE: een modal is een popup venster. Gr Kai?>
              <style media="screen">#myModal{top:38%;right:75%;outline: none;}</style>
              <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-sm">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Deze website maakt gebruik van cookies</h4>
                    </div>
                    <div class="modal-body">
                      <p>Deze website gebruikt cookies voor een verbeterde gebruikservaring. Door gebruik te maken van onze website of door op "Ik ga akkoord" te klikken ga je akkoord met al onze cookies die benoemd zijn in ons cookie beleid.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-success" data-dismiss="modal">Ik ga akkoord</button>
                      <a type="button" href="cookiebeleid.pdf" class="btn btn-info" role="button">Lees meer</a>
                    </div>
                  </div>

                </div>
              </div>

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
                    <img src="images/slider/Batavierenrace.jpg" alt="De Batavierenrace">
                    <div class="carousel-caption">
                      <h3>De Batavierenrace</h3>
                      <p>Niet alles wat we doen regelenen we zelf en niet alles wat we doen gebeurt in Zwolle. Elk jaar doet een deel van ZHTC mee aan de Batavierenrace, Het grootste studentenestafete-evenement van de wereld. We lopen van Nijmegen naar Enschede waar een groot feest op ons wacht. De a.s.v.ZHTC -mentaliteit bij de Batavierenrace is zuipen tot je omvalt, tien kilometer hardrennen alsof den duvel je op de hielen zit, om vervolgens direct na de finish een biertje te pakken en te gaan feesten totdat je er bij neervalt of langer!</p>
                    </div>
                  </div>

                  <div class="carousel-item">
                    <img class="d-block img-fluid" src="images/slider/Bierweek.jpg" alt="De Bierweek">
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
            </div> <?php // NOTE:  ?>

            <div class="container"><br>
              <!--TODO : Netjes neerzetten <div id="fb-root"></div>-->
              <div class="fb-page" data-href="https://www.facebook.com/asvzhtc/" data-tabs="timeline" data-small-header="false" data-adapt-container-width="true"
              data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/asvzhtc/" class="fb-xfbml-parse-ignore">
                <a href="https://www.facebook.com/asvzhtc/">ZHTC</a></blockquote></div>

            </div>

              <a href="https://zhtc.nl/lustrumshop/">Ga naar de Lustrumshop</a>


    <?php include 'includes/footer.php'; ?>
</html>
