<?php
 	require 'bdd.php';
 	session_start();
 	if (isset($_POST['del'])){
 		$id = htmlspecialchars($_POST['Id']);
 		$db = $bdd->prepare('DELETE FROM fichiers WHERE Id = ?');
 		$db->execute(array($id));
 	}
	$ret = $bdd->query('SELECT * FROM fichiers');
	$total = 0;
	$ret2 = $ret;
	$imagesParPage = 4;
	while ($imgs = $ret2->fetch())
	{
		$total++;	  
	}
	$nombreDePages=ceil($total/$imagesParPage);
	if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
	{
    	 $pageActuelle=intval($_GET['page']);
 		if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
     	{
          $pageActuelle=$nombreDePages;
     	}
	}
	else // Sinon
	{
   	  $pageActuelle=1; // La page actuelle est la n°1    
	}
	$premiereEntree=($pageActuelle-1)*$imagesParPage; // On calcul la première entrée à lire
	// La requête sql pour récupérer les messages de la page actuelle.
	$ret = $bdd->query('SELECT * FROM fichiers ORDER BY id DESC LIMIT '.$premiereEntree.', '.$imagesParPage.'');
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
		<?php
		$i = 0;
			while ($imgs = $ret->fetch())
 			{
 				$i++; 
 				?>
                 <img width="270" height="270" src="<?php echo $imgs['Name_image']; ?>"><?
                 if (isset($_GET['Id']) AND $_GET['Id'] == $imgs['Id_usr']){?> 
                 <form method="POST" action="">
              		<input type="hidden" name="Id" value="<?php echo $imgs['Id']; ?>" />   
                 	<input type="submit" name="del" value="Delete"/>
                 </form>
         		<?php
         	}
         		if($i == 2){
         			?><br /><?php
         		}
 			}
 			echo '<p align="center">Page : '; //Pour l'affichage, on centre la liste des pages
			for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
			{
    			 //On va faire notre condition
    	 		if($i==$pageActuelle) //Si il s'agit de la page actuelle...
     	 		{
       		  		echo ' [ '.$i.' ] '; 
     	 		}	
     	 		else if (isset($_SESSION['Id']))
     	 		{
           			echo ' <a href="galerie.php?page='.$i.'&Id='.$_SESSION['Id'].'">'.$i.'</a> ';
     			}
     			else
   				{
   					echo ' <a href="galerie.php?page='.$i.'">'.$i.'</a> ';
   				}
			}
			echo '</p>';
			if (isset($_SESSION['Id'])){
			$profil = 'profil.php?Id='.$_SESSION['Id'];
		}
			if (isset($_SESSION['Id'])){ 
			?>
			<div align="center" >
				<p> Retour vers profil?<a href="<?php echo $profil; ?>"> cliquez ici </a></p>
				</div>
				<?php
			}?>
			</body>
	<!-- </div> -->
</html>
<?php require 'footer.php'; ?>