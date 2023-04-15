<!DOCTYPE html>
<html>
<head>
	<title>Signup Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="signup-form">
		<h2>Signup</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="text" name="username" placeholder="Username" required>
			<input type="email" name="email" placeholder="Email" required>
			<input type="password" name="password" placeholder="Password" required>
			<button type="submit" name="signup-btn">Signup</button>
		</form>
		<p>Already have an account? <a href="login.php">Login here</a></p>
	</div>
</body>
</html>

<?php
// check if the signup button is clicked
if(isset($_POST['signup-btn'])) {
	// connect to the database
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "myDB";

	$conn = mysqli_connect($servername, $username, $password, $dbname);

	if (!$conn) {
	  die("Connection failed: " . mysqli_connect_error());
	}

	// get the user inputs
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	// check if the username or email already exists
	$sql = "SELECT * FROM users WHERE username='$username' OR email='$email'";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		echo "<script>alert('Username or email already exists.')</script>";
	} else {
		// insert the user data into the database
		$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
		if (mysqli_query($conn, $sql)) {
			header("Location: profile.php");
		} else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
	}

	mysqli_close($conn);
}
?>
