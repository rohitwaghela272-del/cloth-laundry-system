<?php
// Set content type to JSON
header('Content-Type: application/json');

// --- 1. Include the new database connection file ---
include 'db_connect.php';

// --- 2. Get Data from Frontend (POST request) ---
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
     echo json_encode(['success' => false, 'message' => 'Invalid input.']);
     exit();
}

// --- 3. Sanitize and Validate Input ---
$name = $conn->real_escape_string($input['name'] ?? '');
$email = $conn->real_escape_string($input['email'] ?? '');
$phone = $conn->real_escape_string($input['phone'] ?? '');
$service_id = (int)($input['service-type'] ?? 0);
$pickup_date = $conn->real_escape_string($input['pickup-date'] ?? '');
$pickup_time = $conn->real_escape_string($input['pickup-time'] ?? '');
$address = $conn->real_escape_string($input['address'] ?? '');

if (empty($name) || empty($email) || empty($phone) || empty($service_id) || empty($pickup_date) || empty($pickup_time) || empty($address)) {
    echo json_encode(['success' => false, 'message' => 'Please fill all required fields.']);
    exit();
}

// --- 4. Insert into Database ---
// We assume user_id 1 exists as per the database.sql file for this project.

$status = 'Pending';
$total_amount = 500.00; // Example amount

$sql = "INSERT INTO orders (user_id, service_id, pickup_date, pickup_time, delivery_address, total_amount, status) 
        VALUES (1, '$service_id', '$pickup_date', '$pickup_time', '$address', '$total_amount', '$status')";

if ($conn->query($sql) === TRUE) {
    $order_id = $conn->insert_id;
    echo json_encode(['success' => true, 'message' => 'Order placed successfully!', 'order_id' => $order_id]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error placing order: ' . $conn->error]);
}

$conn->close();
?>