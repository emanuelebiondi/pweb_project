<?php
    //include("php/dashboard.php");
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoHabitat</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <main>
        <div class= "container-left">
            <a href="index.php" class="logo">
                <div class="logo-name">
                    <span>Co</span>
                    <span class="habitat">Habitat</span>
                </div>
            </a>

            <div class="content-title">
                 <h1>Effortlessly manage your expenses with your roommates.</h1>
                 <h2>Splitting costs, tracking them, and simplifying money exchanges has never been easier. With Cohabitat, co-living becomes stress-free.</h2>
            </div>

            <div class="content-button">
                <a href="/php/login.php" class="btn-login">Login</a>
                <a href="/php/register.php" class="btn-register">Register</a>
            </div>
        </div>

        <div class="container-right">
                <div class="content-title">
                    <h1>Effortlessly Manage Expenses with Your Roommates</h1>
                </div>
                <div class="content-text">
                    <div class="elem">
                        <span>1</span>
                        <p class="bold">Sign up and create your home</p>
                        <p>Set up a new space for you and your roommates by sending them an invitation code to join.</p>
                    </div>
                    <span class="arrow">&#11206;</span>
                    <div class="elem">
                        <span>2</span>
                        <span class="bold">Add expenses and transactions</span>
                        <p>Keep track of all shared expenses and transactions between roommates.</p>
                    </div>
                    <span class="arrow">&#11206;</span>
                    <div class="elem">
                        <span>3</span>
                        <p class="bold">Set how to split the expenses</p>
                        <p>Choose how to divide expenses fairly or customize the split between members.</p>
                    </div>
                    <span class="arrow">&#11206;</span>
                    <div class="elem">
                        <span>4</span>
                        <p class="bold">Do the settle-up</p>
                        <p>Settle up easily and clearly, with the final balance between roommates.</p>
                    </div>

                </div>
        </div>  

    </main>

</body>
<?php include "./php/snippet/footer.html"?>
</html>