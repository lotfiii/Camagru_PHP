<?php

session_start();

require 'bdd.php';


if (isset($_SESSION['Id'])) 
{
	$req_info = $bdd->prepare("SELECT * FROM membre WHERE Id = ?");
	$req_info->execute(array($_SESSION['Id']));
	$info = $req_info->fetch();
	if (isset($_POST['new_mail1']) AND isset($_POST['new_mail2'])  AND !empty($_POST['new_mail1']) AND !empty($_POST['new_mail2']) AND $_POST['new_mail1'] != $info['Mail'])
	{
		$new_mail1 = htmlspecialchars($_POST['new_mail1']);
		$new_mail2 = htmlspecialchars($_POST['new_mail2']);
		if ($new_mail1 == $new_mail2)
		{
			$req_mail = $bdd->prepare("SELECT * FROM membre WHERE Mail=?");
			$req_mail->execute(array($new_mail1));
			$mail_existe = $req_mail->rowCount();

			if ($mail_existe == 0) 
			{
				$update_mail = $bdd->prepare("UPDATE membre set Mail = ? WHERE Id = ?");
				$update_mail->execute(array($new_mail1, $_SESSION['Id']));
				header("Location: edition_profil.php?Id=".$_SESSION['Id']);
			}
			else
			{
				$erreur = "Cette adresse existe déja dans notre base de donnéé !";
			}
		}
		else
		{
			$erreur = "Les adresse email doivent etre identique";
		}
	}
	else
	{
		$erreur = "Veuillez enter une addresse email diffrerente de l'ancienne";
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
			<h2>Modofication E-mail</h2>
		</header>
		<body>
			<div align="center" >
				<form method="POST" action="">
					<table>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr >
							<td align="right">
								<label>Mail:</label>
								<input style="width: 210px; height: 32px;" type="email" name="ancien_mail" value="<?php echo $info['Mail']; ?>" >
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr >
							<td align="right">
								<label>Nouveau Mail:</label>
								<input style="width: 210px; height: 32px;" type="email" name="new_mail1" placeholder="Tapez votre nouvelle adresse email" > 
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
							<td align="right">
								<label>Confirmation Mail:</label>
								<input style="width: 210px; height: 32px;" type="email" name="new_mail2" placeholder="Tapez votre nouvelle adresse email" > 
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