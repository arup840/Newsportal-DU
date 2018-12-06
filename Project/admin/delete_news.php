<?php
ob_start();
session_start();
if($_SESSION['name']!='admin')
{
	header('location: login.php');
}
include("../config.php");
?>

<?php

if(!isset($_REQUEST['id'])) {
	header("location: manage_news.php");
}
else {
	$id = $_REQUEST['id'];
}
?>

<?php

$statement = $db->prepare("SELECT * FROM news WHERE news_id=?");
$statement->execute(array($id));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach($result as $row)
{
	$real_path = "../uploads/".$row['image'];
	unlink($real_path);
}


$statement = $db->prepare("DELETE FROM news WHERE news_id=?");
$statement->execute(array($id));

header("location: manage_news.php");

?>