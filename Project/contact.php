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
		$file_basename = substr($up_filename, 0, strripos($up_filename, '.')); // strip extention
		$file_ext = substr($up_filename, strripos($up_filename, '.')); // strip name
		$f1 = $new_id . $file_ext;
		
		if(($file_ext!='.png')&&($file_ext!='.jpg')&&($file_ext!='.jpeg')&&($file_ext!='.gif'))
			throw new Exception("Only jpg, jpeg, png and gif format images are allowed to upload.");
		
		move_uploaded_file($_FILES["image"]["tmp_name"],"uploads/" . $f1);	
		
		
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

<!DOCTYPE html>
<html>
<head>
<title>Contact</title>

<?php include("head.php"); ?>	 
</head>

<body>




<?php 
	include("config.php");
?>

<?php
 include("header.php");
 ?>


<!--header end-->
<div class="contentsection contemplete clear">
	<div class="maincontent clear">
		<div class="about">
			<h2>Contact us</h2>
			<table>
			<tr>
				<td>Your First Name:</td>
				<td>
				<input type="text" name="firstname" placeholder="Enter first name"/>
				</td>
			</tr>
			<tr>
				<td>Your Last Name:</td>
				<td>
				<input type="text" name="lastname" placeholder="Enter Last name"/>
				</td>
			</tr>
			
			<tr>
				<td>Your Email Address:</td>
				<td>
				<input type="email" name="email" placeholder="Enter Email Address"/>
				</td>
			</tr>
			<tr>
				<td>Your Message:</td>
				<td>
				<textarea></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
				<input type="submit" name="" value="Submit"/>
				</td>
			</tr>
			</table>
		 </div>
		 
		
		
		<div class="about" style="margin-top:80px">
			<h2>For Publish Any News</h2>
			<p>
			<?php
				if(isset($error_message)) {echo "<div class='error'>".$error_message."</div>";}
				if(isset($success_message)) {echo "<div class='success'>".$success_message."</div>";}
			?>
			</p>
			<form method="post" enctype="multipart/form-data">
			<table>
			<tr>
				<td>News Title:</td>
				<td>
				<input type="text" name="title" placeholder="Enter News Title" style="width:525px"/>
				</td>
			</tr>
			<tr>
				<td>News Description:</td>
				<td>
				<textarea name="long_description"></textarea>
				
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
						//editor.setData( '<p>Just click the <b>Image</b> or <b>Link</b> button, and then <b>&quot;Browse Server&quot;</b>.</p>' );
					}

				</script>
				
				</td>
			</tr>
			
			<tr style="margin-top:15px">
				<td>Faculty:</td>
				<td>
					<select name="faculty_id" style= "width:35%">
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
			
			<tr style="margin-top:30px">
				<td>Category:</td>
				<td>
					<select name="category_id" style= "width:35%">
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
						
				</td>
			</tr>
			
			<tr>
				<td>News Image:</td>
				<td>
					<input type="file" name="image" style="width:300px"/>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
				<input type="submit" name="add_news" value="Submit"/>
				</td>
			</tr>
			</table>
			
		</form>
		 </div>

	</div>
	
	<?php include("sideber.php"); ?>
	
</div>

<?php include("footer.php"); ?>



</body>
</html>