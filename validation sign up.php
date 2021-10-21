<?php
session_start();
include "connect.php";

?>


<?php 
session_start(); 
include "connect.php";

if (isset($_POST['uname']) && isset($_POST['E-mail adress']) && isset($_POST['password'])) {

	function validate($data){
       $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	$uname = validate($_POST['uname']);
    $mail = validate($_POST['E-mail adress']);
	$pass = validate($_POST['password']);

	if (empty($uname)) {
		header("Location: index.php?error=User Name is required");
	    exit();
	}else if(empty($mail)){
        header("Location: index.php?error=Password is required");
	    exit();
    }else if(empty($pass)){
        header("Location: index.php?error=Password is required");
	    exit();
	}else{
		// hashing the password
        $pass = md5($pass);

        
		$sql = "SELECT * FROM users WHERE user_name='$uname' AND E-mail adress='$mail' AND password='$pass'";

		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) === 1) {
			$row = mysqli_fetch_assoc($result);
            if ($row['user_name'] === $uname && $row['E-mail adress'] === $mail && $row['password'] === $pass) {
            	$_SESSION['user_name'] = $row['user_name'];
            	$_SESSION['name'] = $row['name'];
            	$_SESSION['id'] = $row['id'];
            	header("Location: home.php");
		        exit();
            }else{
				header("Location: signup.php?error=Incorect User name or E-mail adress or password");
		        exit();
			}
		}else{
			header("Location: signup.php?error=Incorect User name or E-mail adress or password");
	        exit();
		}
	}
	
}else{
	header("Location: signup.php");
	exit();
}