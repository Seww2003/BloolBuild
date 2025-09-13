<?php
require '../connection.php';
session_start();

$collection = $db->reviews;

// Handle delete request
if(isset($_GET['delete_id'])){
    try {
        $deleteResult = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($_GET['delete_id'])]);
        if($deleteResult->getDeletedCount() > 0){
            $msg = "Review deleted successfully.";
        } else {
            $msg = "Failed to delete review.";
        }
    } catch(Exception $e){
        $msg = "Error: " . $e->getMessage();
    }
}

// Fetch all reviews and convert to array
$reviewsArray = $collection->find([], ['sort' => ['submitted_at' => -1]])->toArray();

// Prepare data for daily review chart
$dailyCounts = [];
foreach($reviewsArray as $review){
    $date = $review->submitted_at->toDateTime()->format('Y-m-d');
    if(isset($dailyCounts[$date])){
        $dailyCounts[$date]++;
    } else {
        $dailyCounts[$date] = 1;
    }
}

// Sort dates ascending
ksort($dailyCounts);
$chartLabels = json_encode(array_keys($dailyCounts));
$chartData = json_encode(array_values($dailyCounts));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin - View Reviews</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
.container { margin-top: 40px; }
.table thead th { background-color: #343a40; color: #fff; }
.chart-container { margin-top: 50px; background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);}
</style>
</head>
<body>
<div class="container">
    <h2 class="text-center mb-4">Submitted Reviews</h2>

    <?php if(isset($msg)) { echo '<div class="alert alert-info">'.$msg.'</div>'; } ?>
    <a href="admin_dashboard.php" class="btn btn-secondary mb-3">← Back to Dashboard</a>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Service</th>
                <th>Message</th>
                <th>Rating</th>
                <th>Submitted At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
            foreach($reviewsArray as $review){
                $date = $review->submitted_at->toDateTime()->format('Y-m-d H:i');
            ?>
            <tr>
                <td><?= $i++; ?></td>
                <td><?= htmlspecialchars($review->name); ?></td>
                <td><?= htmlspecialchars($review->email); ?></td>
                <td><?= htmlspecialchars($review->service); ?></td>
                <td><?= htmlspecialchars($review->message); ?></td>
                <td><?= str_repeat('★', $review->rating) . str_repeat('☆', 5 - $review->rating); ?></td>
                <td><?= $date; ?></td>
                <td>
                    <a href="?delete_id=<?= $review->_id ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php } ?>
            <?php if($i == 1){ ?>
            <tr>
                <td colspan="8" class="text-center">No reviews submitted yet.</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Daily Reviews Bar Chart -->
    <div class="chart-container">
        <h4 class="text-center mb-4">Daily Review Counts</h4>
        <canvas id="dailyReviewsChart"></canvas>
    </div>
</div>

<script>
const ctx = document.getElementById('dailyReviewsChart').getContext('2d');
const dailyReviewsChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= $chartLabels ?>,
        datasets: [{
            label: 'Number of Reviews',
            data: <?= $chartData ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: { enabled: true }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});
</script>
</body>
</html>
