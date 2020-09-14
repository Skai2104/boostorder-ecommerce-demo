<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Boostorder eCommerce Demo</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="css/fontawesome/all.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/b-1.6.2/b-colvis-1.6.2/fh-3.1.7/sp-1.1.1/datatables.min.css" />
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <a class="navbar-brand" href="index.php">Boostorder eCommerce Demo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item mr-3">
          <a class="nav-link" href="cart.php">
            <i class="fas fa-shopping-cart"></i>
            <span id="badge-cart" class="badge badge-danger align-top"></span>
          </a>
        </li>
        <li class="nav-item dropdown mr-3">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell"></i>
            <span id="badge-notification" id="badge-cart" class="badge badge-danger align-top"></span>
          </a>
          <div id="dropdown-notification" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown"></div>
        </li>
        <li class="nav-item">
          <a class="btn btn-primary" href="orders.php">My Orders</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mb-5">