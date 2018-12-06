<?php
ob_start();
session_start();
if($_SESSION['name']!='admin')
{
header('location: login.php');
}
?>


<?php require_once("header.php");?>

<h2><b>Welcome To Admin Panel of DU NEWS PORTAL</b></h2>
<h4>Here we can manage our all news</h4><hr />
<h2>View Our Main Site <a href="../" class="btn btn-success">View</a></h2>

<?php require_once("footer.php");?>