<?php
session_start();
require 'bdd.php';
require 'fonction.php';
require 'header.php';
if (isset($_SESSION['Pseudo']))
{
	$pseudo    = $_SESSION['Pseudo'];
	$requser  = $bdd->prepare("SELECT * FROM membre Where Pseudo = ?");
	$requser->execute(array($pseudo));
	$userinfo=$requser->fetch();
}

	if(isset($_POST['ok'])){
		$id_user = $_SESSION['Id'];
		$mail_user = $_SESSION['Mail'];
		$image = $_FILES['image']['name'];
		$image_tmp = $_FILES['image']['tmp_name'];
		if(!empty($image_tmp)){
			$type = explode('.',$image);
			$type_ext = end($type);
			if(in_array(strtolower($type_ext),array('png','gif','jpeg','jpg')) === false){
				$error = "Veuillez saisir une image";
			}
			else
			{
				$image = 'image/'.str_random(10).'.'.$type_ext;
				$insert = $bdd->prepare('INSERT INTO fichiers (Name_image, Id_usr, Mail_user) VALUES (?, ?, ?)');
				$insert->execute(array($image, $id_user, $mail_user));
				move_uploaded_file($_FILES['image']['tmp_name'], $image);
				$up = "Votre image à correctement été uplodé";
			}
		}
	}
	?>
	<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="camagru.css">
		<title> CAMAGRU </title>
	</head>
	<!-- <div id="bloc_page"> -->
		<header align="center">
			<h2>Profil de <?php echo $_SESSION['Pseudo'] ?> </h2>
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
				<form method="post" action="" enctype="multipart/form-data">
					<p><font color="blue">Upload une image &ensp;</font></p>
					<input type="file" name="image"/></br>
					<input type="submit" value="Uploder" name="ok">
				</form>
				<?php
				if (isset($error)) 
				{
					echo '<font color="red">' .$error. '</font>';
				}
				else if (isset($up)) 
				{
					echo '<font color="red">' .$up. '</font>';
				}?></br>
				<?php
				if (isset($_SESSION['Id']) AND $userinfo['Id'] == $_SESSION['Id'])
				{
					$profil = 'profil.php?Id='.$_SESSION['Id'];
					$gal = 'galerie.php?Id='.$_SESSION['Id'];
					?> 
					<a href="deconnexion.php"><em> Se deconnecter</em></a>
					<a href="<?php echo $profil; ?>"><em> Retour vers profil</em></a><br />
					<a href="<?php echo $gal; ?>"> <strong>Galerie</strong></a>
					<?php
				} 
				?>
				<div id"application">
					<p>Télécharger l'application. </p><br/>
					<a href="https://www.apple.com/fr/" target="_blank"><img src="photo/apple.png" class="apple"></a> <a href="https://play.google.com/store/apps?hl=fr" target="_blank"><img src="photo/google.png" class="go"></a>
				</div>
			</body>
		</div>
	<!-- </div> -->
</html>
<?php require 'footer.php'; ?>