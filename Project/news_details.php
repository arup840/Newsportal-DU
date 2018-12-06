
<?php
	include("config.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>DU News</title>
	
	<?php include("head.php"); ?>
	
</head>

<body>
	
	<?php include("header.php"); ?>
	



	<div class="contentsection contemplete clear">
	
		<div class="maincontent clear">
		
		<?php
		
			$statement = $db->prepare("SELECT * FROM news WHERE news_id=?");
			$statement->execute(array($_REQUEST['id']));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			foreach($result as $row)
			{
		?>
		
			<div class="about">
				<h2><?php echo $row['title']; ?></h2>
				
					
				<div>
			<span class="date">
				<?php
				
					$post_date = $row['date'];
					$day = substr($post_date,8,2);
					$month = substr($post_date,5,2);
					$year = substr($post_date,0,4);
					if($month=='01') {$month="Jan";}
					if($month=='02') {$month="Feb";}
					if($month=='03') {$month="Mar";}
					if($month=='04') {$month="Apr";}
					if($month=='05') {$month="May";}
					if($month=='06') {$month="Jun";}
					if($month=='07') {$month="Jul";}
					if($month=='08') {$month="Aug";}
					if($month=='09') {$month="Sep";}
					if($month=='10') {$month="Oct";}
					if($month=='11') {$month="Nov";}
					if($month=='12') {$month="Dec";}
					echo $day.' '.$month.', '.$year;
				?>
			</span>
			<span class="categories">
			in:&nbsp;
				<?php
				$arr = explode(",",$row['category_id']);
				$count_arr = count(explode(",",$row['category_id']));
				$k=0;
				for($j=0;$j<$count_arr;$j++)
				{
					
					$statement1 = $db->prepare("SELECT * FROM category WHERE category_id=?");
					$statement1->execute(array($arr[$j]));
					$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
					foreach($result1 as $row1)
					{
						$arr1[$k] = $row1['cat_name'];
					}
					$k++;
				}
				$cat_name = implode(",",$arr1);
				echo $cat_name;
			?>

			
				</span>
		</div>
				
				
				
				
				<img src="uploads/<?php echo $row['image']; ?>" alt="" width="300px"/>
				<p>
					<?php echo $row['long_description']; ?>
				</p>
				
				
			</div>
			
			<?php
				}
			?>

		</div>
		
		
		<?php include("sideber.php"); ?>
		
	</div>

	<?php include("footer.php"); ?>
	
</body>
</html>