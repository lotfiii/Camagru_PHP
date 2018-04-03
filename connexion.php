<?php

session_start();

require 'bdd.php';
require 'fonction.php';

if (isset($_POST['ok'])) 
{
	$pseudo_connexion = htmlspecialchars($_POST['pseudo_connexion']);
	$mdp_connexion    = sha1($_POST['mdp_connexion']);

	if (!empty($pseudo_connexion) AND !empty($mdp_connexion)) 
	{
		$req_user = $bdd->prepare("SELECT * FROM membre WHERE Pseudo = ? AND motdepasse = ?");
		$req_user->execute(array($pseudo_connexion, $mdp_connexion));
		$user_existe = $req_user->rowCount();
		$user_info = $req_user->fetch();
		if ($user_existe == 1 AND isset($user_info['confirmation_at']))
		{
			$_SESSION['Id'] = $user_info['Id'];
			$_SESSION['Pseudo'] = $user_info['Pseudo'];
			$_SESSION['Mail'] = $user_info['Mail'];
			header("Location: profil.php?Id=".$_SESSION['Id']);
			
		}
	}
	else
	{
		$erreur = "Tous les champs doivent être remplis !";
	}
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
			<h2>Espace Connexion</h2>
		</header>
		<body>
			<div align="center" >
				<form method="POST" action="">
					<table>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td>
								<input style="width: 210px; height: 32px;" type="text" name="pseudo_connexion" placeholder="Votre Pseudo"> 
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td>
								<input style="width: 210px; height: 32px;"type="password" name="mdp_connexion" placeholder="Mot De Passe">
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td align="center">
								<input type="submit" name="ok" value="SE CONNECTER">
							</td>
						</tr>
						<tr><td></td></tr>
						<tr>
							<td align="center">
								<a href="mot_de_passe_oublie.php"> Mot de passe oublié ?</a>
							</td>
						</tr>
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
				<p><span class="cadre">En vous connectant, Vous acceptez nos conditions d'utilisation et notre politique de bonne conduite.</span></p>
				<div class="not_yet">
				<p>Pas encore de compte ? <a href="accueil.php"> Inscrivez-Vous</a></p> <br />
				</div>
			</body>
		</div>
	<!-- </div> -->
</html>
<?php require 'footer.php'; ?>