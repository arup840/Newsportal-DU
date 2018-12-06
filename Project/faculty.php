<?php  
if(!isset($_REQUEST['id'])) {
	header("location: index.php");
}
else {
	$id = $_REQUEST['id'];
}
?>
<?php include('header.php'); ?>


<?php
	include("config.php");
		
	
?>








<!DOCTYPE html>
<html>
<head>
	<title>DU NEWS</title>
	<?php include("head.php"); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
.mySlides {display:none}
</style>
</head>

<body>
	
	
	
	
	
	
<div class="contentsection contemplete clear">
		<div class="maincontent clear">
		
			<?php
			
			
			
			
			
			
				/* ===================== Pagination Code Starts ================== */
			$adjacents = 7;
					
			$statement = $db->prepare("SELECT * FROM news WHERE faculty_id=? ORDER BY faculty_id DESC");
			$statement->execute(array($id));
			$total_pages = $statement->rowCount();
							
			
			$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
			$limit = 5;                                 //how many items to show per page
			$page = @$_GET['page'];
			if($page) 
				$start = ($page - 1) * $limit;          //first item to display on this page
			else
				$start = 0;
			
						
			$statement = $db->prepare("SELECT * FROM news WHERE faculty_id=? ORDER BY faculty_id DESC LIMIT $start, $limit");
			$statement->execute(array($id));
			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			
			
			if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
			$prev = $page - 1;                          //previous page is page - 1
			$next = $page + 1;                          //next page is page + 1
			$lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
			$lpm1 = $lastpage - 1;   
			$pagination = "";
			if($lastpage > 1)
			{   
				$pagination .= "<div class=\"pagination\">";
				if ($page > 1) 
					$pagination.= "<a href=\"$targetpage?id=$id&page=$prev\">&#171; previous</a>";
				else
					$pagination.= "<span class=\"disabled\">&#171; previous</span>";    
				if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
				{   
					for ($counter = 1; $counter <= $lastpage; $counter++)
					{
						if ($counter == $page)
							$pagination.= "<span class=\"current\">$counter</span>";
						else
							$pagination.= "<a href=\"$targetpage?id=$id&page=$counter\">$counter</a>";                 
					}
				}
				elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
				{
					if($page < 1 + ($adjacents * 2))        
					{
						for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?id=$id&page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?id=$id&page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?id=$id&page=$lastpage\">$lastpage</a>";       
					}
					elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
					{
						$pagination.= "<a href=\"$targetpage?id=$id&page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?id=$id&page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?id=$id&page=$counter\">$counter</a>";                 
						}
						$pagination.= "...";
						$pagination.= "<a href=\"$targetpage?id=$id&page=$lpm1\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?id=$id&page=$lastpage\">$lastpage</a>";       
					}
					else
					{
						$pagination.= "<a href=\"$targetpage?id=$id&page=1\">1</a>";
						$pagination.= "<a href=\"$targetpage?id=$id&page=2\">2</a>";
						$pagination.= "...";
						for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a href=\"$targetpage?id=$id&page=$counter\">$counter</a>";                 
						}
					}
				}
				if ($page < $counter - 1) 
					$pagination.= "<a href=\"$targetpage?id=$id&page=$next\">next &#187;</a>";
				else
					$pagination.= "<span class=\"disabled\">next &#187;</span>";
				$pagination.= "</div>\n";       
			}
			/* ===================== Pagination Code Ends ================== */	


			
			
			
			
			
			
			
			
			
			foreach($result as $row)
			{
		?>
		
			<div class="samepost clear">
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
				$arr = explode(",",$row['faculty_id']);
				$count_arr = count(explode(",",$row['faculty_id']));
				$k=0;
				for($j=0;$j<$count_arr;$j++)
				{
					
					$statement1 = $db->prepare("SELECT * FROM faculty WHERE faculty_id=?");
					$statement1->execute(array($arr[$j]));
					$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
					foreach($result1 as $row1)
					{
						$arr1[$k] = $row1['short_name'];
					}
					$k++;
				}
				$short_name = implode(",",$arr1);
				echo $short_name;
			?>
			</span>
		</div>
				
				
				
				
				
				
				
				
				 <a href="#"><img src="uploads/<?php echo $row['image']; ?>" alt="" width="300px"/></a>
				<?php
				$pieces = explode(" ", $row['long_description']);
				$final_words = implode(" ", array_splice($pieces, 0, 30));
				$final_words = $final_words.' ...';
			?>
			<?php echo $final_words; ?>
				
				<div class="readmore clear">
					<a href="news_details.php?id=<?php echo $row['news_id']; ?>">Read More</a>
				</div>
				
			</div>
			
			
			
			<?php
				}
			?>
			
		

<div class="pagination">
<?php 
echo $pagination; 
?>
</div>		
			
				

		</div>
		
		<?php include("sideber.php"); ?>
		
	</div>
	
	
	
	



	
	

	<?php include("footer.php"); ?>
</body>
</html>