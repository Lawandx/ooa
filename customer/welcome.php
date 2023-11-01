<?php
include_once('functions.php');
$userdata = new DB_con();
session_start();

if ($_SESSION['id_phone'] == "") {
    header("location: signin.php");
} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Welcome Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <style>
            body {
                background-color: #f2f2f2;
                font-family: Arial, sans-serif;
                text-align: center;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .container {
                background-color: #fff;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                text-align: left;
                max-width: 400px;
                margin: auto;
            }

            h1 {
                font-size: 24px;
                margin: 10px 0;
            }

            h3 {
                font-size: 18px;
                margin: 10px 0;
            }

            .profile-image {
                width: 300px;
                height: 300px;
                height: auto;
                border-radius: 50%;
                /* Make the image a circle */
                margin-top: 10px;
                /* Adjusted margin */
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-label {
                font-weight: bold;
            }

            .form-control {
                width: 100%;
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .btn-upload {
                background-color: #007BFF;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.3s;
            }

            .btn-upload:hover {
                background-color: #0056b3;
            }

            .btn-logout {
                margin-top: 20px;
            }

            .file-input-wrapper {
                display: flex;
                justify-content: space-between;
            }

            .file-input {
                position: absolute;
                top: 0;
                left: 0;
                width: 100px;
                height: 100%;
                opacity: 0;
                cursor: pointer;
            }

            .file-input-label {
                background-color: #007BFF;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                width: 100px;
            }

            .file-input-label:hover {
                background-color: #0056b3;
            }

            .center-image {
                display: block;
                margin: 0 auto;
            }
            .btn-wrapper {
            display: flex;
            justify-content: space-between;
            
            align-items: center;
        }
    </style>
        </style>
    </head>

    <body>
        <?php
        $profileImage = $userdata->getUserProfileImage($_SESSION['id_phone']);
        ?>
        <div class="container">

            <!-- Display the user's profile image at the top -->
            <img src="<?php echo $profileImage; ?>" alt="Profile Image" class="profile-image center-image" />

            <h1>Welcome <?php echo $_SESSION['first_name'], ' ', $_SESSION['last_name']; ?></h1>
            <h3>Email: <?php echo $_SESSION['email'] ?></h3>
            <h3>Point: <?php echo $_SESSION['Point'] ?></h3>

            <!-- Profile image upload form -->
            <form action="upload.php" method="post" enctype="multipart/form-data" class="mt-3">
                <div class="form-group">
                    <label for="profile_image" class="form-label">Upload Profile Image:</label>
                    <div class="file-input-wrapper">
                        <input type="file" name="profile_image" id="profile_image" accept="image/*" class="file-input" />
                        <label for="profile_image" class="file-input-label">Browse</label>

                        <button type="submit" class="btn btn-upload">Upload</button>
                    </div>
                </div>
            </form>
            <div class="btn-wrapper">
            <a href="logout.php" class="btn btn-danger btn-logout">Logout</a>
        </div>


        </div>

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTt
mI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/
TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous" script></script>
    </body>

    </html>



<?php

}
?>