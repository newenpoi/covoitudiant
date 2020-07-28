<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<title>Covoitudiant</title>
		
		<!-- Métas -->
		<meta name="description" content="Et ça démarre !">
		<meta name="keywords" content="covoiturage, etudiant, energie">
                
		<!-- Icône -->
		<link rel="icon" type="image/png" href="<?= IMG_PATH ?>favicon.png"/>
		
		<!-- CSS -->
		<link rel="stylesheet" href="<?= CSS_PATH ?>bootstrap.min.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?= CSS_PATH ?>default.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?= CSS_PATH ?>leaflet.css" type="text/css" media="all"/>
		<link rel="stylesheet" href="<?= CSS_PATH ?>leaflet-routing-machine.css" type="text/css" media="all"/>
		
		<!-- Cool Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Athiti|Nothing+You+Could+Do|VT323&display=swap" rel="stylesheet">
	</head>
	<body>
		<div class="wrapper">
			<?php
				include_once (isset($_SESSION['id']) ? 'header/online.php' : 'header/offline.php');
				echo ($this->content);
			?>
		</div>
		<footer class="grid">
			<p>
				<span>17 Partages</span>
				<br/>
				<a href="#" title="Mentions Légales">Mentions</a>
			</p>
			<div class="d-flex">
				<a href="#" title="Facebook" class="icon icon-fb mr-2"></a>
				<a href="#" title="Twitter" class="icon icon-tw mr-2"></a>
				<a href="#" title="LinkedIn" class="icon icon-li"></a>
			</div>
		</footer>
	</body>
	<script type="text/javascript" src="<?= JS_PATH ?>jquery.min.js"></script>
	<script type="text/javascript" src="<?= JS_PATH ?>bootstrap.min.js"></script>
	<script type="text/javascript" src="<?= JS_PATH ?>general/default.js"></script>
	<script type="text/javascript" src="<?= JS_PATH ?>general/profile.js"></script>
    <script type="text/javascript" src="<?= JS_PATH ?>general/panel.js"></script>
    <script type="text/javascript" src="<?= JS_PATH ?>general/chingchong.js"></script>
	<script type="text/javascript" src="<?= JS_PATH ?>general/cartes.js"></script>
	<script type="text/javascript" src="<?= JS_PATH ?>leaflet/leaflet.js"></script>
	<script type="text/javascript" src="<?= JS_PATH ?>routing/leaflet-routing-machine.js"></script>
</html>