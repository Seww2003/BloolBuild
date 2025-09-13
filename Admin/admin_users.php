<?php
session_start();
require '../connection.php'; // Admin MongoDB connection

$users = $db->user_table->find([], ['sort' => ['register_date' => -1]]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>

    <!-- Bootstrap 5 -->
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
            background-color: #2E7D32;
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
    <h2>Registered Users</h2>
    <div class="table-responsive">
        <table id="usersTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    
                   
                </tr>
            </thead>
            <tbody>
                <?php foreach($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user->username); ?></td>
                    <td><?= htmlspecialchars($user->email); ?></td>
                    
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
        $('#usersTable').DataTable({
            "order": [[ 3, "desc" ]], // order by registration date descending
            "pageLength": 10,
            responsive: true
        });
    });
</script>

</body>
</html>
