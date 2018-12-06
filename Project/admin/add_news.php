


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

if(isset($_POST['add_news'])) {


	try {
	
		if(empty($_POST['title'])) {
			throw new Exception("Post Title can not be empty.");
		}
		
		if(empty($_POST['long_description'])) {
			throw new Exception("Description can not be empty.");
		}
		
		if(empty($_POST['faculty_id'])) {
			throw new Exception("Faculty Name can not be empty.");
		}
		
		if(empty($_POST['category_id'])) {
			throw new Exception("Category Name can not be empty.");
		}
		
		$statement = $db->prepare("SHOW TABLE STATUS LIKE 'news'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row)
		$new_id = $row[10];
		
		
		$up_filename=$_FILES["image"]["name"];
		$file_basename = substr($up_filename, 0, strripos($up_filename, '.')); 
		$file_ext = substr($up_filename, strripos($up_filename, '.')); 
		$f1 = $new_id . $file_ext;
		
		if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
			throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
		
		move_uploaded_file($_FILES["image"]["tmp_name"],"../uploads/" . $f1);	
		
		
		$date = date('Y-m-d');
		$timestamp = strtotime(date('Y-m-d'));
		$year = substr($date,0,4);
		$month = substr($date,5,2);
		
		
		
		$statement = $db->prepare("INSERT INTO news (title,long_description,faculty_id,category_id,image,date,year,month,timestamp) VALUES (?,?,?,?,?,?,?,?,?)");
		$statement->execute(array($_POST['title'],$_POST['long_description'],$_POST['faculty_id'],$_POST['category_id'],$f1,$date,$year,$month,$timestamp));
		
		
		$success_message = "News is inserted successfully.";
		
		
	
	}
	
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}


}

?>



<?php
include('header.php');
?>

<center><h2>Add News</h2></center>

<?php
if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
?>

<form class="form-horizontal" method="post" enctype="multipart/form-data">

	
	
     <table class="">
        <tr>
            <th class="bold">News Title :</th>
            <td><input type="text" class="form-control" name="title"/></td>
        </tr>
		
        <tr>
            <th class="bold">Long Description :</th>
            <td>
			<textarea class="form-control textarea" name="long_description" cols="30" rows="10"></textarea>
				<script type="text/javascript">
					if ( typeof CKEDITOR == 'undefined' )
					{
						document.write(
							'<strong><span style="color: #ff0000">Error</span>: CKEditor not found</strong>.' +
							'This sample assumes that CKEditor (not included with CKFinder) is installed in' +
							'the "/ckeditor/" path. If you have it installed in a different place, just edit' +
							'this file, changing the wrong paths in the &lt;head&gt; (line 5) and the "BasePath"' +
							'value (line 32).' ) ;
					}
					else
					{
						var editor = CKEDITOR.replace( 'long_description' );
						
					}

				</script>
			</td>
        </tr>
		
		<tr>
            <th class="bold">Select Faculty :</th>
            <td>
				<select name="faculty_id" class="form-control">
					<option value="">Select a Faculty</option>
						<?php
							$statement = $db->prepare("SELECT * FROM faculty ORDER BY short_name ASC");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach($result as $row)
							{
						?>
							<option value="<?php echo $row['faculty_id']; ?>"><?php echo $row['short_name']; ?></option>
								<?php
									}
								?>
				</select>
			</td>
        </tr>
		
		<tr>
            <th class="bold">Select Category :</th>
            <td>
				<select name="category_id" class="form-control">
					<option value="">Select a Category</option>
						<?php
							$statement = $db->prepare("SELECT * FROM category ORDER BY cat_name ASC");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);
							foreach($result as $row)
							{
						?>
							<option value="<?php echo $row['category_id']; ?>"><?php echo $row['cat_name']; ?></option>
								<?php
									}
								?>
				</select>
			</td>
        </tr>
		
        <tr>
            <th class="bold">News Image :</th>
            <td><input type="file" class="form-control" name="image"/></td>
        </tr>
		
		<tr>
            <th class="bold"> Publication Status &nbsp;&nbsp;&nbsp;</th>
            <td><select name="status" class="form-control">
                                <option value=" ">Select Publication Status</option>
                                <option value="1">Published</option>
                                <option value="0">Un Published</option>
                            </select></td>
        </tr>
        <tr>
            <th></th>
            <td class="bold"><input type="submit" class="btn btn-primary" name="add_news" value="Add News"/></td>
        </tr>
    </table>
</form>


<?php require_once("footer.php"); ?>