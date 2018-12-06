


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

<div class="headersection templete clear">
		<div class="logo">
			<img src="images/pstu.png" alt="Logo"/>
			
			<h2>PSTU NEWS</h2>
			<p>Patuakhali Science And Technology University</p>
		</div>
		
		<div class="social">
			<a href="#"><i class="fa fa-facebook"></i></a>
			<a href="#"><i class="fa fa-twitter"></i></a>
			<a href="#"><i class="fa fa-linkedin"></i></a>
			<a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
		</div>
	</div>
<div class="navsection templete">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="about.php">About</a></li>
			<li><a href="">Faculties</a>
			<ul>
			<?php
					$statement = $db->prepare("SELECT * FROM faculty");
					$statement->execute();
					$result = $statement->fetchAll(PDO::FETCH_ASSOC);
					foreach($result as $row)
					{
				?>
			
				
					<li><a href="faculty.php?id=<?php echo $row['faculty_id']; ?>"><?php echo $row['short_name']; ?></a></li>
					
					<?php
						}
					?>
				</ul>
			</li>
			<li><a href="">Category</a>
			<ul>
				<?php
					$statementt = $db->prepare("SELECT * FROM category ORDER BY cat_name ASC");
					$statementt->execute();
					$resultt = $statementt->fetchAll(PDO::FETCH_ASSOC);
					foreach($resultt as $row)
					{
				?>
			
				
					<li><a href="category.php?id=<?php echo $row['category_id']; ?>"><?php echo $row['cat_name']; ?></a></li>
					
					<?php
						}
					?>
				</ul>
			</li>
			<li><a href="contact.php">Contact</a>
		</ul>
	</div>



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
		 
		<div class="googlemp">
			<div id="map"></div>
		</div>
		
		<div class="about">
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
				<input type="text" name="title" placeholder="Enter News Title"/>
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
			
			<tr>
				<td>Faculty:</td>
				<td>
					<select name="faculty_id">
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
				<td>Category:</td>
				<td>
					<select name="category_id">
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
					<td><input type="file" name="image"/></td>
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

<script src="http://maps.google.com/maps/api/js"></script>
<script src="js/gmaps.js"></script>

<script type="text/javascript">
var map;
$(document).ready(function(){
  var map = new GMaps({
	el: '#map',
	lat: 23.7805733,
	lng: 90.2792383,
	scrollwheel:false
  });
  GMaps.geolocate({
	success: function(position){
	  map.setCenter(position.coords.latitude, position.coords.longitude);
	},
	error: function(error){
	  alert('Geolocation failed: '+error.message);
	},
	not_supported: function(){
	  alert("Your browser does not support geolocation");
	},
	always: function(){
	  alert("Done!");
	}
  });
});
</script>
</body>
</html>