<?php
	include_once 'config.php';

	$db = new Connection;

	$conn = $db->open();

	try {
		$query = "SELECT temp_value, humidity_value FROM tbl_temp ORDER BY id DESC LIMIT 1";
		$stmt = $conn->prepare($query);
		$stmt->execute();

		$values = $stmt->fetch();


	} 
	catch (PDOException $e) {
		echo "Query failed: " . $e->getMessage();
	}

// Close the connection
$db->close();
?>




<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
	<title>stranica</title>
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg bg-body-tertiary">
		  <div class="container-fluid">
			 
			    <img src="imgs/etsbi_logo.png" alt="etsbi_logo" style="width: 60px; height: auto">
			    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			      <span class="navbar-toggler-icon"></span>
			    </button>
			    <div class="collapse navbar-collapse" id="navbarSupportedContent">
			      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
			        <li class="nav-item">
			          <a class="nav-link active" aria-current="page" href="index.php" style="font-family: 'Open Sans'; font-size: 13px;" id="ease-out">Trenutno mjerenje</a>
			        </li>
			        <li class="nav-item">
			          <a class="nav-link" href="mjerenja.php" style="font-family: 'Open Sans'; font-size: 13px;" id="ease-out">Mjerenja</a>
			        </li>
			      </ul>
			    </div>
			</div>
		</nav>
	</header>

	<main>
		<div class="mjerilo">
			<div class="container">
				<div class="row">
				<p>Trenutna temperatura: <?= htmlspecialchars(string: $values['temp_value']); ?> °C</p>
					<!-- <p>Trenutna temperatura: </p> -->
				</div>

				<div class="row">
					<p>Trenutna vlaznost: <?= htmlspecialchars($values['humidity_value']); ?> °C</p>
					<!-- <p>Trenutna vlaznost: </p> -->
				</div>

				<div class="gauge_meter_vjetar">
					<div class="container">
						<!-- gauge meter -->
					</div>
				</div>

				<div class="gauge_meter_vlaznost">
					<div class="container">
						<!-- gauge meter -->
					</div>
				</div>
			</div>
		</div>
	</main>


	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>