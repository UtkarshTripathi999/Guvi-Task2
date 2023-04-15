<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="login-form">
		<h2>Login</h2>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<input type="email" name="email" placeholder="Email" required>
			<input type="password" name="password" placeholder="Password" required>
			<button type="submit" name="login-btn">Login</button>
		</form>
		<p>Don't have an account? <a href="signup.php">Signup here</a></p>
	</div>
</body>
</html>

<?php
// check if the login button is clicked
if(isset($_POST['login-btn'])) {
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
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	// check if the email and password match
	$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		session_start();
		$_SESSION['user_id'] = $row['id'];
		header("Location: profile.php");
	} else {
		echo "<script>alert('Incorrect email or password.')</script>";
	}

	mysqli_close($conn);
}
?>
