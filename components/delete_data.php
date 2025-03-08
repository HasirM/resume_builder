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

// Get the data from the request body
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id']; // ID of the record to delete
$table = $data['table']; // Table name (e.g., education, work_experience, etc.)
$user_id = $data['user_id']; // User ID from the session

// Validate input
if (empty($id) || empty($table) || empty($user_id)) {
    echo json_encode(['success' => false, 'message' => 'Invalid input']);
    exit();
}

// Delete the record from the database
$delete_sql = "DELETE FROM $table WHERE id = $id AND user_id = $user_id";
if ($conn->query($delete_sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error deleting record: ' . $conn->error]);
}

$conn->close();
?>