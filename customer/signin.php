<?php
session_start();
include_once('functions.php');

$userdata = new DB_con();

if (isset($_POST['login'])) {
    $id_phone = $_POST['id_phone'];
    $password = $_POST['password'];

    $result = $userdata->signin($id_phone, $id_phone);

    if ($result) {
        $num = $result->fetch_assoc();

        if ($num) {
            $hashed_password = $num['password'];

            // Verify the entered password against the hashed password from the database
            if (password_verify($password, $hashed_password)) {
                $_SESSION['id_phone'] = $num['id_phone'];
                $_SESSION['first_name'] = $num['first_name'];
                $_SESSION['last_name'] = $num['last_name'];
                $_SESSION['email'] = $num['email'];
                $_SESSION['Point'] = $num['Point'];
                $_SESSION['updated_at'] = $num['updated_at'];
                $_SESSION['profile_extension'] = $num['profile_extension'];
                echo "<script>alert('Login Successful!');</script>";
                echo "<script>window.location.href='welcome.php'</script>";
                exit;
            } else {
                echo "<script>alert('Incorrect password. Please try again.');</script>";
            }
        } else {
            echo "<script>alert('User not found. Please try again.');</script>";
        }
    } else {
        echo "<script>alert('An error occurred while logging in. Please try again.');</script>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
</head>
<body>
    
    <div class="container">
        <h1 class="mt-5">Login Page</h1>
        <hr>
        <form method="post">
            <div class="mb-3">
                <label for="Phon" class="form-label">Phone</label>
                <input type="text" class="form-control" id="id_phone" name="id_phone">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" name="login" class="btn btn-success">Login</button>
            <a href="index.php" class="btn btn-primary">Go to Register</a>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</body>
</html>