<?php
include("config.php");
					
	$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
	$limit = 5;                                 //how many items to show per page
	$page = @$_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit;          //first item to display on this page
	else
		$start = 0;
	
				
	$statement = $db->prepare("SELECT * FROM news ORDER BY news_id DESC LIMIT $start, $limit");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="sidebar clear">
		<div class="samesidebar clear">
			<h2><b>Latest articles</b></h2>
				<ul>
				<?php
				foreach($result as $row)
					{
				?>
				<li><a href="news_details.php?id=<?php echo $row['news_id']; ?>"><?php echo $row['title']; ?></a></li>
	<?php
		} 
	?>
					
				</ul>
		</div>

<?php


		
	
					
	
	$targetpage = $_SERVER['PHP_SELF'];   
	$limit = 3;                                
	$page = @$_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit;          
	else
		$start = 0;
	
				
	$statement = $db->prepare("SELECT * FROM news ORDER BY news_id ASC LIMIT $start, $limit");
	$statement->execute();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

		<div class="samesidebar clear">
			<h2><b>Popular articles</b></h2>
				<div class="popular clear">
				
				<?php
				foreach($result as $row)
					{
				?>
				
				
				<h3><a href="news_details.php?id=<?php echo $row['news_id']; ?>"><b><?php echo $row['title']; ?></b></a></h3>
					
					
					
					<a href="#"><img src="uploads/<?php echo $row['image']; ?>" alt=""/></a>
					<p>
						<?php
							$pieces = explode(" ", $row['long_description']);
							$final_words = implode(" ", array_splice($pieces, 0, 20));
							$final_words = $final_words.' ...';
						?>
						<?php echo $final_words; ?>
					</p>	
					
					<?php
						} 
					?>
				</div>

		</div>
		
		
		
		
		
	</div>