<?php

session_start();

require 'bdd.php';

if (isset($_SESSION['Id'])) 
{
	$req_info = $bdd->prepare("SELECT * FROM membre WHERE Id = ?");
	$req_info->execute(array($_SESSION['Id']));
	$info = $req_info->fetch();

if (isset($_POST['modif_pseudo'])) 
{
	header("Location: modification_pseudo.php?Id=".$_SESSION['Id']);
}
else if(isset($_POST['modif_mail'])) 
{
	header("Location: modification_mail.php?Id=".$_SESSION['Id']);
}
else if(isset($_POST['modif_mdp'])) 
{
	header("Location: modification_mdp.php?Id=".$_SESSION['Id']);
}
else if(isset($_POST['modif_avatar'])) 
{
	header("Location: modification_avatar.php?Id=".$_SESSION['Id']);
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
			<h2>Edition de mon profils</h2>
		</header>
		<body>
			<div align="center">
				<?php
				if (!empty($info['avatar'])) 
				{
				?>
				<img src="avatar/<? echo $info['avatar']; ?>" width="150" border="5px solid #181818" />
				<?php
				}
				?>
				<br /><br />

			</div>
			<div align="center" >
				<form method="POST" action="" enctype="multipart/form-data" >
					<table>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr >
							<td align="right">
								<label>Pseudo:</label>
								<input style="width: 210px; height: 32px;" type="text" name="new_pseudo"value="<?php echo $info['Pseudo']; ?>"  > 
								<input type= "submit" name="modif_pseudo" value="MODIFIER">
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td align="right">
								<label>Mail:</label>
								<input style="width: 210px; height: 32px;"type="email" name="new_mail" value="<?php echo $info['Mail']; ?>">
								<input type= "submit" name="modif_mail" value="MODIFIER">
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td align="right">
								<label>Mot de passe:</label>
								<input style="width: 210px; height: 32px;"type="password" name="newmdp" placeholder="Mot De Passe" value="<?php echo "xxxxxxxxxxxxxx";?>">
								<input type= "submit" name="modif_mdp" value="MODIFIER">
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td align="center">
								<label >Avatar :</label>
								<input type= "submit" name="modif_avatar" value="MODIFIER">
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
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
				$profil = 'profil.php?Id='.$_SESSION['Id'];
				?>
				<p> Quittez sans mettre a jour ?<a href="<?php echo $profil; ?>"> cliquez ici </a></p> <br />
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
