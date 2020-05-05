<?php
include_once('auth.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Medicraft</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="assets/css/style.css" rel="stylesheet">



</head>

<body>


    <header class='shadow'>
        <div class='navbar navbar-expand-md bg-dark'>
            <nav class='top-nav ml-auto'>
                <ul class="navbar-nav">
                    <?php if (!$login) : ?>
                        <li class="nav-item">
                            <a href="login.php" class="nav-link">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="register.php" class="nav-link">Register</a>
                        </li>
                    <?php else : ?>
                        <li class="nav-item">
                            <a href="cart.php" class="nav-link">Cart</a>
                        </li>
                        <li class="nav-item">
                            <a href="home.php" class="nav-link">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="/"><img src="assets/img/medi.jpeg" class="rounded float-left" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                    <span class="navbar-toggler-icon"> </span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">HOME</a>
                        </li>
                        <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        PRODUCTS
      </a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="/products.php">All products</a>
        <a class="dropdown-item" href="/handicrafts.php">Handicrafts</a>
        <a class="dropdown-item" href="/herbs.php">Herbs</a>
      </div>
    </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="#">ABOUT US</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">OUR TEAM</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact_us.php">CONTACT US</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <?php if (isset($_SESSION['message'])) : ?>
        <div class="container padding">

            <div class="alert alert-primary">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php
            $_SESSION['message'] = null;
            ?>
        </div>

    <?php endif; ?>