<?php
ob_start();
session_start();
if($_SESSION['name']!='admin')
{
header('location: login.php');
}
include("../config.php");
?>

<?php include("header.php"); ?>
<!---Content Part --->
<div id="content">

<h2>View  All News</h2>

<table class="table table-responsive table-hover" width="100%">
	<tr style="background-color: #0D7B7B;color: #FFF;height: 40px;">
		<th width="5%" style="text-align: center; border-right: 1px solid #FFF;"><b>Serial</b></th>
		<th width="50%" style="text-align: center; border-right: 1px solid #FFF;"><b>News Title</b></th>
		<th width="13%" style="text-align: center; border-right: 1px solid #FFF;"><b>Faculty</b></th>
		<th width="12%" style="text-align: center; border-right: 1px solid #FFF;"><b>Category</b></th>
		<th width="20%" style="text-align: center; ">Action</th>
	</tr>

	
	<?php
		$i = 0;
		$statement = $db->prepare("SELECT * FROM news ORDER BY news_id DESC");
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach ($result as $row) {
		$i++;
    ?>

		<tr>
			<td><?php echo $i; ?></td>
			<td style="text-align:center"><?php echo $row['title']; ?></td>
			<td>
			<?php
				$statement1 = $db->prepare("SELECT * FROM faculty WHERE faculty_id=?");
				$statement1->execute(array($row['faculty_id']));
				$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
				foreach ($result1 as $row1) {
					echo $row1['short_name'];
				}
			?>
	</td>
			<td>
				<?php
					$statement1 = $db->prepare("SELECT * FROM category WHERE category_id=?");
					$statement1->execute(array($row['category_id']));
					$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
					foreach ($result1 as $row1) {
						echo $row1['cat_name'];
					}
				?>
			</td>
			
			<td>
				<a class="fancybox" href="#inline<?php echo $i; ?>">View</a>
				<div id="inline<?php echo $i; ?>" style="width:700px;display: none;">
				<h3 style="border-bottom:2px solid #808080;margin-bottom:10px;">View All Data</h3>
				<p>
				<form action="" method="post">
						<table>
						<tr>
							<td><b>Title</b></td>
						</tr>
					
						<tr>
							<td><?php echo $row['title']; ?></td>
							</tr>
						<tr>
							<td><b>Description</b></td>
						</tr>
						<tr>
							<td><?php echo $row['long_description']; ?></td>
						</tr>
						<tr>
							<td><b>Featured Image</b>
							</br>
							</td>
							
						</tr>
						<tr>
							<td><img src="../uploads/<?php echo $row['image']; ?>" alt=""></td>
						</tr>
						
						<tr>
							<td><b>Faculty</b></td>
						</tr>
						<tr>
							<td>
								<?php
									$statement1 = $db->prepare("SELECT * FROM faculty WHERE faculty_id=?");
									$statement1->execute(array($row['faculty_id']));
									$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result1 as $row1) {
										echo $row1['short_name'];
									}
								?>
							</td>
						</tr>
						
						<tr>
							<td><b>Category</b></td>
						</tr>
						<tr>
							<td>
								<?php
									$statement1 = $db->prepare("SELECT * FROM category WHERE category_id=?");
									$statement1->execute(array($row['category_id']));
									$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
									foreach ($result1 as $row1) {
										echo $row1['cat_name'];
									}
								?>
							</td>
						</tr>

						</table>
						</form>
					</p>
				</div>
			
			&nbsp;|&nbsp;
			<a href="edit_news.php?id=<?php echo $row['news_id']; ?>">Edit</a>
			&nbsp;|&nbsp;
			<a onclick='return confirmDelete();' href="delete_news.php?id=<?php echo $row['news_id']; ?>">Delete</a></td>
		</td>
		</tr>

		<?php
}
?>


</table>
</div>

<?php include("footer.php"); ?>	