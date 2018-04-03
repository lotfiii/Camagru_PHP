<?php

session_start();

require 'bdd.php';

if(isset($_SESSION['Id']))
{
	$requser = $bdd->prepare("SELECT * FROM membre WHERE Id = ?");
	$requser->execute(array($_SESSION['Id']));
	$info = $requser->fetch();

	if (isset($_POST['new_pseudo']) AND !empty($_POST['new_pseudo']) AND $_POST['new_pseudo'] != $info['Pseudo']) 
	{
		$new_pseudo = htmlspecialchars($_POST['new_pseudo']);
		$req_pseudo = $bdd->prepare("SELECT * FROM membre WHERE Pseudo = ?");
		$req_pseudo->execute(array($new_pseudo));
		$pseudo_existe = $req_pseudo->rowCount();
		if ($pseudo_existe == 0) 
		{
			$pseudo_update = $bdd->prepare("UPDATE membre set Pseudo = ?  WHERE Id = ?");
			$pseudo_update->execute(array($new_pseudo, $_SESSION['Id']));
			header("Location: edition_profil.php?Id=".$_SESSION['Id']);
		}
		else
		{
			$erreur = "Ce pseudo existe déjà ! Veuillez en choisir un autre";
		}
	}
	else
	{
		$erreur = "Veuillez entrer un pseudo different de l'ancien !";
	}
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
			<h2>Modification Pseudo</h2>
		</header>
		<body>
			<div align="center" >
				<form method="POST" action="">
					<table>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr >
							<td align="right">
								<label>Pseudo:</label>
								<input style="width: 210px; height: 32px;" type="text" name="ancien_pseudo" value="<?php echo $info['Pseudo']; ?>" >
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr >
							<td align="right">
								<label>Nouveau Pseudo:</label>
								<input style="width: 210px; height: 32px;" type="text" name="new_pseudo" placeholder="Tapez votre nouveau pseudo" > 
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<td align="center">
							<input type="submit" name="ok" value="METTRE A JOUR ">
						</td>
					</tr>
					<tr><td></td></tr>
				</table>
			</form><br />
			<?php
				
				if (isset($erreur)) 
				{
					echo '<font color="red">' .$erreur. '</font>';
				}
				if(isset($message))
				{
					echo '<font color="red">' .$message. '</font>';
				}
				?>
				<p> Quittez sans mettre a jour ?<a href="profil.php"> cliquez ici </a></p> <br />
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
