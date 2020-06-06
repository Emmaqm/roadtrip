<?php

$DB_host = getenv('HOST');
$DB_user = getenv('USER');
$DB_pass = getenv('PASS');
$DB_name = getenv('DB');
$DB_port = getenv('PORT');


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