<?php
include "./_partials/_dbconnect.php";
include "./_partials/nav.php";
$title = "Registeration Form";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?></title>
</head>

<body>
    <form class="mx-5 my-5" action="" method="POST">
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">First Name</span>
            <input type="text" class="form-control" name="fname" required>
        </div>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Middle Name</span>
            <input type="text" class="form-control" name="mname">
        </div>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Last name</span>
            <input type="text" class="form-control" name="lname" required>
        </div>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Username</span>
            <input type="text" class="form-control" name="uname" required>
        </div>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Password</span>
            <input type="password" class="form-control" name="pas" required>
        </div>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Confirm Password</span>
            <input type="password" class="form-control" name="cpas" required>
        </div>
        <div class="input-group input-group-sm mb-3">
            <span class="input-group-text" id="inputGroup-sizing-sm">Profile Photo</span>
            <input type="file" class="form-control" name="pphoto">
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-primary" type="submit" name="submit">Register</button>
        </div>
    </form>
    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <h5>Already Registered?<a href="./index.php">Login here</a></h4>
    </div>
</body>
<?php
if (isset($_POST['submit'])) {
    if ((isset($_POST['fname'])) && (isset($_POST['lname'])) && (isset($_POST['uname'])) &&  (isset($_POST['pas'])) && (isset($_POST['cpas']))) {
        $f_name = postres($conn, 'fname');
        $m_name = postres($conn, 'mname');
        $l_name = postres($conn, 'lname');
        $u_name = postres($conn, 'uname');
        $u_name = strtolower($u_name);
        $pass = postres($conn, 'pas');
        $cpass = postres($conn, 'cpas');
        $pphoto = $_POST['pphoto'];
        if ($pass == $cpass) {
            $spas = str_split($pass);
            $sun = str_split($u_name);
            $pcount = count($spas);
            $ucount = count($sun);
            if (($pcount >= 8) && ($ucount > 5)) {
                $p_re = "TheP_rePass";
                $p_os = "TheP_osPass";
                $ppass = $p_re . $pass . $p_os;
                $h_pass = hash('md5', $ppass);
                // echo $hpass;
                $query = "INSERT INTO `reg1001` (`f_nam`, `m_nam`, `l_nam`, `u_nam`, `p_ass`, `p_photo`) VALUES ('$f_name', '$m_name', '$l_name', '$u_name', '$h_pass', '$pphoto')";
                $result = mysqli_query($conn, $query);
                if ($result) {
                    $alert = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Registration Success.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    echo $alert;
                } elseif (mysqli_error($conn) == "Duplicate entry '$u_name' for key 'u_nam'") {
                    $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Failed!</strong> Username is already taken.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                    echo $alert;
                }
            } elseif (($ucount <= 5) && ($pcount < 8)) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Failed!</strong> Username must be greater than 5 Character and Password greater than 8.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                echo $alert;
            } elseif ($ucount <= 5) {
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Failed!</strong> Username must be greater than 5 Character.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
                echo $alert;
            } else
                $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Failed!</strong> Enter Strong Password.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            echo $alert;
        } else {
            $alert = '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Failed!</strong> Password dosen\'t Match.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            echo $alert;
        }
    }
}

function postres($conn, $var)
{
    return mysqli_real_escape_string($conn, $_POST[$var]);
}
?>

</html>