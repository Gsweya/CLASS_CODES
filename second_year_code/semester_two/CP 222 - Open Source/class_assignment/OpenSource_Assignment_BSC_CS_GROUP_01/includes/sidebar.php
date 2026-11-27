<?php
// includes/sidebar.php
?>
<div class="sidebar" style="width: 280px; padding: 30px 20px; background: var(--card-bg); box-shadow: var(--shadow-out); display: flex; flex-direction: column; justify-content: space-between; transition: background 0.4s ease;">
    <div>
        <div class="brand" style="font-size: 1.4rem; font-weight: 800; margin-bottom: 40px; text-align: center; color: linear-gradient(135deg, #6b11ff, #1171ff);">
            <i class="fa-solid fa-graduation-cap"></i> SIMS - Case TZ
        </div>
        
        <div class="user-info" style="padding: 15px; border-radius: 15px; box-shadow: var(--shadow-in); margin-bottom: 30px; text-align: center; font-size: 0.9rem;">
            <i class="fa-regular fa-user-circle" style="font-size: 1.5rem; margin-bottom: 5px; display: block; color: #1171ff;"></i>
            <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong>
            <span style="display: block; font-size: 0.8rem; color: #8a92a6; margin-top: 2px;">Role: <?php echo $_SESSION['user_role']; ?></span>
        </div>

        <nav class="nav-menu" style="display: flex; flex-direction: column; gap: 15px;">
            <a href="/index.php" style="display: flex; align-items: center; gap: 15px; padding: 12px 20px; border-radius: 15px; text-decoration: none; color: var(--text-color); font-weight: 600; box-shadow: var(--shadow-out);">
                <i class="fa-solid fa-chart-pie" style="color: #6b11ff;"></i> Dashboard
            </a>
            <a href="/modules/students/register.php" style="display: flex; align-items: center; gap: 15px; padding: 12px 20px; border-radius: 15px; text-decoration: none; color: var(--text-color); font-weight: 600; box-shadow: var(--shadow-out);">
                <i class="fa-solid fa-user-plus" style="color: #1171ff;"></i> Register Student
            </a>
            <a href="/modules/students/view.php" style="display: flex; align-items: center; gap: 15px; padding: 12px 20px; border-radius: 15px; text-decoration: none; color: var(--text-color); font-weight: 600; box-shadow: var(--shadow-out);">
                <i class="fa-solid fa-users-viewfinder" style="color: #2ec4b6;"></i> View Records
            </a>
            <a href="/modules/students/search.php" style="display: flex; align-items: center; gap: 15px; padding: 12px 20px; border-radius: 15px; text-decoration: none; color: var(--text-color); font-weight: 600; box-shadow: var(--shadow-out);">
                <i class="fa-solid fa-magnifying-glass" style="color: #ff9f1c;"></i> Search Student
            </a>
        </nav>
    </div>

    <a href="/modules/users/logout.php" style="display: flex; align-items: center; gap: 15px; padding: 12px 20px; border-radius: 15px; text-decoration: none; color: #e63946; font-weight: 600; box-shadow: var(--shadow-out); text-align: center; justify-content: center;">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
    </a>
</div>