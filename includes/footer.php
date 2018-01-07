	<footer class="card-footer text-muted container-fluid">
<div class="row">
	<div class="col-4">

	<h4>CONTACT INFO
</h1>
<h6>
ADRES
</h6>
<p>
Postbus 1475, 8001 BL, Zwolle
</p>
<h6>
EMAIL
</h6>
<p>secretariaat@zhtc.nl</p>
<h6>
TELEFOON
</h6>
<p>06 373 424 59</p>
</div>
<div class="col-8">
<h4>SPONSOREN</h4>
<p> Wilt u ZHTC ook gaan sponsoren? Klik <a href='contact'>hier </a> om contact met ons op te nemen. <p>
<?php

include("includes/dbconnect.php");
$stmt = $pdo->prepare("SELECT * FROM sponsor LIMIT 4");
$stmt->execute();
$sponsoren = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($stmt->rowCount() > 0) {
    foreach ($sponsoren as $sponsor) {
        print("<img style='margin-right: 1em' src='" . $sponsor['sponsorplaatje'] . "'>");
    }
} else {
    die($sponsor);
}
?>
</div>
</div>
</footer>
</body>
</html>
