<?php  

require_once 'dbConfig.php';


function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM user_accounts WHERE username = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$username])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"result"=> false,
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}

	return $response;
}

function insertNewAcc($pdo, $username, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {

		$sql = "INSERT INTO user_accounts (username, first_name, last_name, password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, $password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "An error occured with the query!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}

function getAllAccs($pdo) {
	$sql = "SELECT * FROM user_accounts";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}



function getAllUsers($pdo) {
	$sql = "SELECT * FROM architecture
			ORDER BY first_name ASC";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getUserByID($pdo, $user_id) {
	$sql = "SELECT * from architecture WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$user_id]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function searchForAUser($pdo, $searchQuery) {
	
	$sql = "SELECT * FROM architecture WHERE 
			CONCAT(first_name,last_name,gender,specialization,
				years_of_experience,date_added) 
			LIKE ?";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute(["%".$searchQuery."%"]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}



function insertNewUser($pdo, $first_name, $last_name, $gender, $specialization, $years_of_experience, $added_by) {
	$response = array();
	$sql = "INSERT INTO architecture
			(
				first_name,
				last_name,
				gender,
				specialization,
				years_of_experience,
				added_by
			)
			VALUES (?,?,?,?,?,?)
			";

$stmt = $pdo->prepare($sql);
$insertNewUser = $stmt->execute([$first_name, $last_name, $gender, $specialization, $years_of_experience, $added_by]);

if ($insertNewUser) {
	$findInsertedItemSQL = "SELECT * FROM architecture ORDER BY date_added DESC LIMIT 1";
	$stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
	$stmtfindInsertedItemSQL->execute();
	$getuserID = $stmtfindInsertedItemSQL->fetch();

	$insertAnActivityLog = insertAnActivityLog($pdo, "INSERT", $getuserID['user_id'], 
		$getuserID['first_name'], $getuserID['last_name'], 
		$getuserID['gender'], $getuserID['specialization'], $getuserID['years_of_experience'], 
		$_SESSION['username']);

	if ($insertAnActivityLog) {
		$response = array(
			"status" =>"200",
			"message"=>"User added successfully!"
		);
	}

	else {
		$response = array(
			"status" =>"400",
			"message"=>"Insertion of activity log failed!"
		);
	}
	
}

else {
	$response = array(
		"status" =>"400",
		"message"=>"Insertion of data failed!"
	);

}

return $response;
}


    


function editUser($pdo, $first_name, $last_name, $gender, $specialization, $years_of_experience, $last_updated, $last_updated_by, $user_id) {
    $response = array();

    $sql = "UPDATE architecture
            SET first_name = ?,
                last_name = ?,
                gender = ?,
                specialization = ?,
                years_of_experience = ?,
				last_updated = ?,
				last_updated_by = ?
			WHERE user_id = ?";

$stmt = $pdo->prepare($sql);
$editUser = $stmt->execute([$first_name, $last_name, $gender, $specialization, $years_of_experience, 
$last_updated, $last_updated_by, $user_id]);

if ($editUser) {

	$findInsertedItemSQL = "SELECT * FROM architecture WHERE user_id = ?";
	$stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
	$stmtfindInsertedItemSQL->execute([$user_id]);
	$getuserID = $stmtfindInsertedItemSQL->fetch(); 

	$insertAnActivityLog = insertAnActivityLog($pdo, "UPDATE", $getuserID['user_id'], 
		$getuserID['first_name'], $getuserID['last_name'], 
		$getuserID['gender'], $getuserID['specialization'], $getuserID['years_of_experience'],  $_SESSION['username']);

	if ($insertAnActivityLog) {

		$response = array(
			"status" =>"200",
			"message"=>"Updated the applicant successfully!"
		);
	}

	else {
		$response = array(
			"status" =>"400",
			"message"=>"Insertion of activity log failed!"
		);
	}

}

else {
	$response = array(
		"status" =>"400",
		"message"=>"An error has occured with the query!"
	);
}

return $response;

}

function deleteUser($pdo, $user_id) {
	$response = array();
	$sql = "SELECT * FROM architecture WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$user_id]);
	$getuserID = $stmt->fetch();

	$insertAnActivityLog = insertAnActivityLog($pdo, "DELETE", $getuserID['user_id'], 
		$getuserID['first_name'], $getuserID['last_name'], 
		$getuserID['gender'], $getuserID['specialization'], $getuserID['years_of_experience'],  $_SESSION['username']);

	if ($insertAnActivityLog) {
		$deleteSql = "DELETE FROM architecture WHERE user_id = ?";
		$deleteStmt = $pdo->prepare($deleteSql);
		$deleteQuery = $deleteStmt->execute([$user_id]);

		if ($deleteQuery) {
			$response = array(
				"status" =>"200",
				"message"=>"Deleted the applicant successfully!"
			);
		}
		else {
			$response = array(
				"status" =>"400",
				"message"=>"Insertion of activity log failed!"
			);
		}
	}
	else {
		$response = array(
			"status" =>"400",
			"message"=>"An error has occured with the query!"
		);
	}

	return $response;
}



function insertAnActivityLog($pdo, $operation, $user_id, $first_name, 
		$last_name, $gender, $specialization, $years_of_experience, $username) {

	$sql = "INSERT INTO activity_logs (operation, user_id, first_name, 
		last_name, gender, specialization, years_of_experience, username) VALUES(?,?,?,?,?,?,?,?)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$operation, $user_id, $first_name, 
		$last_name, $gender, $specialization, $years_of_experience, $username]);

	if ($executeQuery) {
		return true;
	}

}

function getAllActivityLogs($pdo) {
	$sql = "SELECT * FROM activity_logs 
			ORDER BY date_added DESC";
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		return $stmt->fetchAll();
	}
}
