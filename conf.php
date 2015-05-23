<?php
function connexion(){
$host = "";
$port = "5432";
$user = "";
$password = "";
$dbname = "";
$connexion = "host=localhost port=$port user=$user password=$password dbname=$dbname";
$db = pg_connect($connexion)or die ("Oula ça craint.." . pg_last_error($db));
return $db;
}
function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

?>
