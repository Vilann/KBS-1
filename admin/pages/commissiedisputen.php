<html lang="en">
      <?php include '../header.php';?>
        <main class="col-md-10 col-xs-11 pl-3 pt-3">
            <a class="zhtc-c" id="sidebar_toggler" href="#sidebar" data-toggle="collapse"><i class="icon ion-navicon-round"></i></a>
            <hr>
            <div class="page-header">
                <h1 id="pageLoc" class="commissiedisputen">ZHTC commissies en disputen overzicht<span class="lead">Welkom bij de ZHTC adminpanel</span></h1>
            </div>
            <br>
            <h2>Commissies</h2>
            <hr>
            <?php
            $stmt = $pdo->prepare("SELECT c.commissienaam, c.commissiezin, CONCAT(IFNULL(l1.voornaam,''),' ',IFNULL(l1.tussenvoegsel,''),' ',IFNULL(l1.achternaam,'')) AS voorzitter, COUNT(*) AS aantal_leden FROM commissielid cl
			      JOIN commissie c ON cl.commissieID = c.commissieID
            JOIN lid l1 ON c.commissievoorzitter = l1.lidID
            JOIN lid l2 ON cl.lidID = l2.lidID
            GROUP BY c.commissieID");
            $stmt->execute();
            $count = $stmt->rowCount();
            $resultsPer = 20;
            $pages = ceil($count/$resultsPer);
            if(isset($_GET['p']) && !empty($_GET['p'])){
              $pageNr = $_GET['p'];
            }else{
              $pageNr = 1;
            }
            if(isset($_GET['ord']) && !empty($_GET['ord'])){
              $order = $_GET['ord'];
            }else{
              $order = "commissienaam";
            }
            //check of hij op de laatste of op pagina 1 zit
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
            $page_status = setPagination($pages, $pageNr);
            $page_status_left = $page_status[0];
            $page_status_right = $page_status[1];
            $startNr = ($resultsPer*$pageNr)-$resultsPer;
            $stmt = $pdo->prepare("SELECT c.commissienaam, c.commissiezin, CONCAT(IFNULL(l1.voornaam,''),' ',IFNULL(l1.tussenvoegsel,''),' ',IFNULL(l1.achternaam,'')) AS voorzitter, COUNT(*) AS aantal_leden FROM commissielid cl
			      JOIN commissie c ON cl.commissieID = c.commissieID
            JOIN lid l1 ON c.commissievoorzitter = l1.lidID
            JOIN lid l2 ON cl.lidID = l2.lidID
            GROUP BY c.commissieID
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
                for($i = 1; $i <= $pages; $i++){
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
                  <th scope="col">Acties</th>
                  <th id="commissienaam" scope="col"><a href="?p=<?php print($pageNr)?>&ord=commissienaam">Commissienaam</a></th>
                  <th id="voorzitter" scope="col"><a href="?p=<?php print($pageNr)?>&ord=voorzitter">Voorzitter</a></th>
                  <th id="aantal_leden" scope="col"><a href="?p=<?php print($pageNr)?>&ord=aantal_leden">Aantal leden</a></th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($data as $row) {
                ?>
                <tr>
                  <td>
                    <button id="deleteUser" class="btn btn-xs" data-toggle="modal" data-target="#verwijderen" href="./assets/scripts/functions.php?CursistID=374&amp;as=delCursist&amp;BedrijfID=348"><i class="icon ion-trash-b"></i></button>
                  </td>
                  <td><?php print($row['commissienaam']);?></td>
                  <td><?php print($row['voorzitter']);?></td>
                  <td><?php print($row['aantal_leden']);?></td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
        </main>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="verwijderen" tabindex="-1" role="dialog" aria-labelledby="verwijderenlabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="verwijderenlabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>
