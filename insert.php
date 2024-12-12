<?php


 include("dbConnection.php");

  $data = $_POST["user_data"];
 
 $resultArr = ["status"=>false,"error"=>null, "user"=>null];
if (isset($_POST["insert"])) {
    
    $user_name = trim($data["username"]);
    $number = trim($data["user_number"]);
 

   if (!(empty($user_name)) && !(empty($number))  ) {


    $data["fianic_number"] = fibNumber($number);
    $fianic_number = $data["fianic_number"];



    $sql = "INSERT INTO fiacoo (username, user_number, fiacon_number) VALUES (?, ?, ?);";

    $statement = $dbh->prepare($sql);

    if  ($statement->execute([$user_name, $number, $fianic_number])) {
        $resultArr["status"] = true;
        $resultArr["user"] = $data;
        echo json_encode($resultArr);
    }
   


   }
}


 if ($resultArr["status"]===false) {
  $resultArr["user"] = $data;
  echo json_encode($resultArr);
}

$dhb = null;
$statement = null;
exit();

function fibNumber($n) {
    if ($n <= 1) {
        return $n;
    }

    return fibNumber($n - 1) + fibNumber($n - 2);
}


?>