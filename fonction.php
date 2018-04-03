<?php
require 'bdd.php';

function debug($variable)
{
	echo '<pre>' .print_r($variable, true) . '</pre>';
}



function str_random($lenght)
{
	$alphabet= "0123456789azertyuiopqsdfghklmwxcvbnAZERTYUIOPQSDFGHKLMWXCVBN";
	return  substr(str_shuffle(str_repeat($alphabet, $lenght)), 0, $lenght);
}
?>