	<footer class="card-footer text-muted">
	<h4>CONTACT INFO
</h1>
<h6>
ADDRESS
</h6>
<p>
Postbus 1475, 8001 BL, Zwolle
</p>
<h6>
EMAIL
</h6>
<p>secretariaat@zhtc.nl</p>

<div class="col-md-12 col-sm ">
<!-- de InstaWidget -->
<a href="https://instawidget.net/v/user/asvzhtc" id="link-ffaf605d58f99b656cea68b504e6488d7cab0182b851d3585701c67d8b69a337">@asvzhtc</a>
<script src="https://instawidget.net/js/instawidget.js?u=ffaf605d58f99b656cea68b504e6488d7cab0182b851d3585701c67d8b69a337&width=300px"></script>
</div>
<div>
<h4>Sponsoren</h4>
<?php
$stmt = $pdo->prepare("SELECT * FROM sponsor");
$sponsor = $stmt->fetch(PDO::FETCH_ASSOC);
if ($sponsor->rowCount()) {
    foreach ($variable as $key => $value) {
        ?>
	<img src=<?php print $sponsor["sponsorplaatje"]; ?>>
	<?php
    }
}
?>

</div>
</footer>
</body>
</html>
