<?php
// index.php
require_once 'config/db.php';
require_once 'includes/header.php';
require_once 'includes/sidebar.php';

// Hapa tunatafuta idadi ya wanafunzi kutoka kwenye database kwa ajili ya takwimu za dashboard
try {
    $total_stmt = $conn->query("SELECT COUNT(*) FROM students");
    $total_students = $total_stmt->fetchColumn();

    $primary_stmt = $conn->query("SELECT COUNT(*) FROM students WHERE school_level = 'Primary'");
    $primary_students = $primary_stmt->fetchColumn();

    $secondary_stmt = $conn->query("SELECT COUNT(*) FROM students WHERE school_level = 'Secondary'");
    $secondary_students = $secondary_stmt->fetchColumn();
} catch (PDOException $e) {
    $total_students = $primary_students = $secondary_students = 0;
}
?>

<div class="main-content">
    <div class="welcome-box">
        <h1 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 5px;">Hellow, <?php echo htmlspecialchars($_SESSION['user_name']); ?>! 👋</h1>
        <p style="color: #8a92a6; font-size: 0.95rem;">Welcom, to School information System (SIMS) - Tanzania.</p>
    </div>

    <div class="card-grid">
        <div class="stats-card">
            <i class="fa-solid fa-users" style="color: #6b11ff;"></i>
            <h3 style="font-size: 1rem; color: #8a92a6; margin-bottom: 5px;">Total Students</h3>
            <p style="font-size: 1.8rem; font-weight: 700;"><?php echo $total_students; ?></p>
        </div>
        <div class="stats-card">
            <i class="fa-solid fa-child" style="color: #1171ff;"></i>
            <h3 style="font-size: 1rem; color: #8a92a6; margin-bottom: 5px;">Primary Schools</h3>
            <p style="font-size: 1.8rem; font-weight: 700;"><?php echo $primary_students; ?></p>
        </div>
        <div class="stats-card">
            <i class="fa-solid fa-children" style="color: #2ec4b6;"></i>
            <h3 style="font-size: 1rem; color: #8a92a6; margin-bottom: 5px;">Secondary Schools</h3>
            <p style="font-size: 1.8rem; font-weight: 700;"><?php echo $secondary_students; ?></p>
        </div>
    </div>

    <div style="padding: 25px; border-radius: 20px; box-shadow: var(--shadow-out); background: var(--card-bg);">
        <h2 style="font-size: 1.3rem; margin-bottom: 15px;"><i class="fa-solid fa-circle-info" style="color: #ff9f1c;"></i> Assignment Information</h2>
        <p style="font-size: 0.95rem; line-height: 1.6; color: var(--text-color);">
           This system is specifically designed to meet all the criteria for CP 222: Open Source Technologies. It is capable of registering primary and secondary school students in Tanzania, enrolling their information, and performing quick searches using their registration numbers.
        </p>
    </div>
</div>

<?php 
require_once 'includes/footer.php'; 
?>