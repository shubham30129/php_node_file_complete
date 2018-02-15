<?php
/**
 * Created by PhpStorm.
 * User: lcom148-two
 * Date: 2/14/2018
 * Time: 3:33 PM
 */
?>
<?php
$db = mysqli_connect('localhost', 'root', '' ,'nodephp');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</head>
<body>

<div class="container">
    <h2></h2>
    <form action="" method="post">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" id="fname" placeholder="Enter First Name" name="fname" accept="text" required>
        </div>
        <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="text" class="form-control" id="lname" placeholder="Enter Last Name" name="lname" required>
        </div>
        <input type="submit" name="login" class="btn btn-default" id="btn-login" value="Login">
    </form>
</div>

</body>
</html>
<?php
if(isset($_REQUEST['login']))
{
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    echo $fname;
    echo $lname;
    $qry="select * from registration where fname='$fname' &&  lname='$lname'";
    $result= $db->query($qry);
    if($result->num_rows>0)
    {
        session_start();
        $_SESSION['uname']=$fname;
        header("location:index2.php");
    }


}
?>

