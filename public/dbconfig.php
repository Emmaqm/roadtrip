<?php

$DB_host = getenv('RT_HOST');
$DB_user = getenv('RT_USER');
$DB_pass = getenv('RT_PASS');
$DB_name = getenv('RT_DB');
$DB_port = getenv('RT_PORT');

try
{
	$DB_con = new PDO("mysql:host={$DB_host};port={$DB_port};dbname={$DB_name}",$DB_user,$DB_pass);
	$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$DB_con->exec("set names utf8");
}
catch(PDOException $e)
{
	echo $e->getMessage();
}

include_once 'class_lib.php';

$crud = new crud($DB_con);
$ciudadesClass = new ciudadesClass($DB_con);

?>