<?php
        include '../db.inc.php';
?>

<?php
	$username = $_POST['name'];
	$email = $_POST['email'];
	$password = password_hash($_POST['password'],PASSWORD_DEFAULT);

	$queryadduser = "INSERT INTO user (name, email, sms, password) VALUES ('$username', '$email', '0', '$password');";
        $adduser = mysqli_query($db, $queryadduser);

	$queryadduserstrikes = "INSERT INTO current_strikes (userid) SELECT id FROM user WHERE user.name LIKE '$username';";
        $adduserstrikes = mysqli_query($db, $queryadduserstrikes);
	
	header("Location: https://$_SERVER[HTTP_HOST]/admin");
?>
