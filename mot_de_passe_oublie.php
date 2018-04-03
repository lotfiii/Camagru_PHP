<?php
require 'bdd.php';
require 'fonction.php';
require 'header.php';

if (isset($_POST['email_connexion'])) 
{
	$mail_connexion = htmlspecialchars($_POST['email_connexion']);
	if (!empty($mail_connexion)) 
	{
		$req_user = $bdd->prepare("SELECT * FROM membre WHERE Mail = ?");
		$req_user->execute(array($mail_connexion));
		$mail_existe = $req_user->rowCount();
		if ($mail_existe == 1)
		{
			$ret = $bdd->query('SELECT * FROM membre');
			while ($imgs = $ret->fetch())
			{
				if($imgs['Mail'] == $mail_connexion)
				{
					$user_id = $imgs['Id'];
					$token = $imgs['confirmation_token'];
				}	  
			}
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			if (isset($user_id)){
			mail($mail_connexion, "Reinitialiser votre compte Camagru", "Afin de reinisialiserer votre compte, merci de bien vouloir cliquer sur le lien ci-dessous\n\nhttp://localhost:8888/test/reinitialiser_mdp.php?Id=$user_id&token=$token", $headers);
			$erreur = "Veuillez ouvrir le lien reçu par E-mail !";
		}
		}
		else
		{
			$erreur = "Veuillez saisir un E-mail valide !";
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
			<h2>Reinitialisation mot de passe</h2>
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
								<input style="width: 210px; height: 32px;" type="text" name="email_connexion" placeholder="Votre E-mail"> 
							</td>
						</tr>
						<tr><td></td></tr>
						<tr><td></td></tr>
						<tr>
							<td align="center">
								<input type="submit" name="ok" value="Envoyer">
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
				<p><span class="cadre">Veuillez saisir votre E-mail</span></p>
				<div class="not_yet">
				<p>Pas encore de compte ? <a href="accueil.php"> Inscrivez-Vous</a></p> <br />
				</div>
			</body>
		</div>
	<!-- </div> -->
</html>
<?php require 'footer.php'; ?>