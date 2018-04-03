<?php
 require 'bdd.php';
 require 'fonction.php';
 
if (isset($_POST['ok']))
{
	$pseudo = htmlspecialchars($_POST['pseudo']);
	$mail   = htmlspecialchars($_POST['mail']);                        # ne pas ouvlier de seulemtn autorise les pseudo abec des chiffre et lettre et aussi underscord ..... 
	$mail2  = htmlspecialchars($_POST['mail2']);
	$mdp    = ($_POST['mdp']);
	$mdp2   = ($_POST['mdp2']);
	
	if (!empty($pseudo) AND !empty($mail) AND !empty($mail2) AND !empty($mdp) AND !empty($mdp2))
	{
		$taille_pseudo = strlen($pseudo);
		if ($taille_pseudo <= 255)
		{
			$req_pseudo = $bdd->prepare('SELECT * FROM membre WHERE pseudo=?');
			$req_pseudo->execute(array($pseudo));
			$pseudo_exist = $req_pseudo->rowCount();
			if ($pseudo_exist == 0) 
			{
				if ($mail == $mail2) 
				{
					if (filter_var($mail, FILTER_VALIDATE_EMAIL))
					{
						$reqmail = $bdd->prepare('SELECT * FROM membre WHERE mail=?');
						$reqmail->execute(array($mail));
						$mail_existe = $reqmail->rowCount();
						if ($mail_existe == 0)
						{
							if ($mdp == $mdp2)
							{
								if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{4,}$#', $mdp)) 
								{
									$mdp_secure = sha1($mdp);
									$token = str_random(60);
									$insert_mbr = $bdd->prepare('INSERT INTO membre (pseudo, Mail, motdepasse, date_inscription, avatar, confirmation_token) VALUES (?, ?, ?, NOW(), ?, ?)');
									$insert_mbr->execute(array($pseudo, $mail, $mdp_secure, "defaut.png", $token));
									$message = "Votre compte à bien était créer !";
									$user_id = $bdd->lastInsertId();
									$headers  = 'MIME-Version: 1.0' . "\r\n";
									$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
							if (isset($_POST['mail'])){
			mail($_POST['mail'], "Confirmation de votre compte Camagru", "Afin de valider votre compte, merci de bien vouloir cliquer sur le lien ci-dessous\n\nhttp://localhost:8888/test/confirm.php?Id=$user_id&token=$token", $headers);
									}
								}
								else
								{
									$erreur = "Le mot de passe doit contenire au moins 6 caractères dont 1 majuscule et 1 chiffre!";
								}
							}
							else
							{
								$erreur = "Les mots de passe ne sont pas indentiques !";
							}
						}
						else
						{
							$erreur = "Cette adresse email est déjà utilisé !";
						}
					}
					else
					{
						$erreur = " Veuillez entrer une adresse email Valide !";
					}
				}
				else
				{
					$erreur = "Les 2 adresses email ne sont pas identique !";
				}
			}
			else
			{
				$erreur = "Ce pseudo est déjà utilisé";
			}
		}
		else
		{
			$erreur = "Votre pseudo doit être inferieure à 255 caractères !";
		}
	}
	else
	{
		$erreur = "Tous les champs doivent êtres remplis !";
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
		<body>
			<div align="center" >
				<form method="POST" action="">
					<table>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td>
								<input style="width: 210px; height: 32px;" type="text" name="pseudo" placeholder="Votre Pseudo" value="<?php if(isset($pseudo)) { echo $pseudo;} ?>" required/> 
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td>
								<input style="width: 210px; height: 32px;"type="email" name="mail" placeholder="Adresse E-Mail"value="<?php if(isset($mail)) { echo $mail;} ?>" required/>
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td>
								<input style="width: 210px; height: 32px;"type="email" name="mail2" placeholder="Confirmation E-Mail"value="<?php if(isset($mail2)) { echo $mail2;} ?>"required/>
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td>
								<input style="width: 210px; height: 32px;"type="password" name="mdp" placeholder="Mot De Passe (1 majuscule et 1 chifre)" required/>
							</td>
						</tr>
					
						<tr><td></td></tr>
						<tr>	<tr><td></td></tr>
							<td>
								<input style="width: 210px; height: 32px;"type="password"type="password" name="mdp2" placeholder="Confirmation Mot De Passe" required/>
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td align="center">
								<input type="submit" name="ok" value="INSCRIPTION">
							</td>
						</tr>
						<tr><td></td></tr>
					</table>
				</form>
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
				<p> Acces galerie<a href="galerie.php"> cliquez ici </a></p>
				<p><span class="cadre">En vous inscrivant, Vous acceptez nos conditions d'utilisation et notre politique de condidentialité.</span></p>
				<div class="not_yet">
				<p>Vous avez un compte ? <a href="connexion.php"> Connectez-Vous</a></p>
				</div>
			</body>
		</div>
	<!-- </div> -->
</html>
<?php require 'footer.php'; ?>