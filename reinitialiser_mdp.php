<?php
require 'bdd.php';
if (isset($_GET['Id']) AND isset($_GET['token'])){
		$user_id = $_GET['Id'];
	$token = $_GET['token'];
	if (isset($_POST['new_mdp1']) AND isset($_POST['new_mdp2'])  AND !empty($_POST['new_mdp1']) AND !empty($_POST['new_mdp2']))
	{
		$req_info = $bdd->prepare("SELECT * FROM membre WHERE Id = ?");
	$req_info->execute(array($user_id));
	$info = $req_info->fetch();
		if ($_POST['new_mdp1'] == $_POST['new_mdp2'])
		{
			$nouveau_mdp = sha1($_POST['new_mdp1']);
				$update_mdp = $bdd->prepare("UPDATE membre set motdepasse = ? WHERE Id = ?");
				$update_mdp->execute(array($nouveau_mdp, $user_id));
				header("Location: connexion.php");
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

$req = $bdd->prepare('SELECT * FROM membre WHERE Id = ?');
$req->execute([$user_id]);
$user = $req->fetch();
if ($user && $user['confirmation_token'] == $token){
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
else{
	$lien = "votre lien n'est pas correct";
	header('Location: connexion.php');
}
}
else{
	$lien = "votre lien n'est pas correct";
	header('Location: connexion.php');
}
?>