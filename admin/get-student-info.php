<?php
include('../includes/pdoconfig.php');

function fetchUserData($id) {
    global $DB_con;
    
    $stmt = $DB_con->prepare("SELECT * FROM userregistration WHERE regNo = :id");
    $stmt->execute(array(':id' => $id));

    $userData = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $userData[] = array(
            'fname' => htmlentities($row['firstName']),
	        'mname' => htmlentities($row['middleName']),
            'lname' => htmlentities($row['lastName']),
            'gender' => htmlentities($row['gender']),
            'email' => htmlentities($row['email']),
            'contact' => htmlentities($row['contactNo']),
            'course' => htmlentities($row['course']),
        );
    }
    
    return $userData;
}


if (!empty($_POST["regNo"])) {
    $id = $_POST["regNo"];
    $userData = fetchUserData($id);
    echo json_encode($userData);
}
?>