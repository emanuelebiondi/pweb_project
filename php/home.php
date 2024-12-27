<?php

// Set the current page name
$page_name = basename($_SERVER['PHP_SELF'], '.php');
?>




<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/style.css">
	<title>Cohabitat - Home</title>
</head>

<body>
	<!-- Header + topbar inserted by snippet/header.php -->
	<?php include "snippet/header.php" ?>
	<main>
		<div class="header">
			<div class="left">
				<h1>Home</h1>
			</div>
		</div>

		<div class="top-data">
			<h3> Welcome in Cohabitat - Start using the app with side menu</h3>
		</div>

		<!-- Popup Create or Join in House (Hidden by default)-->
		<?php include_once 'popupForms/houseJoinForm.php' ?>

	</main>
	</div>

	<script src="../js/dashboard.js"></script>
	<script src="../js/houseChoiceDashboard.js"></script>
</body>



</html>