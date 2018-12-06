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

	if(isset($_POST['update_category']))
{
	try {
		
		if(empty($_POST['cat_name'])) {
			throw new Exception("Category Name can not be empty.");
		}
		
		$statement = $db->prepare("UPDATE category SET cat_name=? WHERE category_id=?");
		$statement->execute(array($_POST['cat_name'],$_POST['hdn']));
		
		$success_message1 = "Category Name has been updated successfully.";
		
	}
	catch(Exception $e) {
		$error_message1 = $e->getMessage();
	}
		
}

	if(isset($_REQUEST['id'])) 
	{
	$id = $_REQUEST['id'];
	
	$statement = $db->prepare("DELETE FROM category WHERE category_id=?");
	$statement->execute(array($id));
	
	$success_message2 = "Category Name has been deleted successfully.";
	
}

?>

<?php include("header.php"); ?>
<!---Content Part --->
<div id="content">
<h2>View  All Categories</h2>

<?php
	if(isset($error_message1)) {echo "<div class='error'>".$error_message1."</div>";}
	if(isset($success_message1)) {echo "<div class='success'>".$success_message1."</div>";}
	if(isset($success_message2)) {echo "<div class='success'>".$success_message2."</div>";}
?>



<table class="table table-responsive table-hover" width="100%">
	<tr style="background-color: #0D7B7B;color: #FFF;height: 40px;">
		<th width="5%" style="text-align: center; border-right: 1px solid #FFF;">Serial</th>
		<th width="75%" style="text-align: center; border-right: 1px solid #FFF;">Category Name</th>
		<th width="15%" style="text-align: center; ">Action</th>
	</tr>
	
	
	<?php
	$i=0;
	$statement = $db->prepare("SELECT * FROM category ORDER BY cat_name ASC");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row)
	{
		$i++;
		?>

	

		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row['cat_name']; ?></td>
			<td>
			<a class="fancybox" href="#inline<?php echo $i; ?>">Edit</a>
			<div id="inline<?php echo $i; ?>" style="width:400px;display: none;">
				<h3>Edit Category</h3>
				<p>
					<form action="" method="post">
					<input type="hidden" name="hdn" value="<?php echo $row['category_id']; ?>">
					<table>
						<tr>
							<td>Category Name</td>
						</tr>
						<tr>
							<td><input type="text" name="cat_name" value="<?php echo $row['cat_name']; ?>"></td>
						</tr>
						<tr>
							<td><input type="submit" value="UPDATE" name="update_category"></td>
						</tr>
					</table>
					</form>
				</p>
			</div>
			
			&nbsp;|&nbsp;
			
			<a onclick='return confirmDelete();' href="manage_category.php?id=<?php echo $row['category_id']; ?>">Delete</a></td>
	
		</tr>
		
		<?php
	}
	?>


</table>
</div>

<?php include("footer.php"); ?>