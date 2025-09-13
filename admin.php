<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Laundry Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">

    <div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">Laundry System - Admin Dashboard</h1>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="px-6 py-4">
                <h2 class="text-xl font-semibold text-gray-700">All Customer Orders</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Order ID</th>
                            <th class="w-1/6 text-left py-3 px-4 uppercase font-semibold text-sm">Customer</th>
                            <th class="w-1/4 text-left py-3 px-4 uppercase font-semibold text-sm">Service</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Pickup Schedule</th>
                            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php
                        // --- 1. Include the database connection file ---
                        include 'api/db_connect.php';

                        // --- 2. Write SQL Query to fetch all orders ---
                        $sql = "SELECT 
                                    o.id, 
                                    u.full_name, 
                                    s.service_name, 
                                    o.pickup_date, 
                                    o.pickup_time, 
                                    o.status 
                                FROM orders o
                                JOIN users u ON o.user_id = u.id
                                JOIN services s ON o.service_id = s.id
                                ORDER BY o.created_at DESC";

                        $result = $conn->query($sql);

                        // --- 3. Loop through the results and display in the table ---
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='text-left py-3 px-4'>#" . $row["id"] . "</td>";
                                echo "<td class='text-left py-3 px-4'>" . htmlspecialchars($row["full_name"]) . "</td>";
                                echo "<td class='text-left py-3 px-4'>" . htmlspecialchars($row["service_name"]) . "</td>";
                                echo "<td class='text-left py-3 px-4'>" . date("d M, Y", strtotime($row["pickup_date"])) . " at " . date("g:i A", strtotime($row["pickup_time"])) . "</td>";
                                echo "<td class='text-left py-3 px-4'><span class='bg-blue-200 text-blue-800 py-1 px-3 rounded-full text-xs'>" . htmlspecialchars($row["status"]) . "</span></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center py-4'>No orders found</td></tr>";
                        }
                        
                        // --- 4. Close the connection ---
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>