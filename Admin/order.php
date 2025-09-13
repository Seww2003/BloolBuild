<?php
session_start();
require '../connection.php'; // Admin MongoDB connection

$orders = $db->orders->find([], ['sort' => ['order_date' => -1]]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Designer Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            padding: 30px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        table.dataTable thead {
            background-color: #27ae60;
            color: white;
        }
        .container {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        td, th {
            vertical-align: middle !important;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>All Designer Orders</h2>
    <div class="table-responsive">
        <table id="ordersTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    
                    <th>Client Name</th>
                    <th>Client Email</th>
                    <th>Client Address</th>
                    <th>Contact Number</th>
                    <th>Designer Name</th>
                    <th>Purpose</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($orders as $order): ?>
                <tr>
                    
                    <td><?= htmlspecialchars($order->client_name); ?></td>
                    <td><?= htmlspecialchars($order->client_email); ?></td>
                    <td><?= htmlspecialchars($order->client_address); ?></td>
                    <td><?= htmlspecialchars($order->contact_number); ?></td>
                    <td><?= htmlspecialchars($order->designer_name); ?></td>
                    <td><?= htmlspecialchars($order->purpose); ?></td>
                    <td><?= htmlspecialchars($order->description); ?></td>
<td>
    <?= isset($order->design_image) ? htmlspecialchars($order->design_image) : 'No Image'; ?>
</td>
                    <td><?= $order->order_date->toDateTime()->format('Y-m-d H:i:s'); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            "order": [[ 8, "desc" ]], // order by Date descending
            "pageLength": 10,
            "lengthMenu": [5, 10, 25, 50, 100],
            responsive: true
        });
    });
</script>

</body>
</html>
