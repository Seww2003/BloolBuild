<?php
session_start();
require '../connection.php';
$designer_count = $db->designers->countDocuments();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - BloomBuild</title>

<!-- Bootstrap CSS & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background: #f8f9fa;
    color: #333;
    display: flex;
    min-height: 100vh;
    overflow-x: hidden;
    transition: all 0.3s ease;
    position: relative;
}

/* Sidebar */
.sidebar {
    width: 240px;
    background: #0d3b2e;
    color: #e3f6f5;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    padding-top: 40px;
    box-shadow: 3px 0 12px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}
.sidebar h3 {
    text-align: center;
    color: #7ef9a3;
    font-weight: 700;
    font-size: 1.9rem;
    margin-bottom: 50px;
    text-shadow: 0 0 8px #38b000;
}
.sidebar a {
    display: flex;
    align-items: center;
    padding: 14px 25px;
    color: #d6f5f1;
    font-size: 1.05rem;
    text-decoration: none;
    border-left: 4px solid transparent;
    transition: all 0.3s ease;
}
.sidebar a i {
    margin-right: 15px;
    font-size: 1.5rem;
}
.sidebar a:hover, .sidebar a.active {
    background: #38b000;
    color: #fff;
    border-left-color: #7ef9a3;
    font-weight: 600;
    box-shadow: 3px 0 8px #7ef9a3aa;
}

/* Logout button top-right */
.logout-btn {
    position: fixed;
    top: 20px;
    right: 25px;
    z-index: 1000;
}
.logout-btn a {
    background: #ff595e;
    color: #fff;
    font-weight: 600;
    padding: 8px 18px;
    border-radius: 25px;
    text-decoration: none;
    transition: all 0.3s ease;
}
.logout-btn a:hover {
    background: #ff2e35;
}

/* Main Content */
.content {
    margin-left: 240px;
    padding: 40px 50px;
    flex-grow: 1;
}
.content h2 {
    font-weight: 700;
    font-size: 2.5rem;
    color: #0d3b2e;
    margin-bottom: 12px;
}
.content p {
    font-size: 1.1rem;
    color: #555;
    margin-bottom: 35px;
}

/* Dashboard Cards */
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
    gap: 20px;
    margin-bottom: 40px;
}
.dashboard-card {
    background: #fff;
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.07);
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.12);
}
.dashboard-card i {
    font-size: 3rem;
    color: #38b000;
    margin-bottom: 15px;
}
.dashboard-card h5 {
    font-weight: 600;
    margin-bottom: 10px;
    color: #0d3b2e;
}
.dashboard-card p {
    font-size: 0.95rem;
    color: #555;
    margin-bottom: 15px;
}
.dashboard-card .btn {
    border-radius: 25px;
    font-weight: 500;
    padding: 8px 18px;
}

/* Charts */
.chart-container {
    background: #fff;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.07);
}
.chart-container h5 {
    text-align: center;
    color: #0d3b2e;
    margin-bottom: 15px;
}

/* Responsive */
@media (max-width: 900px) {
    .content { padding: 30px 35px; }
    .dashboard-cards { grid-template-columns: 1fr 1fr; }
}
@media (max-width: 600px) {
    .sidebar { width: 70px; padding-top: 25px; }
    .sidebar h3 { display: none; }
    .sidebar a { justify-content: center; font-size: 0; }
    .sidebar a i { margin: 0; font-size: 1.7rem; }
    .sidebar a span { display: none; }
    .sidebar a:hover::after {
        content: attr(title);
        position: absolute;
        left: 80px;
        top: 50%;
        transform: translateY(-50%);
        background: #38b000;
        color: #fff;
        padding: 5px 12px;
        border-radius: 5px;
        white-space: nowrap;
        font-size: 0.85rem;
        font-weight: 600;
        z-index: 1000;
    }
    .logout-btn { top: 15px; right: 15px; }
}
</style>
</head>
<body>

<!-- Sidebar -->
<nav class="sidebar">
    <h3>BloomBuild</h3>
    <a href="admin_dashboard.php" class="active" title="Dashboard"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a>
    <a href="admin_designers.php" title="Designers"><i class="bi bi-person-badge"></i><span>Designers</span></a>
    <a href="admin_users.php" title="Users"><i class="bi bi-people"></i><span>Users</span></a>
    <a href="add_designer.php" title="Add Designer"><i class="bi bi-person-plus"></i><span>Add Designer</span></a>
    <a href="order.php" title="Orders"><i class="bi bi-box-seam"></i><span>Orders</span></a>
    <a href="admin_instructions.php" title="Instructions"><i class="bi bi-journal-text"></i><span>Instructions</span></a>
    <a href="adminviewReviews.php" title="Reviews"><i class="bi bi-chat-dots"></i><span>Reviews</span></a>
</nav>

<!-- Logout button top-right -->
<div class="logout-btn">
    <a href="admin_logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- Main Content -->
<main class="content">
    <h2>Welcome Back, Admin</h2>
    <p>Manage your landscaping business efficiently and monitor performance in real-time.</p>

    <section class="dashboard-cards">
        <div class="dashboard-card">
            <i class="bi bi-person-badge"></i>
            <h5>Designers</h5>
            <p>Manage landscaping designers and their portfolios.</p>
            <a href="admin_designers.php" class="btn btn-outline-success">Manage</a>
        </div>
        <div class="dashboard-card">
            <i class="bi bi-people"></i>
            <h5>Users</h5>
            <p>Control user accounts, permissions, and access rights.</p>
            <a href="admin_users.php" class="btn btn-outline-primary">Manage</a>
        </div>
        <div class="dashboard-card">
            <i class="bi bi-box-seam"></i>
            <h5>Orders</h5>
            <p>Track orders, shipping, and customer satisfaction.</p>
            <a href="order.php" class="btn btn-outline-warning">Manage</a>
        </div>
        <div class="dashboard-card">
            <i class="bi bi-journal-text"></i>
            <h5>Instructions</h5>
            <p>Update lawn care services efficiently.</p>
            <a href="admin_instructions.php" class="btn btn-outline-danger">Manage</a>
        </div>
        <div class="dashboard-card">
    <i class="bi bi-images"></i>
    <h5>Land Photos</h5>
    <p>View clients uploaded Photos.</p>
    <a href="admin_land.php" class="btn btn-outline-danger">Manage</a>
</div>

    </section>

    <section class="dashboard-reports">
        <div class="row">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5>Plant Types Distribution</h5>
                    <canvas id="plantPieChart"></canvas>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-container">
                    <h5>Monthly Sales Overview</h5>
                    <canvas id="monthlySalesBarChart"></canvas>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
// Pie chart
new Chart(document.getElementById('plantPieChart'), {
    type: 'pie',
    data: {
        labels: ['Shrubs','Flowers','Trees','Grass','Succulents'],
        datasets: [{data:[45,25,15,10,5], backgroundColor:['#38b000','#ff595e','#1982c4','#ffca3a','#6a4c93']}]
    }
});

// Bar chart
new Chart(document.getElementById('monthlySalesBarChart'), {
    type: 'bar',
    data: {
        labels:['Jan','Feb','Mar','Apr','May','Jun'],
        datasets:[{label:'Sales (USD)', data:[1200,1900,1700,2200,2700,3000], backgroundColor:'#38b000', borderRadius:5}]
    },
    options: { responsive:true, scales:{ y:{ beginAtZero:true } } }
});
</script>

</body>
</html>
