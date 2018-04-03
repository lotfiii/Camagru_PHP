<?php
session_start();

require 'bdd.php';


if (isset($_SESSION['Id'])) 
{
	if(isset($_FILES['modif_avatar']) AND !empty($_FILES['modif_avatar']['name']))
	{
		$taillMax = 2097152;
		$extentionsValides = array('jpg','jpeg', 'png', 'gif');
		if ($_FILES['modif_avatar']['size'] <= $taillMax)
		{
			$extentionUplode = strtolower(substr(strrchr($_FILES['modif_avatar']['name'], '.'), 1));
			if (in_array($extentionUplode, $extentionsValides)) 
			{
				$chemin = "avatar/" .$_SESSION['Id']. "." .$extentionUplode;
				$resultat = move_uploaded_file($_FILES['modif_avatar']['tmp_name'], $chemin);
				if ($resultat) 
				{
					$update_avatar = $bdd->prepare("UPDATE membre SET avatar = :avatar WHERE Id = :Id");
					$update_avatar->execute(array('avatar' => $_SESSION['Id']. "." .$extentionUplode, 'Id' => $_SESSION['Id']));
					header("Location: edition_profil.php?Id=".$_SESSION['Id']);
				}
				else
				{
					$erreur = "Erreur durant l'importation de votre photo de profil";
				}
			}
			else
			{
				$erreur = "Votre photo de profil doit etre au format jpg, jpeg, gif, ou png";
			}
		}
		else
			{
				$erreur = "Votre photo de profil ne doit pas depasser 2Mo";
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
			<h2>Modification Avatar (photo de profil)</h2>
		</header>
		<body>
			<div align="center" >
				<form method="POST" action="" enctype="multipart/form-data">
					<table>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td align="right">
								<label>Avatar</label>
								<input style="width: 210px; height: 32px;"type="file" name="modif_avatar" >
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
