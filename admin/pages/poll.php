      <?php
      session_start();
      include '../../includes/dbconnect.php';
      include '../alert.php';
      //Hier staat de functie om nieuwe polls toe te voegen.
      //Kijk of er niks leeg is gepost
        if(isset($_POST['add']) && !(empty($_POST['add']))){
          //sla de datum van vandaag op in $date
          $date = date("Y-m-d");
          //Prepare en execute de sql query om een nieuwe poll toe te voegen
          $stmt = $pdo->prepare("INSERT INTO poll(vraag, datum, einddatum)
            VALUES(?, ?,?)");
          $stmt->execute(array($_POST['vraag'], $date,$_POST['enddate']));
          //Selecteer het id van de poll die zojuist is toegevoegd en sla die op als $maxId
          $stmt = $pdo->prepare("SELECT MAX(pollID) AS max_id FROM poll");
          $stmt -> execute();
          $maxId = $stmt -> fetch(PDO::FETCH_ASSOC);
          $maxId = $maxId['max_id'];
          //Een loop op elke keuzemogelijkheid in de tabel pollkeuzemogelijkheid te inserten
          for($i = 1; $i <= $_POST['keuzeaantal']; $i++){
            $stmt = $pdo->prepare("INSERT INTO pollkeuzemogelijkheid(pollID,pollkeuzemogelijkheid)
              VALUES(?, ?)");
            $stmt->execute(array($maxId, $_POST['keuze'.$i]));
          }
          //Unset de post waarde add zodat hij niet perongeluk nog een keer de zelfde query uitvoerd
          $_SESSION['error'] = "Er is succesvol een nieuwe poll toegevoegd. Leden kunnen deze nu invullen op de homepagina";
          $_SESSION['errorType'] = "success";
          $_SESSION['errorAdd'] = "succes!";
          unset($_POST['add']);
          header('Location: poll');
        }else{
          //Niks
        }
        if(isset($_SESSION['error'])){
          print(createError($_SESSION['error'],$_SESSION['errorType'],$_SESSION['errorAdd']));
          unset($_SESSION['error']);
        }
       ?>
      <html lang="en">
      <?php
      include '../header.php';?>
      <script src="http://code.highcharts.com/highcharts.js"></script>
      <script src="http://code.highcharts.com/modules/exporting.js"></script>
        <main class="col-md-10 col-xs-11 pl-3 pt-3">
            <a class="zhtc-c" id="sidebar_toggler" href="#sidebar" data-toggle="collapse"><i class="icon ion-navicon-round"></i></a>
            <hr>
            <div class="page-header">
                <h1 id="pageLoc" class="poll">ZHTC Poll<span class="lead">Welkom bij het ZHTC adminpanel</span></h1>
            </div>
            <div class="row">
              <div class="col-md-11">
                <p class="text-muted mb-1">
                  Hieronder vind je de resultaten van de afgelopen 3 polls
                </p>
                <!-- Knop die de modal inlaadt voor het toevoegen van een nieuwe poll -->
                  <button type="button" class="btn btn-outline-primary zhtc-button" data-toggle="modal" data-target="#addPoll">Nieuwe poll toevoegen</button>
              </div>
            </div>
            <br>
            <div class="row justify-content-left pl-3">
              <?php
              //Eerste 3 resultaten ophalen en de eerste met col-5 + border
              $stmt = $pdo->prepare("SELECT p.pollID, p.vraag, COUNT(lidID) AS aantal_resultaten FROM poll p
              LEFT JOIN pollresultaat pr ON p.pollID = pr.pollID
              GROUP BY p.pollID
              ORDER BY p.pollID DESC
              LIMIT 3");
              $stmt->execute();
              $data = $stmt->fetchAll();
              //Controleer of het de eerste resultaat uit de query is
              $first = true;
              foreach($data as $row) {
                if($first == true){
                  //Zo ja verander de class naar col-4
                  $class = "col-md-4 border border-primary rounded zhtc-brd-2";
                  $first = false;
                }else{
                  //zo nee verander de class naar col-3
                  $class = "col-md-3 offset-md-1";
                }
              ?>
                <div class="<?php print($class); ?>">
                  <div id=<?php print("pollResultaten".$row['pollID']);?>></div>
                  <div class="row">
                    <div class="col-6">
                      <p class="zhtc-c"><?php print($row['aantal_resultaten']." Resultaten");?></p>
                    </div>
                    <div class="col-6">
                      <button type="button" class="btn btn-outline-primary mb-3 zhtc-button float-right" data-toggle="modal" data-target='<?php print("#pollResultaten".$row['pollID']."modal"); ?>'>Meer info</button>
                    </div>
                  </div>
                  <script type="text/javascript">
                    $(function () {
                      //Maak een kleuren palet aan van 8 verschillende blauw tinten
                      Highcharts.setOptions({
                       colors: ['#b3d6ff', '#3392ff', '#005fcc', '#004799', '#003878', '#003066', '#001833', '#000c1a']
                      });
                      //De chart voor de pollResultaten inladen en definen
                      Highcharts.chart(<?php print("pollResultaten".$row['pollID']);?>, {
                        chart: {
                            plotBackgroundColor: null,
                            plotBorderWidth: null,
                            plotShadow: false,
                            type: 'pie'
                        },
                        title: {
                            text: '<?php print($row['vraag']);?>'
                        },
                        credits: {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: false,
                                }
                            }
                        },
                        exporting: { enabled: false },
                        series: [{
                            name: 'Leden',
                            colorByPoint: true,
                            data: [
                            <?php
                            //Alle data inladen waar de chart uit bestaat
                            $stmt2 = $pdo->prepare("SELECT pr.pollID,pr.pollkeuze, COUNT(pr.pollkeuze) AS res_perlid FROM pollresultaat pr
                            WHERE pr.pollID = ?
                            GROUP BY pr.pollkeuze");
                            $stmt2->execute(array($row['pollID']));
                            $data2 = $stmt2->fetchAll();
                            foreach($data2 as $row2) {
                             ?>
                            {
                                name: '<?php print($row2['pollkeuze']); ?>',
                                y: <?php print($row2['res_perlid']); ?>
                            },
                            <?php } ?>
                          ]
                        }]
                    });
                    //Chart die in de modal geladen wordt
                    Highcharts.chart(<?php print("modalresult".$row['pollID']);?>, {
                      chart: {
                          plotBackgroundColor: null,
                          plotBorderWidth: null,
                          plotShadow: false,
                          type: 'pie'
                      },
                      title: {
                          text: '<?php print($row['vraag']);?>'
                      },
                      credits: {
                          enabled: false
                      },
                      tooltip: {
                          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b><br/>' + 'Aantal: <b>{point.y}</b><br/>'
                      },
                      plotOptions: {
                          pie: {
                              allowPointSelect: true,
                              cursor: 'pointer',
                              dataLabels: {
                                  enabled: true,
                                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                  style: {
                                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                  }
                              },
                              showInLegend: true
                          }
                      },
                      exporting: { enabled: false },
                      series: [{
                          name: 'Leden',
                          colorByPoint: true,
                          data: [
                          <?php
                          //Alle data inladen waar de chart uit bestaat
                          $stmt2 = $pdo->prepare("SELECT pr.pollID,pr.pollkeuze, COUNT(pr.pollkeuze) AS res_perlid FROM pollresultaat pr
                          WHERE pr.pollID = ?
                          GROUP BY pr.pollkeuze");
                          $stmt2->execute(array($row['pollID']));
                          $data2 = $stmt2->fetchAll();
                          foreach($data2 as $row2) {
                           ?>
                          {
                              name: '<?php print($row2['pollkeuze']); ?>',
                              y: <?php print($row2['res_perlid']); ?>
                          },
                          <?php } ?>
                        ]
                      }]
                  });
                  });
                  </script>
                  <!-- Modal om overige poll gegevens in te laden -->
                  <div class="modal fade" id="<?php print("pollResultaten".$row['pollID']."modal"); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"><?php print($row['vraag']);?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div id=<?php print("modalresult".$row['pollID']);?>></div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php
              }
              ?>
            </div>
            <!-- EINDE VAN EERSTE 3 pollResultaten ### -->
            <!-- ################################################ -->
            <!-- Begin van de tabel met overige pollresultaten ### -->
            <hr>
            <?php
            //Query om het aantal resultaten op te halen
            $stmt = $pdo->prepare("SELECT p.pollID, p.vraag, COUNT(lidID) AS aantal_resultaten FROM poll p
            LEFT JOIN pollresultaat pr ON p.pollID = pr.pollID
            GROUP BY p.pollID");
            $stmt->execute();
            $count = $stmt->rowCount();
            //Aantal resultaten per pagina en het aantal $pages daaronder
            $resultsPer = 20;
            $pages = ceil($count/$resultsPer);
            //Check of er een andere pagina dan 1 wordt opgevraagd zo nee dan wordt pagina nummer 1
            if(isset($_GET['p']) && !empty($_GET['p'])){
              $pageNr = $_GET['p'];
            }else{
              $pageNr = 1;
            }
            //Check of er een voorkeurs order is aangegeven zo nee dan een standaard order
            if(isset($_GET['ord']) && !empty($_GET['ord'])){
              $order = $_GET['ord'];
            }else{
              $order = "p.pollID";
            }
            //check of hij op de laatste of op pagina 1 zit
            //Bepaal of een van de 2 page knoppen disabled moet worden
            function setPagination($pages, $pageNr){
              if($pages == 1 && $pages == $pageNr){
                return(array("disabled","disabled"));
              }
              if($pageNr == $pages){
                return(array("","disabled"));
              }elseif($pageNr == 1){
                return(array("disabled",""));
              }else{
                return(array("",""));
              }
            }
            //voer functie uit en sla het resultaat op in $page_status (resultaat is een array)
            $page_status = setPagination($pages, $pageNr);
            //Zet de page-status(left/right)
            $page_status_left = $page_status[0];
            $page_status_right = $page_status[1];
            //Bereken startnr (bij welke row hij begint met zoeken in de database)
            //voorbeeld pagina 3: (20*3)=60-20 = 40
            //voorbeeld pagina 1: (20*1)=20-20 = 0
            $startNr = ($resultsPer*$pageNr)-$resultsPer;
            //voer de query uit de tabel gegevens ophaald
            $stmt = $pdo->prepare("SELECT datum, p.pollID, p.vraag, COUNT(lidID) AS aantal_resultaten FROM poll p
            LEFT JOIN pollresultaat pr ON p.pollID = pr.pollID
            GROUP BY p.pollID
            ORDER by $order ASC
            LIMIT $startNr, $resultsPer");
            $stmt->execute();
            $data = $stmt->fetchAll();
             ?>
            <nav aria-label="Page navigation example">
              <ul class="pagination">
                <li class="page-item <?php print($page_status_left)?>">
                  <a class="page-link icon-fix" href="?p=<?php print($pageNr-1); ?>" aria-label="Previous">
                    <span class="icon ion-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                </li>
                <?php
                //Laad de pagination in
                for($i = 1; $i <= $pages; $i++){
                  //Als het de pagina is waar je momenteel op zit wordt de list-item gekleurd
                  if($i == $pageNr){
                    print("<li class='page-item active'><a class='page-link zhtc-bg zhtc-brd' href='?p=$i'> $i </a></li>");
                  }else{
                    print("<li class='page-item'><a class='page-link' href='?p=$i'> $i </a></li>");
                  }
                }
                ?>
                <li class="page-item <?php print($page_status_right)?>">
                  <a class="page-link icon-fix" href="?p=<?php print($pageNr+1); ?>" aria-label="Next">
                    <span class="icon ion-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
              </ul>
            </nav>
            <table class="table table-hover">
              <thead class="thead-zhtc">
                <tr id="orderBy" class="<?php print($order);?>">
                  <th id="vraag" scope="col"><a href="?p=<?php print($pageNr)?>&ord=vraag">PollVraag</a></th>
                  <th id="datum" scope="col"><a href="?p=<?php print($pageNr)?>&ord=datum">datum</a></th>
                  <th id="aantal_resultaten" scope="col"><a href="?p=<?php print($pageNr)?>&ord=aantal_resultaten">Aantal resultaten</a></th>
                  <th id="Resultaten" scope="col"><a href="#">Resultaten</a></th>
                </tr>
              </thead>
              <tbody>
                <?php
                //laat de tabel gegevens zien
                foreach($data as $row) {
                ?>
                <tr>
                  <td><?php print($row['vraag']);?></td>
                  <td><?php print($row['datum']);?></td>
                  <td><?php print($row['aantal_resultaten']);?></td>
                  <td>
                    <button type="button" class="btn btn-outline-primary zhtc-button" data-toggle="modal" data-target='<?php print("#test_pollResultaten".$row['pollID']."modal"); ?>'>Meer info</button>
                  </td>
                <script type="text/javascript">
                  $(function () {
                    Highcharts.setOptions({
                     colors: ['#b3d6ff', '#3392ff', '#005fcc', '#004799', '#003878', '#003066', '#001833', '#000c1a']
                    });
                    Highcharts.chart(<?php print("test_modalresult".$row['pollID']);?>, {
                      chart: {
                          plotBackgroundColor: null,
                          plotBorderWidth: null,
                          plotShadow: false,
                          type: 'pie'
                      },
                      title: {
                          text: '<?php print($row['vraag']);?>'
                      },
                      credits: {
                          enabled: false
                      },
                      tooltip: {
                          pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                      },
                      plotOptions: {
                          pie: {
                              allowPointSelect: true,
                              cursor: 'pointer',
                              dataLabels: {
                                  enabled: true,
                                  format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                  style: {
                                      color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                  }
                              },
                              showInLegend: true
                          }
                      },
                      exporting: { enabled: false },
                      series: [{
                          name: 'Leden',
                          colorByPoint: true,
                          data: [
                          <?php
                          $stmt2 = $pdo->prepare("SELECT pr.pollID,pr.pollkeuze, COUNT(pr.pollkeuze) AS res_perlid FROM pollresultaat pr
                          WHERE pr.pollID = ?
                          GROUP BY pr.pollkeuze");
                          $stmt2->execute(array($row['pollID']));
                          $data2 = $stmt2->fetchAll();
                          foreach($data2 as $row2) {
                           ?>
                          {
                              name: '<?php print($row2['pollkeuze']); ?>',
                              y: <?php print($row2['res_perlid']); ?>
                          },
                          <?php } ?>
                        ]
                      }]
                  });
                });
                </script>
                <!-- Modal om overige poll gegevens in te laden -->
                <div class="modal fade" id="<?php print("test_pollResultaten".$row['pollID']."modal"); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><?php print($row['vraag']);?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <div id=<?php print("test_modalresult".$row['pollID']);?>></div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                      </div>
                    </div>
                  </div>
                </div>
                                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
        </main>
        <!-- Modal om overige poll gegevens in te laden -->
        <div class="modal fade bd-example-modal-lg" id="addPoll" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Poll toevoegen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="getErrormess" action="poll" method="post">
                      <div class="form-group row">
                          <label for="vraag" class="col-sm-3 col-form-label">Vraag:</label>
                          <div class="col-sm-9 px-0 pr-5">
                            <input  id="vraag" type="text" class="form-control" name="vraag" placeholder="Moet er gratis koffie verstrekt worden?" required>
                          </div>
                      </div>
                      <div class="form-group row">
                          <label for="vraag" class="col-sm-3 col-form-label">Einddatum:</label>
                          <div class="col-sm-9 px-0 pr-5">
                            <input  id="datum" type="date" class="form-control" name="enddate" min=<?php print('"' . date('Y-m-d', strtotime("+2 day")) . '"'); ?> required>
                          </div>
                      </div>
                      <div class="imput-group row">
                          <label for="keuze" class="col-sm-3 col-form-label">Aantal keuzen:</label>
                          <div class="col-sm-9 px-0 pr-5">
                            <div class="input-group mb-2 mb-sm-0">
                              <input  id="keuze" type="number" max="8" min="2" class="form-control" name="keuzeaantal" value="" required>
                              <div class="input-group-addon">Maximaal 8</div>
                            </div>
                            <div id="feedkeuze" class="invalid-feedback" hidden>
                            </div>
                          </div>
                      </div>
                      <hr>
                      <div id="jq_target">
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-9 offset-sm-3 px-0">
                          <input class="btn btn-outline-primary" type="submit" name="add" value="Toevoegen">
                        </div>
                      </div>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Sluiten</button>
              </div>
            </div>
          </div>
        </div>
      </body>
</html>
