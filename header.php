<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="camagru.css">
		<title> CAMAGRU </title>
	</head>
<body>
	<header align="center">
			<?php if (isset($_SESSION['Id'])){
				$profil = 'profil.php?Id='.$_SESSION['Id'];
				?>
			<a href="<?php echo $profil; ?>"><h1>CAMAGRU ></h1></a>
			<a href="deconnexion.php"><em> Se deconnecter</em></a>
			<?php
			}
			else {?>
				<a href="accueil.php"><h1>CAMAGRU ></h1></a>
			<?php
		}
			?>
		</header>
	</body>
</html>