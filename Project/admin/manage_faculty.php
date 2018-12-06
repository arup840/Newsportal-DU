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

if(isset($_POST['update_faculty']))
{
try {
	
	if(empty($_POST['short_name'])) {
		throw new Exception('Short Name can not be empty');
	}
	
	if(empty($_POST['full_name'])) {
		throw new Exception('Full Name can not be empty');
	}
	
	$statement = $db->prepare("UPDATE faculty SET short_name=?,full_name=? WHERE faculty_id=?");
	$statement->execute(array($_POST['short_name'],$_POST['full_name'],$_POST['hdn']));
	
	$success_message1 = "Faculty has been updated successfully.";
	
}
catch(Exception $e) {
	$error_message1 = $e->getMessage();
}
	
}

if(isset($_REQUEST['id'])) 
{
$id = $_REQUEST['id'];

$statement = $db->prepare("DELETE FROM faculty WHERE faculty_id=?");
$statement->execute(array($id));

$success_message2 = "Faculty has been deleted successfully.";

}

?>


<?php include("header.php"); ?>
<!---Content Part --->
<div id="content">
<h2>View  All Faculties</h2>


<?php
	if(isset($error_message1)) {echo "<div class='error'>".$error_message1."</div>";}
	if(isset($success_message1)) {echo "<div class='success'>".$success_message1."</div>";}
	if(isset($success_message2)) {echo "<div class='success'>".$success_message2."</div>";}
?>



<table class="table table-responsive table-hover" width="100%">
	<tr style="background-color: #0D7B7B;color: #FFF;height: 40px;">
		<th width="5%" style="text-align: center; border-right: 1px solid #FFF;">Serial</th>
		<th width="20%" style="text-align: center; border-right: 1px solid #FFF;">Faculty Short Title</th>
		<th width="60%" style="text-align: center; border-right: 1px solid #FFF;">Faculty Long Title</th>
		<th width="15%" style="text-align: center; ">Action</th>
	</tr>

	<?php
	$i=0;
	$statement = $db->prepare("SELECT * FROM faculty ORDER BY faculty_id ASC");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	foreach($result as $row)
	{
		$i++;
		?>

		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row['short_name']; ?></td>
			<td><?php echo $row['full_name']; ?></td>
			<td>
				<a class="fancybox" href="#inline<?php echo $i; ?>">Edit</a>
			<div id="inline<?php echo $i; ?>" style="width:400px;display: none;">
				<h3>Edit Faculty</h3>
				<p>
					<form action="" method="post">
					<input type="hidden" name="hdn" value="<?php echo $row['faculty_id']; ?>">
					<table>
						<tr>
							<td>Short Name</td>
							<td>Full Name</td>
						</tr>
						<tr>
							<td><input type="text" name="short_name" value="<?php echo $row['short_name']; ?>"></td>
							<td><input type="text" name="full_name" value="<?php echo $row['full_name']; ?>"></td>
						</tr>
						<tr>
							<td><input type="submit" value="UPDATE" name="update_faculty"></td>
						</tr>
						</table>
					</form>
				</p>
			</div>
			
			&nbsp;|&nbsp;
			
			<a onclick='return confirmDelete();' href="manage_faculty.php?id=<?php echo $row['faculty_id']; ?>">Delete</a></td>
	
		</tr>
		
		<?php
	}
	?>
	
</table>
</div>

<?php include("footer.php"); ?>