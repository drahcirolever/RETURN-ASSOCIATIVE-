<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>

<?php include 'navbar.php'; ?>
	<div class="searchForm">
		<form action="index.php" method="GET">
			<p>
				<input type="text" name="searchQuery" placeholder="Search here">
				<input type="submit" name="searchBtn" value="Search">
				<h3><a href="index.php">Search Again</a></h3>	
			</p>
		</form>
	</div>

	<?php  
	if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

		if ($_SESSION['status'] == "200") {
			echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
		}

		else {
			echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>";	
		}

	}
	unset($_SESSION['message']);
	unset($_SESSION['status']);
	?>
	<p><a href="insert.php">Insert New User</a></p>

	<table style="width:100%; margin-top: 20px;">
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Gender</th>
			<th>Specialization</th>
			<th>Years of Experience</th>
			<th>Date Added</th>
			<th>Added By</th>
			<th>Last Updated</th>
			<th>Last Updated By</th>
			<th>Action</th>
		</tr>

		<?php if (!isset($_GET['searchBtn'])) { ?>
			<?php $getAllUsers = getAllUsers($pdo); ?>
				<?php foreach ($getAllUsers as $row) { ?>
					<tr>
						<td><?php echo $row['first_name']; ?></td>
						<td><?php echo $row['last_name']; ?></td>
						<td><?php echo $row['gender']; ?></td>
						<td><?php echo $row['specialization']; ?></td>
						<td><?php echo $row['years_of_experience']; ?></td>
						<td><?php echo $row['date_added']; ?></td>
						<td><?php echo $row['added_by']; ?></td>
						<td><?php echo $row['last_updated']; ?></td>
						<td><?php echo $row['last_updated_by']; ?></td>
						<td>
							<a href="edit.php?user_id=<?php echo $row['user_id']; ?>">Edit</a>
							<a href="delete.php?user_id=<?php echo $row['user_id']; ?>">Delete</a>
						</td>
					</tr>
			<?php } ?>
			
		<?php } else { ?>
			<?php $searchForAUser =  searchForAUser($pdo, $_GET['searchQuery']); ?>
				<?php foreach ($searchForAUser as $row) { ?>
					<tr>
						<td><?php echo $row['first_name']; ?></td>
						<td><?php echo $row['last_name']; ?></td>
						<td><?php echo $row['gender']; ?></td>
						<td><?php echo $row['specialization']; ?></td>
						<td><?php echo $row['years_of_experience']; ?></td>
						<td><?php echo $row['date_added']; ?></td>
						<td><?php echo $row['added_by']; ?></td>
						<td><?php echo $row['last_updated']; ?></td>
						<td><?php echo $row['last_updated_by']; ?></td>
						<td>
							<a href="edit.php?user_id=<?php echo $row['user_id']; ?>">Edit</a>
							<a href="delete.php?user_id=<?php echo $row['user_id']; ?>">Delete</a>
						</td>
					</tr>
				<?php } ?>
		<?php } ?>	
		
	</table>
</body>
</html>