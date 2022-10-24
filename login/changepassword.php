<?php
require_once "./_partials/_dbconnect.php";
require "./_partials/nav.php";
session_start();
if ((isset($_SESSION['uname'])) && (isset($_SESSION['pass']))) {
    $un = $_SESSION['uname'];
    // echo "Session Set";


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
</head>

<body>
    <form class="mx-5 my-5" action="" method="POST">
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Old Password</span>
            <input type="password" class="form-control" name="opas" required>
        </div>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">New Password</span>
            <input type="password" class="form-control" name="npas" required>
        </div>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Confirm New Password</span>
            <input type="password" class="form-control" name="cnpas" required>
        </div>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            <button type="submit" class="btn btn-primary btn-lg px-4 gap-3" value="submit" name="submit">Submit</button>
        </div>
    </form>
    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <a href="./welcome.php"><button type="cancel" class="btn btn-primary btn-lg px-4 gap-3">Cancel</button></a>
    </div>
</body>
<?php

?>
<?php
if (isset($_POST['submit'])) {
    $pass = postres($conn, 'opas');
    $pas = $_SESSION['pass'];
    $p_re = "TheP_rePass";
    $p_os = "TheP_osPass";
    $ppass = $p_re . $pass . $p_os;
    $h_pass = hash('md5', $ppass);
    if ($pas == $h_pass) {
        $npas = postres($conn, 'npas');
        $cnpas = postres($conn, 'cnpas');
        if ($npas == $cnpas) {
            $snpas = str_split($npas);
            $pcount = count($snpas);
            if ($pcount > 8) {
                $p_re = "TheP_rePass";
                $p_os = "TheP_osPass";
                $ppass = $p_re . $npas . $p_os;
                $h_npas = hash('md5', $ppass);
                $query = "UPDATE `reg1001` SET `p_ass` = '$h_npas' WHERE `reg1001`.`u_nam` = '$un'";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    header("location:index.php");
                    session_unset();
                } else {

                    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Failed!</strong>Failed to Change Password, Please try after some time.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    echo $alert;
                    exit;
                }
            } else {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Failed!</strong> Password must be greater than 8 Characters.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                echo $alert;
                exit;
            }
        } else {
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Failed!</strong> Password dosen\'t Match.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            echo $alert;
            exit;
        }
    } else {
        $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Failed!</strong> Password dosen\'t Match for Given User.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        echo $alert;
        exit;
    }
}
} else {
    header("location:index.php");
}

function postres($conn, $var)
{
    return mysqli_real_escape_string($conn, $_POST[$var]);
}
?>

</html>