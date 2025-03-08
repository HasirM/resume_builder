<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

header('Content-Type: application/json');
include_once('../db.php'); // Include database connection

// Get form data
$table = $_POST['table']; // Table name (e.g., profile_images)
$user_id = $_POST['user_id']; // User ID from the form data
$id = $_POST['id'] ?? null; // ID of the row to update (optional for new records)
unset($_POST['table'], $_POST['user_id'], $_POST['id']); // Remove unnecessary fields

// Handle file upload
if ($table === 'profile_images' && isset($_FILES['image'])) {
    $file = $_FILES['image'];

    // Check for errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'File upload error: ' . $file['error']]);
        exit();
    }

    // Validate file type (only images allowed)
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPEG, PNG, and GIF are allowed.']);
        exit();
    }

    // Generate a unique file name to avoid conflicts
    $file_name = uniqid() . '_' . basename($file['name']);
    $upload_dir = 'uploads/'; // Directory to store uploaded files
    $file_path = $upload_dir . $file_name;

    // Move the uploaded file to the uploads directory
    if (!move_uploaded_file($file['tmp_name'], $file_path)) {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
        exit();
    }

    // Prepare data for database insertion/update
    $_POST['image'] = $file_name; // Save the file name in the database
}

// Prepare SQL query based on the table
$columns = [];
$values = [];
foreach ($_POST as $key => $value) {
    $columns[] = $key;
    $values[] = "'" . $conn->real_escape_string($value) . "'";
}

if ($id) {
    // Check if the record already exists
    $check_sql = "SELECT id FROM $table WHERE id = $id AND user_id = $user_id";
    $result = $conn->query($check_sql);

    if ($result->num_rows > 0) {
        // Update existing record
        $updates = [];
        foreach ($_POST as $key => $value) {
            $updates[] = "$key = '" . $conn->real_escape_string($value) . "'";
        }
        $update_sql = "UPDATE $table SET " . implode(', ', $updates) . " WHERE id = $id AND user_id = $user_id";
        if ($conn->query($update_sql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating record: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Record not found']);
    }
} else {
    // Insert new record
    $insert_sql = "INSERT INTO $table (user_id, " . implode(', ', $columns) . ") VALUES ($user_id, " . implode(', ', $values) . ")";
    if ($conn->query($insert_sql)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error inserting record: ' . $conn->error]);
    }
}

$conn->close();
?>