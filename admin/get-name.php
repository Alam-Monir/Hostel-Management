<?php
    include('../includes/pdoconfig.php');
    if(!empty($_POST["regNo"])) {	
    $id=$_POST['regNo'];
    $stmt = $DB_con->prepare("SELECT * FROM userregistration WHERE firstName = :id");
    $stmt->execute(array(':id' => $id));
    ?>
    <?php
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
    ?>
    <?php echo htmlentities($row['regNo']); ?>
    <?php
    }
}



if(!empty($_POST["rid"])) {	
    $id=$_POST['rid'];
    $stmt = $DB_con->prepare("SELECT * FROM userregistration WHERE firstName = :id");
    $stmt->execute(array(':id' => $id));
    ?>
    <?php
    while($row=$stmt->fetch(PDO::FETCH_ASSOC))
    {
    ?>
    <?php echo htmlentities($row['firstName']); ?>
    <?php
    }
}

?>