
<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start(); // Avvia una sessione solo se non è già attiva
    }
    // If the user is not logged in redirect to the login page...
    if (!isset($_SESSION['id'])) {
        header('Location: ../php/login.php');
        exit;
    }


// Supponiamo che $active_page contenga il nome della pagina attuale
$active_page = $page_name; // Modifica questo valore per testare diverse pagine
?>

    <div class="sidebar">
        <a href="#" class="logo">
            <div class="logo-name">
                <span>Co</span>
                <span class="habitant">Habitat</span>
            </div>
        </a>
        <div class="menu-voices">
            <ul class="side-menu main-menu">
                <li class="<?= $active_page === 'dashboard' ? 'active' : '' ?>">
                    <a href="dashboard.php"><i class='bx bxs-dashboard'></i>&nbsp Dashboard</a>
                </li>
                <li class="<?= $active_page === 'payments' ? 'active' : '' ?>">
                    <a href="payments.php"><i class='bx bx-dollar-circle'></i>&nbsp Payments</a>
                </li>
                <li class="<?= $active_page === 'expenses' ? 'active' : '' ?>">
                    <a href="expenses.php"><i class='bx bx-cart-alt'></i>&nbsp Expenses</a>
                </li>
                <li class="<?= $active_page === 'reminders' ? 'active' : '' ?>">
                    <a href="reminders.php"><i class='bx bx-note'></i>&nbsp Reminders</a>
                </li>
                <li class="<?= $active_page === 'roommates' ? 'active' : '' ?>">
                    <a href="roommates.php"><i class='bx bx-group'></i>&nbsp Roommates</a>
                </li>
                <li class="<?= $active_page === 'settings' ? 'active' : '' ?>">
                    <a href="settings.php"><i class='bx bx-cog'></i>&nbsp Settings</a>
                </li>
            </ul>
            <ul class="side-menu housecode-menu">
                <li>
                    Share this code to join the house:
                    <b><span class="house-code" id ="house-code"><?php echo $_SESSION['house_name'] ?></span></b>
                </li>
            </ul>
            <br>
            <ul class="side-menu logout-menu">
                <li>
                    <a href="../php/script/logout.php" class="logout">
                        <i class='bx bx-log-out-circle'></i>
                        &nbsp Logout
                    </a>
                </li>
            </ul>

        </div>
    </div>

    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <br>
            <span class="house-name" id ="house-name"><?php echo $_SESSION['house_name'] ?></span>
            <div class="profile">
                <span><?php echo $_SESSION['name'] . ' ' . $_SESSION['surname'] ?></span>
            </div>

        </nav>

        <!-- End of Navbar -->