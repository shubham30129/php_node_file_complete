<?php
$db = mysqli_connect('localhost', 'root', '' ,'nodephp');




$d=$_REQUEST["state_id"];
// $d="test";
$res = $db->query("select city from city where sid=".$d);
        echo "<option>Select City</option>";
    while ($d =$res->fetch_array()) {

         echo "<option value=$d[0]>$d[0]</option>";
     }
echo $res;

?>