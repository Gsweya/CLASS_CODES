<?php
// modules/students/search.php
require_once '../../config/db.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';

$student = null;
$search_performed = false;
$error_message = '';

if (isset($_GET['reg_number'])) {
    $reg_number = trim($_GET['reg_number']);
    $search_performed = true;

    if (!empty($reg_number)) {
        try {
            // Tafuta mwanafunzi kulingana na reg_number pekee
            $stmt = $conn->prepare("SELECT * FROM students WHERE reg_number = :reg_number LIMIT 1");
            $stmt->execute(['reg_number' => $reg_number]);
            $student = $stmt->fetch();
            
            if (!$student) {
                $error_message = "Hakuna mwanafunzi aliyepatikana kwa namba ya usajili: " . htmlspecialchars($reg_number);
            }
        } catch (PDOException $e) {
            $error_message = "Kuna tatizo lilitokea wakati wa kutafuta: " . $e->getMessage();
        }
    } else {
        $error_message = "Tafadhali jaza namba ya usajili ili kutafuta.";
    }
}
?>

<div class="main-content">
    <div class="welcome-box">
        <h1 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 5px;">Search Studen 🔍</h1>
        <p style="color: #8a92a6; font-size: 0.95rem;">Search module for student records using the Registration Number.</p>
    </div>

    <div style="padding: 25px; border-radius: 20px; box-shadow: var(--shadow-out); background: var(--card-bg); max-width: 600px; margin: 0 auto 30px;">
        <form action="search.php" method="GET" style="display: flex; gap: 15px; align-items: center;">
            <div class="input-group" style="margin-bottom: 0; flex: 1;">
                <i class="fa-solid fa-magnifying-glass input-icon"></i>
                <input type="text" name="reg_number" placeholder="Weka Reg Number (Mfano: IM/2026/001)" value="<?php echo isset($_GET['reg_number']) ? htmlspecialchars($_GET['reg_number']) : ''; ?>" required>
            </div>
            <button type="submit" class="btn-submit" style="width: auto; padding: 15px 30px; margin-top: 0; white-space: nowrap;">Search</button>
        </form>
    </div>

    <div style="max-width: 600px; margin: 0 auto;">
        <?php if ($search_performed && $student): ?>
            <div style="padding: 30px; border-radius: 25px; box-shadow: var(--shadow-out); background: var(--card-bg); text-align: left;">
                <h3 style="font-size: 1.3rem; margin-bottom: 20px; border-bottom: 2px dashed #1171ff; padding-bottom: 10px; color: #1171ff;">
                    <i class="fa-solid fa-address-card"></i> Student Profile Found
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 15px; font-size: 1.05rem;">
                    <div>
                        <span style="color: #8a92a6; width: 150px; display: inline-block;">Reg Number:</span>
                        <strong><?php echo htmlspecialchars($student['reg_number']); ?></strong>
                    </div>
                    <div>
                        <span style="color: #8a92a6; width: 150px; display: inline-block;">Full Name:</span>
                        <strong><?php echo htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></strong>
                    </div>
                    <div>
                        <span style="color: #8a92a6; width: 150px; display: inline-block;">Gender:</span>
                        <strong><?php echo $student['gender']; ?></strong>
                    </div>
                    <div>
                        <span style="color: #8a92a6; width: 150px; display: inline-block;">School Level:</span>
                        <span style="padding: 4px 10px; border-radius: 15px; font-size: 0.85rem; font-weight: bold; background: rgba(17, 113, 255, 0.15); color: #1171ff;">
                            <?php echo $student['school_level']; ?>
                        </span>
                    </div>
                    <div>
                        <span style="color: #8a92a6; width: 150px; display: inline-block;">Class / Form:</span>
                        <strong><?php echo htmlspecialchars($student['class_level']); ?></strong>
                    </div>
                    <div>
                        <span style="color: #8a92a6; width: 150px; display: inline-block;">Registration Date:</span>
                        <span style="color: #8a92a6;"><?php echo date('F d, Y (H:i)', strtotime($student['created_at'])); ?></span>
                    </div>
                </div>
            </div>

        <?php elseif ($search_performed && !empty($error_message)): ?>
            <div style="padding: 20px; border-radius: 15px; text-align: center; background: #f8d7da; color: #721c24; box-shadow: var(--shadow-out); font-weight: 600;">
                <i class="fa-solid fa-triangle-exclamation" style="margin-right: 8px;"></i> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php 
require_once '../../includes/footer.php'; 
?>