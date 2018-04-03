<?php

session_start();

require 'bdd.php';

if (isset($_GET['Id']) AND $_GET['Id'] > 0)
{
	$getid    = intval($_GET['Id']);
	$requser  = $bdd->prepare("SELECT * FROM membre Where Id = ?");
	$requser->execute(array($getid));
	$userinfo=$requser->fetch();
require 'header.php';
?>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="camagru.css">
		<title> CAMAGRU </title>
	</head>
	<!-- <div id="bloc_page"> -->
		<header align="center">
			<h2>Profil de <?php echo $userinfo['Pseudo'] ?> </h2>
		</header>
		<div align="center">
				<?php
				if (!empty($userinfo['avatar'])) 
				{
				?>
				<img src="avatar/<? echo $userinfo['avatar']; ?>" width="150" border="5px solid #181818" />
				<?php
				}
				?>
				<br /><br />

			</div>
		<body>
			<div align="center">
				<p> Votre Pseudo : <?php echo $userinfo['Pseudo']?> </p>
				<p> Votre Mail   : <?php echo $userinfo['Mail']?> </p>
				<p> Votre ID     : <?php echo $userinfo['Id']?> </p>

				<?php
				if (isset($_SESSION['Id']) AND $userinfo['Id'] == $_SESSION['Id'])
				{
					$gal = 'galerie.php?Id='.$_SESSION['Id'];
					?> 
					<a href="edition_profil.php"> <strong>Editer mon profil</strong></a><br />
					<a href="upload.php"><em> Upload une photo</em></a><br />
					<a href="cam.php"><em> Se prendre en photo</em></a><br />
					<a href="<?php echo $gal; ?>"> <strong>Galerie</strong></a>
					<?php
				} 
				?>
			</body>
		</div>
	<!-- </div> -->
</html>

<?php
require 'footer.php';
}
else
{
	header("Location: connexion.php");
}
?>