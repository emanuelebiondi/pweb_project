
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
        <a href="dashboard.php" class="logo">
            <div class="logo-name">
                <span>Co</span>
                <span class="habitat">Habitat</span>
            </div>
        </a>
        <div class="menu-voices">
            <ul class="side-menu main-menu">
                <li class="<?= $active_page === 'dashboard' ? 'active' : '' ?>">
                    <a href="dashboard.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.7rem" height="1.6em" viewBox="0 0 24 24"><path fill="currentColor" d="M21.822 7.431A1 1 0 0 0 21 7H7.333L6.179 4.23A1.99 1.99 0 0 0 4.333 3H2v2h2.333l4.744 11.385A1 1 0 0 0 10 17h8c.417 0 .79-.259.937-.648l3-8a1 1 0 0 0-.115-.921M17.307 15h-6.64l-2.5-6h11.39z"/><circle cx="10.5" cy="19.5" r="1.5" fill="currentColor"/><circle cx="17.5" cy="19.5" r="1.5" fill="currentColor"/></svg>    
                        &nbsp Dashboard
                    </a>
                </li>
                <li class="<?= $active_page === 'payments' ? 'active' : '' ?>">
                    <a href="payments.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.7rem" height="1.7rem" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2m0 18a8 8 0 1 1 8-8a8 8 0 0 1-8 8"/><path fill="currentColor" d="M12 11c-2 0-2-.63-2-1s.7-1 2-1s1.39.64 1.4 1h2A3 3 0 0 0 13 7.12V6h-2v1.09C9 7.42 8 8.71 8 10c0 1.12.52 3 4 3c2 0 2 .68 2 1s-.62 1-2 1c-1.84 0-2-.86-2-1H8c0 .92.66 2.55 3 2.92V18h2v-1.08c2-.34 3-1.63 3-2.92c0-1.12-.52-3-4-3"/></svg>
                        &nbsp Payments
                    </a>
                </li>
                <li class="<?= $active_page === 'expenses' ? 'active' : '' ?>">
                    <a href="expenses.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.7rem" height="1.7rem" viewBox="0 0 24 24"><path fill="currentColor" d="M21 4H2v2h2.3l3.28 9a3 3 0 0 0 2.82 2H19v-2h-8.6a1 1 0 0 1-.94-.66L9 13h9.28a2 2 0 0 0 1.92-1.45L22 5.27A1 1 0 0 0 21.27 4A.8.8 0 0 0 21 4m-2.75 7h-10L6.43 6h13.24z"/><circle cx="10.5" cy="19.5" r="1.5" fill="currentColor"/><circle cx="16.5" cy="19.5" r="1.5" fill="currentColor"/></svg>
                        &nbsp Expenses
                    </a>
                </li>
                <li class="<?= $active_page === 'reminders' ? 'active' : '' ?>">
                    <a href="reminders.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.7rem" height="1.7rem" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h8a1 1 0 0 0 .707-.293l7-7a1 1 0 0 0 .196-.293c.014-.03.022-.061.033-.093a1 1 0 0 0 .051-.259c.002-.021.013-.041.013-.062V5c0-1.103-.897-2-2-2M5 5h14v7h-6a1 1 0 0 0-1 1v6H5zm9 12.586V14h3.586z"/></svg>    
                        &nbsp Reminders
                    </a>
                </li>
                <li class="<?= $active_page === 'roommates' ? 'active' : '' ?>">
                    <a href="roommates.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1.7rem" height="1.7rem" viewBox="0 0 24 24"><path fill="currentColor" d="M16.604 11.048a5.67 5.67 0 0 0 .751-3.44c-.179-1.784-1.175-3.361-2.803-4.44l-1.105 1.666c1.119.742 1.8 1.799 1.918 2.974a3.7 3.7 0 0 1-1.072 2.986l-1.192 1.192l1.618.475C18.951 13.701 19 17.957 19 18h2c0-1.789-.956-5.285-4.396-6.952"/><path fill="currentColor" d="M9.5 12c2.206 0 4-1.794 4-4s-1.794-4-4-4s-4 1.794-4 4s1.794 4 4 4m0-6c1.103 0 2 .897 2 2s-.897 2-2 2s-2-.897-2-2s.897-2 2-2m1.5 7H8c-3.309 0-6 2.691-6 6v1h2v-1c0-2.206 1.794-4 4-4h3c2.206 0 4 1.794 4 4v1h2v-1c0-3.309-2.691-6-6-6"/></svg>

                        </i>&nbsp Roommates
                    </a>
                </li>
                <li class="<?= $active_page === 'settings' ? 'active' : '' ?>">
                    <a href="settings.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.7rem" height="1.7rem" viewBox="0 0 24 24"><path fill="currentColor" d="M12 16c2.206 0 4-1.794 4-4s-1.794-4-4-4s-4 1.794-4 4s1.794 4 4 4m0-6c1.084 0 2 .916 2 2s-.916 2-2 2s-2-.916-2-2s.916-2 2-2"/><path fill="currentColor" d="m2.845 16.136l1 1.73c.531.917 1.809 1.261 2.73.73l.529-.306A8 8 0 0 0 9 19.402V20c0 1.103.897 2 2 2h2c1.103 0 2-.897 2-2v-.598a8 8 0 0 0 1.896-1.111l.529.306c.923.53 2.198.188 2.731-.731l.999-1.729a2 2 0 0 0-.731-2.732l-.505-.292a7.7 7.7 0 0 0 0-2.224l.505-.292a2 2 0 0 0 .731-2.732l-.999-1.729c-.531-.92-1.808-1.265-2.731-.732l-.529.306A8 8 0 0 0 15 4.598V4c0-1.103-.897-2-2-2h-2c-1.103 0-2 .897-2 2v.598a8 8 0 0 0-1.896 1.111l-.529-.306c-.924-.531-2.2-.187-2.731.732l-.999 1.729a2 2 0 0 0 .731 2.732l.505.292a7.7 7.7 0 0 0 0 2.223l-.505.292a2.003 2.003 0 0 0-.731 2.733m3.326-2.758A5.7 5.7 0 0 1 6 12c0-.462.058-.926.17-1.378a1 1 0 0 0-.47-1.108l-1.123-.65l.998-1.729l1.145.662a1 1 0 0 0 1.188-.142a6.1 6.1 0 0 1 2.384-1.399A1 1 0 0 0 11 5.3V4h2v1.3a1 1 0 0 0 .708.956a6.1 6.1 0 0 1 2.384 1.399a1 1 0 0 0 1.188.142l1.144-.661l1 1.729l-1.124.649a1 1 0 0 0-.47 1.108c.112.452.17.916.17 1.378s-.058.925-.171 1.378a1 1 0 0 0 .471 1.108l1.123.649l-.998 1.729l-1.145-.661a1 1 0 0 0-1.188.142a6.1 6.1 0 0 1-2.384 1.399A1 1 0 0 0 13 18.7l.002 1.3H11v-1.3a1 1 0 0 0-.708-.956a6.1 6.1 0 0 1-2.384-1.399a.99.99 0 0 0-1.188-.141l-1.144.662l-1-1.729l1.124-.651a1 1 0 0 0 .471-1.108"/></svg>
                        &nbsp Settings
                    </a>
                </li>
            </ul>
            <ul class="side-menu housecode-menu">
                    <li>
                    Share this code to join the house:
                    <b><span class="house-code" id ="house-code"><?php echo $_SESSION['house_code'] ?></span></b>
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