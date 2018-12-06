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

if(isset($_POST['faculty'])) 
{
	
	try {
	
		
		if(empty($_POST['short_name'])) {
			throw new Exception('Short Name can not be empty');
		}
		
		if(empty($_POST['full_name'])) {
			throw new Exception('Full Name can not be empty');
		}
	
				
		$statement = $db->prepare("INSERT INTO faculty (short_name,full_name) VALUES (?,?)");
		$statement->execute(array($_POST['short_name'],$_POST['full_name']));
		
		$success_message = "Faculty is inserted successfully.";
	
	
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
	
}

?>

<?php
include('header.php');
?>


<center><h2><b>Add Faculty</b></h2></center>

<center><p><b>
<?php
if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
?>
</b></p></center>

<form class="form-horizontal" method="post" enctype="multipart/form-data">
    <table class="">
	
		<tr>
            <th class="bold">Faculty Short Title</th>
            <td><input type="text" class="form-control" name="short_name"/></td>
        </tr>
		
        <tr>
            <th class="bold">Faculty Full Name</th>
            <td><input type="text" class="form-control" name="full_name"/></td>
        </tr>
        
        <tr>
            <th></th>
            <td class="bold"><input type="submit" class="btn btn-primary" name="faculty" value="Add Faculty"/></td>
        </tr>
    </table>
</form>


<?php require_once("footer.php"); ?>