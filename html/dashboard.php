<?php
    session_start();
    // If the user is not logged in redirect to the login page...
    /*if (!isset($_SESSION['id'])) {
        header('Location: login.php');
        exit;
    }*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Cohabitat - Dashboard</title>
</head>
<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>Cohabitat</h1>
        </div>
        <ul>
            <li><img src="../img/icons/dashboard.svg" alt="">&nbsp; <span>Dashboard</span> </li>
			<br>
            <li><img src="../img/icons/payments.svg" alt="">&nbsp; <span>Payments</span> </li>
            <li><img src="../img/icons/todo.svg" alt="">&nbsp; <span>Todo</span> </li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <div class="search">
                    <input type="text" placeholder="Search..">
                    <button type="submit"><img src="search.png" alt=""></button>
                </div>
                <div class="user">
                    <a href="#" class="btn">Add New</a>
                    <img src="notifications.png" alt="">
                    <div class="img-case">
                        <img src="user.png" alt="">
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
			
			<div class="row content-1">
				<div class="cards">
					<div class="card">
						<div class="box">
							<h1>+10000€</h1>
							<h3>Balance</h3>
						</div>
						<div class="icon-case">
							<img src="../img/icons/swap_vert.png" alt="">
						</div>
					</div>
					<div class="card">
						<div class="box">
							<h1>-1000€</h1>
							<h3>This Month</h3>
						</div>
						<div class="icon-case">
							<img src="../img/icons/swap_vert.png" alt="">
						</div>
					</div>
					<div class="card">
						<div class="box">
							<h1>-1000€</h1>
							<h3>This Month</h3>
						</div>
						<div class="icon-case">
							<img src="../img/icons/swap_vert.png" alt="">
						</div>
					</div>
				</div>

				<div class="todo">
					<div class="title">
						<h2>Todo</h2>
						<a href="#" class="btn">View All</a>
					</div>
					<table>
						<tr>
							<th>Author</th>
							<th>Title</th>
							<th>Status</th>
						</tr>
						<tr>
							<td>Jonny</td>
							<td>Lavare i piatti</td>
						</tr>
						<tr>
							<td>Jonny</td>
							<td>Lavare bagno</td>
						</tr>
						<tr>
							<td>Jonny</td>
							<td>Pulire frigorifero</td>
						</tr>
					</table>
				</div>

				<div class="turn">
					<div class="title">
						<h2>Turns</h2>
						<a href="#" class="btn">View All</a>
					</div>
					<table>
						<tr>
							<th>Author</th>
							<th>Title</th>
							<th>Status</th>
						</tr>
						<tr>
							<td>Jonny</td>
							<td>Lavare i piatti</td>
						</tr>
						<tr>
							<td>Jonny</td>
							<td>Lavare bagno</td>
						</tr>
						<tr>
							<td>Jonny</td>
							<td>Pulire frigorifero</td>
						</tr>
					</table>
				</div>

			</div>

			            
			<div class="row content-2">
                <div class="recent-payments">
                    <div class="title">
                        <h2>Recent Payments</h2>
                        <a href="#" class="btn">View All</a>
                    </div>
                    <table>
                        <tr>
                            <th>Name</th>
                            <th>School</th>
                            <th>Amount</th>
                            <th>Option</th>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>St. James College</td>
                            <td>$120</td>
                            <td><a href="#" class="btn">View</a></td>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>St. James College</td>
                            <td>$120</td>
                            <td><a href="#" class="btn">View</a></td>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>St. James College</td>
                            <td>$120</td>
                            <td><a href="#" class="btn">View</a></td>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>St. James College</td>
                            <td>$120</td>
                            <td><a href="#" class="btn">View</a></td>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>St. James College</td>
                            <td>$120</td>
                            <td><a href="#" class="btn">View</a></td>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>St. James College</td>
                            <td>$120</td>
                            <td><a href="#" class="btn">View</a></td>
                        </tr>
                    </table>
                </div>
                <div class="new-students">
                    <div class="title">
                        <h2>New Students</h2>
                        <a href="#" class="btn">View All</a>
                    </div>
                    <table>
                        <tr>
                            <th>Profile</th>
                            <th>Name</th>
                            <th>option</th>
                        </tr>
                        <tr>
                            <td><img src="user.png" alt=""></td>
                            <td>John Steve Doe</td>
                            <td><img src="info.png" alt=""></td>
                        </tr>
                        <tr>
                            <td><img src="user.png" alt=""></td>
                            <td>John Steve Doe</td>
                            <td><img src="info.png" alt=""></td>
                        </tr>
                        <tr>
                            <td><img src="user.png" alt=""></td>
                            <td>John Steve Doe</td>
                            <td><img src="info.png" alt=""></td>
                        </tr>
                        <tr>
                            <td><img src="user.png" alt=""></td>
                            <td>John Steve Doe</td>
                            <td><img src="info.png" alt=""></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>