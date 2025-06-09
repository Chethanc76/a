<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone_number = trim($_POST['phone_number']);
    $password = $_POST['password'];
    $password = $_POST['password'];
    $address = $_POST['address'];

  
    if (!preg_match('/^\d{10}$/', $phone_number)) {
        $_SESSION['error_message'] = 'Phone number must be exactly 10 digits.';
        header('Location: register');
        exit();
    }

  
    if (!preg_match('/^(?=.*[0-9])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $_SESSION['error_message'] = 'Password must be at least 8 characters long and include at least one number and one special character (@, $, !, %, *, ?, &).';
        header('Location: register');
        exit();
    }


    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

   
    $sql = "SELECT * FROM modern_new_users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error_message'] = 'This email is already registered.';
        header('Location: register');
        exit();
    }


    $role = 'user';


    $sql = "INSERT INTO modern_new_users (name, email, phone_number, password, address, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $name, $email, $phone_number, $hashed_password, $address, $role);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Registration successful. Please login.';
        header('Location: login');
        exit();
    } else {
        $_SESSION['error_message'] = 'Registration failed. Please try again.';
        header('Location: register');
        exit();
    }
}
?>
