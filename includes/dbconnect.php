<?php
// NOTE: deze functie haalt de commissie informatie op om dat vervolgens
// in een foreach te stoppen.
try {
	$db = "mysql:host=localhost;dbname=zhtc_banaan;port=3307";
	$user = "root";
	$pass = "usbw";
	$pdo = new PDO($db, $user, $pass);
}
catch (PDOException $e) {
echo $e->getTraceAsString();
}
function GetCommissieData(){
		try {
			$db = "mysql:host=localhost;dbname=zhtc_banaan;port=3307";
			$user = "root";
			$pass = "usbw";
			$pdo = new PDO($db, $user, $pass);
		}
		catch (PDOException $e) {
		echo $e->getTraceAsString();
		}
		$stmt = $pdo->prepare('SELECT commissienaam as comm_naam, commissiezin as comm_zin, commissietekst as comm_tekst
		FROM commissie');
		$stmt->execute();
		$data = $stmt->fetchAll();
		foreach($data as $row) {
		  /*$naam =*/	print $row["comm_naam"];
			/*$kernzin=*/ 	print $row["comm_zin"];
			/*$beschrijving =*/ print $row["comm_tekst"];
		};
	}

function GetdispuutData($pdo)
{
	try {
		$db = "mysql:host=localhost;dbname=zhtc_banaan;port=3307";
		$user = "root";
		$pass = "usbw";
		$pdo = new PDO($db, $user, $pass);
	}
	catch (PDOException $e) {
	echo $e->getTraceAsString();
	}
	$stmt = $pdo->prepare('SELECT *
	FROM dispuut');
	$stmt->execute();
	$data = $stmt->fetchAll();
	foreach($data as $row) {};
}


function GetFormatData($pdo)
{
	try {
		$db = "mysql:host=localhost;dbname=zhtc_banaan;port=3307";
		$user = "root";
		$pass = "usbw";
		$pdo = new PDO($db, $user, $pass);
	}
	catch (PDOException $e) {
	echo $e->getTraceAsString();
	}
	$stmt = $pdo->prepare("SELECT DATE_FORMAT(datumvan, '%d %M %Y') as datumvanaf, DATE_FORMAT(datumvan, '%k:%i') as tijdvanaf, DATE_FORMAT(datumtot, '%d %M %Y') as datumtot, DATE_FORMAT(datumtot, '%k:%i') as tijdtot, activiteitnaam, activiteitlocatie
	FROM activiteit
	WHERE datumvan > CURDATE()
	ORDER by datumvan ASC");
	$stmt->execute();
	$data = $stmt->fetchAll();
	foreach($data as $row) {
		$now = time(); // or your date as well
		$your_date = strtotime($row['datumvanaf']);
		$datediff = $your_date - $now;

		$tijdTotdatum = floor($datediff / (60 * 60 * 24));

		?>over <?php print($tijdTotdatum);?> dagen <?php
	}
};

// class ClassName
// {
// 	var $pdo;
// 	function __construct($new_pdo)
// 	{
// 		try {
// 			$db = "mysql:host=localhost;dbname=zhtc_banaan;port=3307";
// 			$user = "root";
// 			$pass = "usbw";
// 			$pdo = new PDO($db, $user, $pass);
// 		}
// 		catch (PDOException $e) {
// 		echo $e->getTraceAsString();
// 		}
// 	}
// 	public function ReturnPdo()
// 	{
// 		return
// 		$this->$pdo;
// 	}
// }
