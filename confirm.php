<?php
$user_id = $_GET['Id'];
$token = $_GET['token'];
require 'bdd.php';
$req = $bdd->prepare('SELECT * FROM membre WHERE Id = ?');
$req->execute([$user_id]);
$user = $req->fetch();
session_start();
if ($user && $user['confirmation_token'] == $token){
	$bdd->prepare('UPDATE membre SET confirmation_at = NOW() WHERE id = ?')->execute([$user_id]);
	header('Location: connexion.php');
}
else{
	header('Location: accueil.php');
}


?>