<?php
include_once('functions.php');
$userdata = new DB_con();
session_start();

if ($_SESSION['id_phone'] == "") {
     header("location: signin.php");
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image'])) {
     $id_phone = $_SESSION['id_phone'];
    
     // Define the target directory to save uploaded images
     $targetDir = "uploads/";
    
     // Create the target directory if it doesn't exist
     if (!is_dir($targetDir)) {
         mkdir($targetDir, 0777, true);
     }
    
     // Define a unique filename for the uploaded image
     $profileImage = $targetDir . $id_phone . "_" . basename($_FILES["profile_image"]["name"]);
    
     // Move the uploaded image to the target directory
     if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profileImage)) {
         // Update the database with the profile image information
         $updateResult = $userdata->updateProfileImage($id_phone, $profileImage);
         if ($updateResult) {
             // Profile image updated successfully

             // Display the uploaded image immediately
             echo '<img src="' . $profileImage . '" alt="Profile Image">';

             header("location: welcome.php");
         } else {
             // Handle database update error
             echo "Error updating profile image.";
         }
     } else {
         // Handle image upload error
         echo "Error uploading image.";
     }
} else {
    // Check if the user already has a profile image
    $id_phone = $_SESSION['id_phone'];
    $profileImage = $userdata->getUserProfileImage($id_phone);

    if (!empty($profileImage)) {
        // Display the existing profile image
        echo '<img src="' . $profileImage . '" alt="Profile Image">';
    } else {
        // Display a default image or a message indicating no profile image
        echo 'No profile image available.';
    }

    header("location: welcome.php");
}
?>
