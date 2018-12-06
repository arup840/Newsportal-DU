
<?php 
	include("config.php");
?>

<div class="headersection templete clear">
		<div class="logo">
			<a href="index.php"> <img src="images/du_logo.png" alt="Logo"/> </a>
			
			<h2>DU NEWS PORTAL</h2>
			<p>Dhaka University</p>
		</div>
		
		<div  class="social">
			<a style="background-color: #2ecc71 " href="http://www.facebook.com"><i class="fa fa-facebook"></i></a>
			<a style="background-color: #2ecc71 " href="http://www.twitter.com"><i class="fa fa-twitter"></i></a>
			<a style="background-color: #2ecc71 "href="http://www.google.com"><i class="fa fa-linkedin"></i></a>
			<a style="background-color: #2ecc71 "href="https://plus.google.com/"><i class="fa fa-google-plus"></i></a>
		</div>
	</div>
<div style="background-color: #1abc9c" class="navsection templete">
		<ul>
			<li><a href="index.php">Home</a></li>
			
			<li><a href="">Faculty</a>
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
			<li><a href="contact.php">Contact</a></li>
			
			
			<li><a href="about.php">About</a></li>
			
		</ul>
	</div>
	
	
	<div class="slidersection templete clear">
	
	<div id="slider">
            <a href="#"><img src="images/slideshow/new/01.jpg" alt="nature 1" /></a>
            <a href="#"><img src="images/slideshow/new/02.jpg" alt="nature 2" /></a>
            <a href="#"><img src="images/slideshow/new/03.jpg" alt="nature 3" /></a>
            <a href="#"><img src="images/slideshow/new/05.jpg" alt="nature 4" /></a>
        </div>
	
	</div>
	
	
	
	
	