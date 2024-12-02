<?php  

require_once 'dbConfig.php';
require_once 'models.php';


if (isset($_POST['insertNewAccBtn'])) {
	$username = trim($_POST['username']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($first_name) && !empty($last_name) && 
		!empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			$insertQuery = insertNewAcc($pdo, $username, $first_name, $last_name, 
				password_hash($password, PASSWORD_DEFAULT));

			if ($insertQuery['status'] == '200') {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../login.php");
			}

			else {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../register.php");
			}

		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = "400";
			header("Location: ../register.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = "400";
		header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = checkIfUserExists($pdo, $username);

		if ($loginQuery['status'] == '200') {
			$usernameFromDB = $loginQuery['userInfoArray']['username'];
			$passwordFromDB = $loginQuery['userInfoArray']['password'];

			if (password_verify($password, $passwordFromDB)) {
				$_SESSION['username'] = $usernameFromDB;
				header("Location: ../index.php");
			}
		}

		else {
			$_SESSION['message'] = $loginQuery['message'];
			$_SESSION['status'] = $loginQuery['status'];
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure no input fields are empty";
		$_SESSION['status'] = "400";
		header("Location: ../login.php");
	}
}

if (isset($_GET['logoutUserBtn'])) {
	unset($_SESSION['username']);
	header("Location: ../login.php");
}	


if (isset($_POST['insertUserBtn'])) {
	 $first_name = trim($_POST['first_name']); 
	 $last_name = trim($_POST['last_name']); 
	 $gender = trim($_POST['gender']);
	 $specialization = trim($_POST['specialization']); 
	 $years_of_experience = trim($_POST['years_of_experience']);
    if (!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($specialization) && !empty($years_of_experience)){
        $insertUser = insertNewUser($pdo,$_POST['first_name'], $_POST['last_name'],  $_POST['gender'], $_POST['specialization'], $_POST['years_of_experience'], $_SESSION['username']);

                if ($insertUser['status' == '200']) {
                    $_SESSION['message'] = $insertUser['message'];
                    $_SESSION['status'] = $insertUser['status'];
                    header("Location: ../index.php");
                }
                else {
                    $_SESSION['message'] = $insertUser['message'];
                    $_SESSION['status'] = $insertUser['status'];
                    header("Location: ../index.php");
                }
    }
    else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = "400";
		header("Location: ../index.php");
    }
}

if (isset($_POST['editUserBtn'])) {

	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$gender = trim($_POST['gender']);
	$specialization = trim($_POST['specialization']);
    $years_of_experience = trim($_POST['years_of_experience']);
	$date = date('Y-m-d H:i:s');

	if (!empty($first_name) && !empty($last_name) && !empty($gender) &&!empty($specialization) && !empty($years_of_experience)){

		$editUser = editUser($pdo, $first_name, $last_name, $gender, $specialization, $years_of_experience, $date, $_SESSION['username'], $_GET['user_id']);

		$_SESSION['message'] = $editUser['message'];
		$_SESSION['status'] = $editUser['status'];
		header("Location: ../index.php");
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}

}


if (isset($_POST['deleteUserBtn'])) {
	$deleteUser = deleteUser($pdo,$_GET['user_id']);

	if ($deleteUser['status' == '200']) {
		$_SESSION['message'] = $deleteUser['message'];
		$_SESSION['status'] = $deleteUser['status'];
		header("Location: ../index.php");
	}
	else {
		$_SESSION['message'] = $deleteUser['message'];
		$_SESSION['status'] = $deleteUser['status'];
		header("Location: ../index.php");
	}
}

if (isset($_GET['logoutUserBtn'])) {
	unset($_SESSION['username']);
	header("Location: ../login.php");
}
