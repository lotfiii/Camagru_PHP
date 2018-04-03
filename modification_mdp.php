<?php

session_start();

require 'bdd.php';


if (isset($_SESSION['Id'])) 
{
	$req_info = $bdd->prepare("SELECT * FROM membre WHERE Id = ?");
	$req_info->execute(array($_SESSION['Id']));
	$info = $req_info->fetch();
	if (isset($_POST['ancien_mot_de_passe']))
		$ancien_mdp = sha1($_POST['ancien_mot_de_passe']);
	if (isset($_POST['new_mdp1']) AND isset($_POST['new_mdp2'])  AND !empty($_POST['new_mdp1']) AND !empty($_POST['new_mdp2']) AND $ancien_mdp == $info['motdepasse'])
	{
		if ($_POST['new_mdp1'] == $_POST['new_mdp2'])
		{
			$nouveau_mdp = sha1($_POST['new_mdp1']);
			if ($nouveau_mdp != $info['motdepasse']) 
			{
				$update_mdp = $bdd->prepare("UPDATE membre set motdepasse = ? WHERE Id = ?");
				$update_mdp->execute(array($nouveau_mdp, $_SESSION['Id']));
				header("Location: edition_profil.php?Id=".$_SESSION['Id']);
			}
			else
			{
				$erreur = "Veuillez enter un mot de passe diffrerent de l'ancien";
			}
		}
		else
		{
			$erreur = "Les mots de passe doivent etre identique";
		}
	}
	else
	{
		$erreur = "Entrez un nouveau mot de passe";
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
			<h2>Modification Mot de passe</h2>
		</header>
		<body>
			<div align="center" >
				<form method="POST" action="">
					<table>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr >
							<td align="right">
								<label>Mot de passe:</label>
								<input style="width: 210px; height: 32px;" type="password" name="ancien_mot_de_passe" placeholder="Tapez votre nouveau mot de passe" >
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr >
							<td align="right">
								<label>Nouveau mot de passe:</label>
								<input style="width: 210px; height: 32px;" type="password" name="new_mdp1" placeholder="Tapez votre nouveau mot de passe" > 
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
							<td align="right">
								<label>Confirmation mot de passe:</label>
								<input style="width: 210px; height: 32px;" type="password" name="new_mdp2" placeholder="Tapez votre nouveau mot de passe" > 
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
?>