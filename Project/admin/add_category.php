<?php
ob_start();
session_start();
if($_SESSION['name']!='admin')
{
header('location: login.php');
}
include('../config.php');
?>

<?php

if(isset($_POST['category']))
{
	try {
		
		if(empty($_POST['cat_name'])) {
			throw new Exception("Category Name can not be empty.");
		}
		
		$statement = $db->prepare("SELECT * FROM category WHERE cat_name=?");
		$statement->execute(array($_POST['cat_name']));
		$total = $statement->rowCount();
		
		if($total>0) {
			throw new Exception("Category Name already exists.");
		}
		
		$statement = $db->prepare("INSERT INTO category (cat_name) VALUES (?)");
		$statement->execute(array($_POST['cat_name']));
		
		$success_message = "Category name has been inserted successfully.";
		
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
} 

?>

<?php
include('header.php');
?>


<center><h2><b>Add Category</b></h2></center>

<p>&nbsp;</p>

<center><p><b>
<?php
if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
?>
</b></p></center>

<form class="form-horizontal" method="post">
    <table class="">
	
		<tr>
            <th class="bold">Category name</th>
            <td><input type="text" class="form-control" name="cat_name"/></td>
        </tr>
        
        <tr>
            <th></th>
            <td class="bold"><input type="submit" class="btn btn-primary" name="category" value="Add Category"/></d>
        </tr>
    </table>
</form>


<?php require_once("footer.php"); ?>