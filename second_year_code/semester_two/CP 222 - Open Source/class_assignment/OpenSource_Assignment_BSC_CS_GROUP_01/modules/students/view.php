<?php
// modules/students/view.php
require_once '../../config/db.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';

try {
    // Vuta rekodi zote za wanafunzi kutoka kwenye database wakianza na waliosajiliwa karibuni
    $stmt = $conn->query("SELECT * FROM students ORDER BY created_at DESC");
    $students = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Imeshindwa kuvuta data za wanafunzi: " . $e->getMessage());
}
?>

<div class="main-content">
    <div class="welcome-box">
        <h1 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 5px;">Students List 📋</h1>
        <p style="color: #8a92a6; font-size: 0.95rem;">Here you can view all registered student records in the system.</p>
    </div>

    <div style="padding: 30px; border-radius: 25px; box-shadow: var(--shadow-out); background: var(--card-bg); overflow-x: auto;">
        
        <?php if (count($students) > 0): ?>
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 15px; text-align: left;">
                <thead>
                    <tr style="color: #8a92a6; font-size: 0.9rem; text-transform: uppercase;">
                        <th style="padding: 10px 20px;">Reg Number</th>
                        <th style="padding: 10px 20px;">Full Name</th>
                        <th style="padding: 10px 20px;">Gender</th>
                        <th style="padding: 10px 20px;">School Level</th>
                        <th style="padding: 10px 20px;">Class / Form</th>
                        <th style="padding: 10px 20px;">Date Registered</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr style="background: var(--card-bg); box-shadow: var(--shadow-out); border-radius: 15px; transition: transform 0.2s ease;">
                            <td style="padding: 20px; font-weight: 700; border-radius: 15px 0 0 15px; color: #1171ff;">
                                <?php echo htmlspecialchars($student['reg_number']); ?>
                            </td>
                            <td style="padding: 20px; font-weight: 600;">
                                <?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?>
                            </td>
                            <td style="padding: 20px;">
                                <i class="fa-solid <?php echo $student['gender'] == 'Male' ? 'fa-mars' : 'fa-venus'; ?>" 
                                   style="color: <?php echo $student['gender'] == 'Male' ? '#1171ff' : '#ff477e'; ?>; margin-right: 5px;"></i>
                                <?php echo $student['gender']; ?>
                            </td>
                            <td style="padding: 20px;">
                                <span style="padding: 6px 12px; border-radius: 20px; font-size: 0.85rem; font-weight: bold;
                                    background: <?php echo $student['school_level'] == 'Primary' ? 'rgba(46, 196, 182, 0.15)' : 'rgba(107, 17, 255, 0.15)'; ?>;
                                    color: <?php echo $student['school_level'] == 'Primary' ? '#2ec4b6' : '#6b11ff'; ?>;">
                                    <?php echo $student['school_level']; ?>
                                </span>
                            </td>
                            <td style="padding: 20px; font-weight: 600; color: var(--text-color);">
                                <?php echo htmlspecialchars($student['class_level']); ?>
                            </td>
                            <td style="padding: 20px; border-radius: 0 15px 15px 0; font-size: 0.9rem; color: #8a92a6;">
                                <?php echo date('M d, Y', strtotime($student['created_at'])); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="text-align: center; padding: 40px 20px;">
                <i class="fa-regular fa-folder-open" style="font-size: 3rem; color: #8a92a6; margin-bottom: 15px; display: block;"></i>
                <p style="color: #8a92a6; font-weight: 600;">No student records available. Please register a student to get started.</p>
                <a href="register.php" style="display: inline-block; margin-top: 15px; color: #1171ff; text-decoration: none; font-weight: bold;">
                    <i class="fa-solid fa-plus"></i> Click here to register the first student
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php 
require_once '../../includes/footer.php'; 
?>