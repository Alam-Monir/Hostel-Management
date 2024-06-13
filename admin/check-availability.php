<?php
// email validation
    require_once("../includes/dbconn.php");
    if(!empty($_POST["emailid"])) {
        $email= $_POST["emailid"];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {

            echo "error : You did not enter a valid email.";
        } else {
            $result ="SELECT count(*) FROM userRegistration WHERE email=?";
            $stmt = $mysqli->prepare($result);
            $stmt->bind_param('s',$email);
            $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    if($count>0){
    echo "<span style='color:red'> Email already exist .</span>";
        } else {
            echo "<span style='color:green'> Email available for registration .</span>";
        }
     }
    }
// password change
    if(!empty($_POST["oldpassword"])) {
    $pass=$_POST["oldpassword"];
    $result ="SELECT password FROM userregistration WHERE password=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('s',$pass);
    $stmt->execute();
    $stmt -> bind_result($result);
    $stmt -> fetch();
    $opass=$result;
    if($opass==$pass) 
    echo "<span style='color:green'> Password  matched.</span>";
    else echo "<span style='color:red'>Password doesnot match!</span>";
    }

// check availibility
    if(!empty($_POST["roomno"])) {
    $roomno=$_POST["roomno"];
    //new
    $seat_count = "SELECT seater FROM rooms WHERE room_no =?";
    $stmp = $mysqli->prepare($seat_count);
    $stmp->bind_param('i',$roomno);
    $stmp->execute();
    $stmp->bind_result($count_seats);
    $stmp->fetch();
    $stmp->close();
    
    
    //actual
    $result ="SELECT count(*) FROM registration WHERE roomno=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i',$roomno);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    $left = $count_seats-$count;
    if($count!=0 && $count>=$count_seats)
    echo "<span style='color:red'>Seats already full.</span>";
    else
        
        echo "<span style='color:green'>$left Seats are Available</span>";
    }
?>