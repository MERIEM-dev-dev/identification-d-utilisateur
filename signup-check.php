<?php 
session_start(); 
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password']) 
//isset() vérifie si une variable est définie, 
//ce qui signifie qu'elle doit être déclarée et n'est pas NULL.
    && isset($_POST['name']) && isset($_POST['re_password'])) {

	function validate($data){
       $data = trim($data); 
	   //trim($data) bande de caractères inutiles (en sus de l'espace, tabulation, saut de ligne) 
	   //de l'utilisateur des données d'entrée (avec le PHP fonction trim ()).
	   $data = stripslashes($data); //stripslashes($data) va supprimer les barres obliques inverses () 
	   //de l'utilisateur des données d'entrée (avec le PHP stripslashes ()).
	   $data = htmlspecialchars($data); //htmlspecialchars($data) convertit les caractères spéciaux en entités HTML.
	   return $data;
	}

	$uname = validate($_POST['uname']);
	$pass = validate($_POST['password']);

	$re_pass = validate($_POST['re_password']);
	$name = validate($_POST['name']);

	$user_data = 'uname='. $uname. '&name='. $name;


	if (empty($uname)) { //empty : vide
		header("Location: signup.php?error=User Name is required&$user_data");
	}else if(empty($pass)){
        header("Location: signup.php?error=Password is required&$user_data");
	}
	else if(empty($re_pass)){
        header("Location: signup.php?error=Re Password is required&$user_data");
	}

	else if(empty($name)){
        header("Location: signup.php?error=Name is required&$user_data");
	}

	else if($pass !== $re_pass){
        header("Location: signup.php?error=The confirmation password  does not match&$user_data");
	}

	else{

		// hashing the password
        $pass = md5($pass);

	    $sql = "SELECT * FROM users WHERE user_name='$uname' ";
		$result = mysqli_query($conn, $sql);  //add to database 
		//mysqli::query -- mysqli_query — Exécute une requête sur la base de données

		if (mysqli_num_rows($result) > 0) { //La fonction mysqli_num_rows() 
			//renvoie le nombre de lignes dans un jeu de résultats.
			header("Location: signup.php?error=The username is taken try another&$user_data");
		}else {
           $sql2 = "INSERT INTO users(user_name, password, name) VALUES('$uname', '$pass', '$name')";
           $result2 = mysqli_query($conn, $sql2);
           if ($result2) {
           	 header("Location: signup.php?success=Your account has been created successfully");
           }else {
	           	header("Location: signup.php?error=unknown error occurred&$user_data");
           }
		}
	}
	
}else{
	header("Location: signup.php");
}