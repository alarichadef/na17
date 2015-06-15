<?php

// Config erreurs :
// Afficher les erreurs à l'écran
//ini_set('display_errors', 1);
// Enregistrer les erreurs dans un fichier de log
//ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
//ini_set('error_log', dirname(__file__) . '/log_error_php.txt');
// Afficher les erreurs et les avertissements
//error_reporting(e_all);

/*error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
display_errors("stdout");
display_startup_errors(TRUE);*/

// Config BDD :
// Config UTC 
$host = "127.0.0.1";
$port = "5432";
$user = "nf17p184";
$password = "9FlAJomS";
$dbname = "dbnf17p184";
/* // Config Adrien 
$host = "127.0.0.1";
$port = "5432";
$user = "postgres";
$password = "postgres";
$dbname = "";*/
error_reporting(E_ALL);

function connexion(){
global $host, $port, $user, $password, $dbname;
$connexion = "host=$host port=$port user=$user password=$password dbname=$dbname";
global $db ;
$db = pg_connect($connexion)or die ("Oula ça craint.." . pg_last_error($db));
return $db;
}

// config Path
define('__ROOT__', dirname(__FILE__)); 


function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date, new DateTimeZone('Europe/Paris'));
    return $d && $d->format($format) == $date;
}

?>
