<?php
require_once "./_partials/_dbconnect.php";
require "./_partials/nav.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form class="mx-5 my-5" action="" method="POST">
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Username</span>
            <input type="text" class="form-control" name="luname" required>
        </div>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Password</span>
            <input type="password" class="form-control" name="lpas" required>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="submit" name="submit">Login</button>
        </div>
    </form>
    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <h5>Not Registered?<a href="./register.php">Register here</a></h5>
    </div>
</body>
<?php
if (isset($_POST['submit'])) {
    if ((isset($_POST['luname'])) && (isset($_POST['lpas']))) {
        $u_name = postres($conn, 'luname');
        $u_name = strtolower($u_name);
        $pass = postres($conn, 'lpas');
        // echo "$f_name $m_name $l_name $u_name $pass $cpass";
        if ($pass) {
            $p_re = "TheP_rePass";
            $p_os = "TheP_osPass";
            $ppass = $p_re . $pass . $p_os;
            $h_pass = hash('md5', $ppass);
            // echo $h_pass;
            $query = "SELECT * FROM `reg1001` WHERE `u_nam` = '$u_name'";
            $result = mysqli_query($conn, $query);
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                $un = $row['u_nam'];
                $pas = $row['p_ass'];
                $fname = $row['f_nam'];
                $lname = $row['l_nam'];
                $name = $fname . " " . $lname;
                if (($h_pass == $pas) && ($un == $u_name)) {
                    session_start();
                    $_SESSION['uname'] = $un;
                    $_SESSION['pass'] = $pas;
                    $_SESSION['name'] = $name;
                    $_SESSION['fname'] = $name;
                    header("location:welcome.php");
                } elseif ($h_pass != $pas) {
                    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Failed!</strong> Password Dosen\'t Match.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    echo $alert;
                    // echo "abc";
                } else
                    echo "Error - " . mysqli_error($conn);
            } else {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Failed!</strong> Entry not found for the Username.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                echo $alert;
            }
        }
    }
}


function postres($conn, $var)
{
    return mysqli_real_escape_string($conn, $_POST[$var]);
}

?>

</html>