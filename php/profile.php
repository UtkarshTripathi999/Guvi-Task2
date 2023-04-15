<?php
// start the session
session_start();

// check if the user is logged in
if(!isset($_SESSION['user_id'])) {
	header("Location: login.php");
	exit();
}

// connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myDB";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// retrieve the user's information from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	$name = $row['name'];
	$age = $row['age'];
	$dob = $row['dob'];
	$contact = $row['contact'];
} else {
	echo "Error: could not retrieve user information.";
	exit();
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Profile Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="profile-form">
		<h2>Welcome, <?php echo $name; ?>!</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<label>Age:</label>
			<input type="number" name="age" value="<?php echo $age; ?>" required>
			<label>Date of Birth:</label>
			<input type="date" name="dob" value="<?php echo $dob; ?>" required>
			<label>Contact:</label>
			<input type="tel" name="contact" value="<?php echo $contact; ?>" required>
			<button type="submit" name="update-btn">Update Profile</button>
		</form>
		<p><a href="logout.php">Logout</a></p>
	</div>
</body>
</html>

<?php
// check if the update button is clicked
if(isset($_POST['update-btn'])) {
	// connect to the database
	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}

	// get the user inputs
	$age = mysqli_real_escape_string($conn, $_POST['age']);
	$dob = mysqli_real_escape_string($conn, $_POST['dob']);
	$contact = mysqli_real_escape_string($conn, $_POST['contact']);

	// update the user's information in the database
	$sql = "UPDATE users SET age='$age', dob='$dob', contact='$contact' WHERE id='$user_id'";
	$result = mysqli_query($conn, $sql);

	if ($result) {
		echo "<script>alert('Profile updated successfully.')</script>";
	} else {
		echo "<script>alert('Error: could not update profile.')</script>";
	}

	mysqli_close($conn);
}
?>
