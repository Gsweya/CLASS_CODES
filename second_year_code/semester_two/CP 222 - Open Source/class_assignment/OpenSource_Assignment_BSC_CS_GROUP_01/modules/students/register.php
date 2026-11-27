<?php
// modules/students/register.php
require_once '../../config/db.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Kuchukua data kutoka kwenye fomu
    $reg_number = trim($_POST['reg_number']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $gender = $_POST['gender'];
    $school_level = $_POST['school_level'];
    $class_level = trim($_POST['class_level']);

    if (!empty($reg_number) && !empty($first_name) && !empty($last_name)) {
        try {
            // Kuandikisha mwanafunzi kwenye database
            $stmt = $conn->prepare("INSERT INTO students (reg_number, first_name, last_name, gender, school_level, class_level) VALUES (:reg_number, :first_name, :last_name, :gender, :school_level, :class_level)");
            
            $stmt->execute([
                'reg_number' => $reg_number,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'gender' => $gender,
                'school_level' => $school_level,
                'class_level' => $class_level
            ]);

            $message = "Mwanafunzi amesajiliwa kwa mafanikio! 🎉";
            $message_type = "success";
        } catch (PDOException $e) {
            // Angalia kama namba ya usajili imeshajirudia (Duplicate Error)
            if ($e->errorInfo[1] == 1062) {
                $message = "Error: Namba hii ya usajili ($reg_number) ishatumika tayari!";
                $message_type = "error";
            } else {
                $message = "Kuna kitu kimeenda vibaya: " . $e->getMessage();
                $message_type = "error";
            }
        }
    } else {
        $message = "Tafadhali jaza nafasi zote zilizo wazi.";
        $message_type = "error";
    }
}
?>

<div class="main-content">
    <div class="welcome-box">
        <h1 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 5px;">Register New Student 📝</h1>
        <p style="color: #8a92a6; font-size: 0.95rem;">Primary and Secondary School Student Registration Module (Case: Tanzania).</p>
    </div>

    <?php if (!empty($message)): ?>
        <div style="padding: 15px 20px; border-radius: 15px; margin-bottom: 25px; font-weight: 600; text-align: center; 
            background: <?php echo $message_type == 'success' ? '#d4edda' : '#f8d7da'; ?>; 
            color: <?php echo $message_type == 'success' ? '#155724' : '#721c24'; ?>; 
            box-shadow: var(--shadow-out);">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div style="padding: 35px; border-radius: 25px; box-shadow: var(--shadow-out); background: var(--card-bg); max-width: 600px; margin: 0 auto;">
        <form action="register.php" method="POST">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem;">Registration Number</label>
                <div class="input-group">
                    <i class="fa-solid fa-id-card input-icon"></i>
                    <input type="text" name="reg_number" placeholder="Mfano: IM/2026/001 au TZ-SEC-102" required>
                </div>
            </div>

            <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem;">First Name</label>
                    <div class="input-group">
                        <i class="fa-regular fa-user input-icon"></i>
                        <input type="text" name="first_name" placeholder="Jina la Kwanza" required>
                    </div>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem;">Last Name</label>
                    <div class="input-group">
                        <i class="fa-regular fa-user input-icon"></i>
                        <input type="text" name="last_name" placeholder="Jina la Mwisho" required>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem;">Gender</label>
                <div style="display: flex; gap: 30px; padding: 15px 20px; border-radius: 25px; box-shadow: var(--shadow-in);">
                    <label style="cursor: pointer; font-weight: 600;">
                        <input type="radio" name="gender" value="Male" checked style="margin-right: 8px;"> Male
                    </label>
                    <label style="cursor: pointer; font-weight: 600;">
                        <input type="radio" name="gender" value="Female" style="margin-right: 8px;"> Female
                    </label>
                </div>
            </div>

            <div style="display: flex; gap: 20px; margin-bottom: 25px;">
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem;">School Level</label>
                    <div style="position: relative; box-shadow: var(--shadow-in); border-radius: 25px; display: flex; align-items: center;">
                        <i class="fa-solid fa-school style-icon" style="position: absolute; left: 20px; color: #8a92a6;"></i>
                        <select name="school_level" required style="width: 100%; padding: 16px 20px 16px 50px; border: none; background: transparent; outline: none; font-size: 1rem; color: var(--text-color); cursor: pointer; -webkit-appearance: none;">
                            <option value="Primary" style="background: var(--bg-color);">Primary</option>
                            <option value="Secondary" style="background: var(--bg-color);">Secondary</option>
                        </select>
                    </div>
                </div>
                <div style="flex: 1;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 600; font-size: 0.9rem;">Class / Form</label>
                    <div class="input-group">
                        <i class="fa-solid fa-shapes input-icon"></i>
                        <input type="text" name="class_level" placeholder="Mfano: Standard 4 au Form 2" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit" style="width: 100%;">Save Student Record</button>
        </form>
    </div>
</div>

<?php 
require_once '../../includes/footer.php'; 
?>