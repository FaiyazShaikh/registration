<?php
require "./_partials/nav.php";
// echo session_status();
session_start();
if((isset($_SESSION['uname']))&&(isset($_SESSION['pass']))){
    


// $fname = $row['f_nam'];

$M1 = "<br> You are loggedin as " . $_SESSION['uname'] . "<br>";
$M2 = "If you Log out You have no Longer Access to this Page <br> You Can Logout from below button";
}

else{
    header("location:index.php");
    // echo "Failed";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="px-4 py-5 my-5 text-center">
        <!-- <img class="d-block mx-auto mb-4" src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
        <h1 class="display-5 fw-bold">Hey,  <?php echo $_SESSION['fname'] ?> Welcome.</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">
                <?php echo $M1;
                echo $M2 ?>
            </p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="./logout.php"><button type="button" class="btn btn-primary btn-lg px-4 gap-3"> Logout</button></a>
                <a href="./changepassword.php"><button type="button" class="btn btn-primary btn-lg px-4 gap-3">Change Password</button></a>
            </div>
        </div>
    </div>
</body>

</html>