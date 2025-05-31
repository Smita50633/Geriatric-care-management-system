<?php
session_start();
include 'db_connect.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = $_POST['doctor_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $age = $_POST['age'];
    $specialization = $_POST['specialization'];
    $gender = $_POST['gender'];

    // Update query
    $query = "UPDATE doctors SET username=?, email=?, phone_no=?, age=?, specialization=?, gender=? WHERE id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $username, $email, $phone_no, $age, $specialization, $gender, $doctor_id);

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='edit-profile.php';</script>";
    } else {
        echo "<script>alert('Error updating profile!'); window.location.href='edit-profile.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
