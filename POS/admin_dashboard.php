
<?php
include('user_session.php');
$sql1="SELECT
CONCAT(FORMAT(SUM(tb_payments.total), 2)) AS paid
FROM tb_payments";
$result1=mysqli_query($db,$sql1);
$row1 = mysqli_fetch_assoc($result1);

$sql2="SELECT
DATE_FORMAT(tb_payments.date,'%M %d,%Y') AS date1,
CONCAT(FORMAT(SUM(tb_cart.price*tb_cart.quantity), 2)) AS sales,
(SELECT COUNT(tb_payments.id)
FROM tb_payments WHERE tb_payments.date='".date("Y-m-d")."') AS paidcustomers,
SUM(tb_cart.quantity) AS paiditems
FROM tb_payments
JOIN tb_cart ON tb_payments.id=tb_cart.transaction_id
WHERE tb_payments.date='".date("Y-m-d")."'";
$result2=mysqli_query($db,$sql2);
$row2 = mysqli_fetch_assoc($result2);

$sql3="SELECT
COUNT(tb_transactions.id)AS transactions
FROM tb_transactions
WHERE tb_transactions.status='unpaid'";
$result3=mysqli_query($db,$sql3);
$row3 = mysqli_fetch_assoc($result3);

$sql4="SELECT
CONCAT(FORMAT(SUM(tb_cart.total), 2)) AS unpaid
FROM tb_transactions
JOIN tb_cart ON tb_transactions.id=tb_cart.transaction_id
WHERE tb_transactions.status='unpaid'";
$result4=mysqli_query($db,$sql4);
$row4 = mysqli_fetch_assoc($result4);

$sql5 = "SELECT 
CONCAT(FORMAT(SUM(tb_products.available*tb_products.capital), 2)) AS amount
FROM tb_products";
$result5=mysqli_query($db,$sql5);
$row5 = mysqli_fetch_assoc($result5);

$sql6 = "SELECT
COUNT(tb_products.id)AS products
FROM tb_products
WHERE tb_products.available <= 5 AND tb_products.available
NOT IN (SELECT tb_products.available FROM tb_products WHERE tb_products.available='0')";
$result6=mysqli_query($db,$sql6);
$row6 = mysqli_fetch_assoc($result6);

$sql7 = "SELECT
COUNT(tb_products.id)AS products
FROM tb_products
WHERE tb_products.available='0'";
$result7=mysqli_query($db,$sql7);
$row7 = mysqli_fetch_assoc($result7);

$sql8="SELECT DATE_FORMAT(tb_payments.date,'%b %d') AS date,
SUM(tb_cart.price*tb_cart.quantity) AS sales
FROM tb_payments 
JOIN tb_cart ON tb_payments.id=tb_cart.transaction_id
WHERE tb_payments.date NOT IN ('".date("Y-m-d")."')
GROUP BY tb_payments.date DESC
LIMIT 7";
$result8=mysqli_query($db,$sql8);

$sql9="SELECT
date_format(tb_payments.date,'%b')AS month,
SUM(tb_cart.price*tb_cart.quantity)AS amount
FROM tb_payments
LEFT JOIN tb_cart ON tb_payments.id=tb_cart.transaction_id
WHERE year(tb_payments.date)='".date('Y')."'
GROUP BY year(tb_payments.date),month(tb_payments.date)
ORDER BY year(tb_payments.date),month(tb_payments.date) ASC
LIMIT 12";
$result9=mysqli_query($db,$sql9);

$sql10="SELECT
date_format(tb_payments.date,'%b')AS month,
SUM(tb_cart.price*tb_cart.quantity)AS amount
FROM tb_payments
LEFT JOIN tb_cart ON tb_payments.id=tb_cart.transaction_id
WHERE year(tb_payments.date)='".date('Y')."'
GROUP BY year(tb_payments.date),month(tb_payments.date)
ORDER BY year(tb_payments.date),month(tb_payments.date) ASC
LIMIT 12";
$result10=mysqli_query($db,$sql10);

if(!empty($_GET['selecteddate'])) {

  $dateS=date_create($_GET['selecteddate']);
  $TR = $_SESSION['id']."-".date_format($dateS,"Ymd")."-".date("His");
  header("location: admin_new_transaction.php?id=".$TR."&date=".date_format($dateS,"Y-m-d"));
}

$sql11="SELECT
SUM(tb_cart.quantity) AS items
FROM tb_cart";
$result11=mysqli_query($db,$sql11);
$row11 = mysqli_fetch_assoc($result11);

$sql12="SELECT
COUNT(tb_payments.id)AS transactions
FROM tb_payments";
$result12=mysqli_query($db,$sql12);
$row12 = mysqli_fetch_assoc($result12);

$sql13="SELECT
SUM(tb_cart.quantity) AS items
FROM tb_transactions
JOIN tb_cart ON tb_transactions.id=tb_cart.transaction_id
WHERE tb_transactions.status='unpaid';";
$result13=mysqli_query($db,$sql13);
$row13 = mysqli_fetch_assoc($result13);

$sql14="SELECT 
FORMAT(AVG(tb_payments.total), 2) AS daily
FROM tb_payments";
$result14=mysqli_query($db,$sql14);
$row14 = mysqli_fetch_assoc($result14);

$sql15="SELECT
FORMAT(SUM(tb_payments.total) / 12, 2) AS monthly
FROM tb_payments
WHERE YEAR(tb_payments.date) = year(curdate())";
$result15=mysqli_query($db,$sql15);
$row15 = mysqli_fetch_assoc($result15);

$sql16="SELECT
tb_products.category,
SUM(tb_cart.quantity) AS pcs
FROM tb_cart
JOIN tb_products ON tb_cart.product_id=tb_products.id
GROUP BY tb_products.category
ORDER BY pcs DESC
LIMIT 5";
$result16=mysqli_query($db,$sql16);

$sql17="SELECT
tb_products.category,
SUM(tb_cart.quantity) AS pcs
FROM tb_cart
JOIN tb_products ON tb_cart.product_id=tb_products.id
GROUP BY tb_products.category
ORDER BY pcs DESC
LIMIT 5";
$result17=mysqli_query($db,$sql17);


$sql19 = "SELECT
FORMAT(SUM(tb_products.capital*tb_cart.quantity) , 2) AS capital,
FORMAT(SUM(tb_cart.price*tb_cart.quantity - tb_products.capital*tb_cart.quantity) , 2) AS profit
FROM tb_transactions
INNER JOIN tb_cart ON tb_transactions.id=tb_cart.transaction_id
LEFT JOIN tb_products ON tb_cart.product_id=tb_products.id
WHERE tb_transactions.status='paid'";
$result19=mysqli_query($db,$sql19);
$row19 = mysqli_fetch_assoc($result19);

?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.111.3">
    <title>DASHBOARD</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        width: 100%;
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .btn-bd-primary {
        --bd-violet-bg: #712cf9;
        --bd-violet-rgb: 112.520718, 44.062154, 249.437846;

        --bs-btn-font-weight: 600;
        --bs-btn-color: var(--bs-white);
        --bs-btn-bg: var(--bd-violet-bg);
        --bs-btn-border-color: var(--bd-violet-bg);
        --bs-btn-hover-color: var(--bs-white);
        --bs-btn-hover-bg: #6528e0;
        --bs-btn-hover-border-color: #6528e0;
        --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
        --bs-btn-active-color: var(--bs-btn-hover-color);
        --bs-btn-active-bg: #5a23c8;
        --bs-btn-active-border-color: #5a23c8;
      }
      .bd-mode-toggle {
        z-index: 1500;
      }
      body {
  font-size: .875rem;
}

.feather {
  width: 16px;
  height: 16px;
}

/*
 * Sidebar
 */

.sidebar {
  position: fixed;
  top: 0;
  /* rtl:raw:
  right: 0;
  */
  bottom: 0;
  /* rtl:remove */
  left: 0;
  z-index: 100; /* Behind the navbar */
  padding: 48px 0 0; /* Height of navbar */
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}


.sidebar-sticky {
  height: calc(100vh - 48px);
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}

.sidebar .nav-link {
  font-weight: 500;
  color: #333;
}

.sidebar .nav-link .feather {
  margin-right: 4px;
  color: #727272;
}

.sidebar .nav-link.active {
  color: #2470dc;
}

.sidebar .nav-link:hover .feather,
.sidebar .nav-link.active .feather {
  color: inherit;
}

.sidebar-heading {
  font-size: .75rem;
}

/*
 * Navbar
 */

.navbar-brand {
  padding-top: .75rem;
  padding-bottom: .75rem;
  background-color: rgba(0, 0, 0, .25);
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
}

.navbar .navbar-toggler {
  top: .25rem;
  right: 1rem;
}

.navbar .form-control {
  padding: .75rem 1rem;
}

.form-control-dark {
  color: #fff;
  background-color: rgba(255, 255, 255, .1);
  border-color: rgba(255, 255, 255, .1);
}

.form-control-dark:focus {
  border-color: transparent;
  box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
}

  </style>

    
  </head>
  <body>


    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3" hidden>
      <button class="btn btn-bd-primary d-flex align-items-center"
              type="button"
              data-bs-toggle="dropdown">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
              </svg>
      </button>
      <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
        <li>
          <button type="button" class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-theme-value="light" aria-pressed="false">
           New Transaction
          </button>
                  
        </li>
      </ul>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                          <h6 class="modal-title" id="exampleModalLabel">CREATE TRANSACTION</h6>
                          </div>
                          <div class="modal-body">
                            <form method="get" enctype="multipart/form-data">
                              <div class="mb-3">
                                
                              <input id="startDate" type="date" name="selecteddate" class="form-control" id="validationDefault01" required>
                                
                              </div>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-danger">Create</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
  
  

    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">R-Click Solutions POS: <i><?php echo $company_name; ?></i></a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
 
</header>

<div class="container-fluid">
  <div class="row">
  <?php
  include 'admin_navbar.php';
  ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 bg-light">
    <div class="">
    <h6 class="text-center m-2"><?php echo date("F j,Y");?></h6>
        <div class="row">

          <div class="col text-start p-2" onClick="window.location='admin_yearly_history.php';">
            <div class="card-body p-2 border-start border-4 shadow rounded border-success bg-white">
            <div class="row">
              <p class="col m-0 text-success">
                REVENUE
              </p>
              <p class="col m-0 d-flex justify-content-end text-success">
              <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
              </svg>
              </p>
            </div>
          
                <h4 class="text-success"><span>&#8369;<?php
                  $paid=null;
                  if (empty($row1['paid'])) {
                    $paid = 0;
                  } else {
                    $paid = $row1['paid'];
                  }
                  echo $paid;
                  ?></span>
                </h4>
                <p class="mb-0 text-muted">
                <span class="text-success fw-bold"><?php echo $row12['transactions'];?></span>
                <span class="text-nowrap me-2">Receipts</span>
                <br>
                <span class="text-success fw-bold">
                <?php
                  $items=null;
                  if (empty($row11['items'])) {
                    $items = 0;
                  } else {
                    $items = $row11['items'];
                  }
                  echo $items;
                  ?>
                </span>
                <span class="text-nowrap">Products</span> 
                </p>
            </div>
          </div>

          <div class="col text-start p-2">
            <div class="card-body p-2 border-start border-4 shadow rounded border-primary bg-white">
            <div class="row">
              <p class="col m-0 text-primary">
                NET 
              </p>
              <p class="col m-0 d-flex justify-content-end text-primary">
              <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
              </svg>
              </p>
            </div>
                <h4 class="text-primary"><span>&#8369;</span><?php
                  $profit=null;
                  if (empty($row19['profit'])) {
                    $profit = 0;
                  } else {
                    $profit = $row19['profit'];
                  }
                  echo $profit;
                  ?></span>
                </h4>
                <p class="mb-0 text-muted">
                  <br>
                <span class="text-primary fw-bold"><span>&#8369;</span><?php
                  $capital=null;
                  if (empty($row19['capital'])) {
                    $capital = 0;
                  } else {
                    $capital = $row19['capital'];
                  }
                  echo  $capital;
                  ?></span>
                <span class="text-nowrap me-2">Capital</span>
                </p>
            </div>
          </div>

          <div class="col text-start p-2">
            <div class="card-body p-2 border-start border-4 shadow rounded border-warning bg-white">
                <div class="row">
                  <p class="col m-0 text-warning">
                    MO AVG
                  </p>
                  <p class="col m-0 d-flex justify-content-end text-warning">
                  <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                  </svg>
                  </p>
                </div>
                <h4 class="text-warning"><span>&#8369;</span><?php
                  $monthly=null;
                  if (empty($row15['monthly'])) {
                    $monthly = 0;
                  } else {
                    $monthly = $row15['monthly'];
                  }
                  echo $monthly;
                  ?></span>
                </h4>
                <br>
                <p class="mb-0 text-muted">
                <span class="text-warning fw-bold">
                <span>&#8369;</span><?php
                  $daily=null;
                  if (empty($row14['daily'])) {
                    $daily = 0;
                  } else {
                    $daily = $row14['daily'];
                  }
                  echo $daily;
                  ?>
                </span>
                <span class="text-nowrap">Daily</span> 
                </p>
            </div>
          </div>

          <div class="col text-start p-2" onClick="window.location='admin_unpaid_transactions.php';">
            <div class="card-body p-2 border-start border-4 shadow rounded border-danger bg-white">
                <div class="row">
                  <p class="col m-0 text-danger">
                    RECEIVABLE
                  </p>
                  <p class="col m-0 d-flex justify-content-end text-danger">
                  <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                    <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z"/>
                  </svg>
                  </p>
                </div>
                <h4 class="text-danger"><span>&#8369;<?php
                  $unpaid=null;
                  if (empty($row4['unpaid'])) {
                    $unpaid = 0;
                  } else {
                    $unpaid = $row4['unpaid'];
                  }
                  echo $unpaid;
                  ?></span>
                </h4>
                <p class="mb-0 text-muted">
                <span class="text-danger fw-bold"><?php echo $row3['transactions'];?></span>
                <span class="text-nowrap me-2">Accounts</span>
                <br>
                <span class="text-danger fw-bold">
                <?php
                  $items=null;
                  if (empty($row13['items'])) {
                    $items = 0;
                  } else {
                    $items = $row13['items'];
                  }
                  echo $items;
                  ?>
                </span>
                <span class="text-nowrap">Items</span> 
                </p>
            </div>
          </div>
          
        </div>

        <div class="row">

          <div class="col-md text-start p-2 ">
            <div class="card-body p-2 border-top border-3 shadow rounded border-success bg-white">
            <h6 class="">Monthly Sales Chart <?php echo date('Y')?></h6>
            <canvas class="my-4 w-100" id="myChart" width="200" height="100"></canvas>
            </div>
          </div>

          <div class="col-md text-start p-2 ">
            <div class="card-body p-2 border-top border-3 shadow rounded border-success bg-white">
            <h6 class="">Top 5 Selling Categories</h6>
          <canvas class="my-4 w-100" id="myChart2" width="200" height="140"></canvas>
            </div>
          </div>

        </div>

        <div class="row">

        <div class="col text-start p-2">
            <div class="card-body p-2 border-start border-4 shadow rounded border-info bg-white">
                <div class="row">
                  <p class="col m-0 text-info">
                    CAPITAL INVENTORY
                  </p>
                  <p class="col m-0 d-flex justify-content-end text-info">
                  <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                  </svg>
                  </p>
                </div>
                <h4 class="text-info"><span>&#8369;<?php
                  $amount=null;
                  if (empty($row5['amount'])) {
                    $amount = 0;
                  } else {
                    $amount = $row5['amount'];
                  }
                  echo $amount;
                  ?></span>
                </h4>
                <p class="mb-0 text-muted">
                <span class="text-info fw-bold"><?php echo $row6['products']; ?></span>
                <span class="text-nowrap me-2">Low Stocks</span>
                <br>
                <span class="text-info fw-bold">
                <?php echo $row7['products']; ?>
                </span>
                <span class="text-nowrap">Zero Stocks</span> 
                </p>
            </div>
          </div>

          <div class="col text-start p-2" onClick="window.location='admin_transactions.php?date=<?php echo date("Y-m-d") ?>';">
            <div class="card-body p-2 border-start border-4 shadow rounded border-success bg-white">
                <div class="row">
                  <p class="col m-0 text-success">
                  <?php echo date("F j,Y");?>
                  </p>
                  <p class="col m-0 d-flex justify-content-end text-success">
                  <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                    <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
                    <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                    <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>
                  </svg>
                  </p>
                </div>
                <h4 class="text-success"><span>&#8369;<?php
                  $today_sales=null;
                  if (empty($row2['sales'])) {
                    $today_sales = 0;
                  } else {
                    $today_sales = $row2['sales'];
                  }
                  echo $today_sales;
                  ?></span>
                </h4>
                <p class="mb-0 text-muted">
                <span class="text-success fw-bold"><?php echo $row2['paidcustomers'];?></span>
                <span class="text-nowrap me-2">Receipts</span>
                <br>
                <span class="text-success fw-bold">
                <?php
                  $paid_items=null;
                  if (empty($row2['paiditems'])) {
                    $paid_items = 0;
                  } else {
                    $paid_items = $row2['paiditems'];
                  }
                  echo $paid_items;
                  ?>
                </span>
                <span class="text-nowrap">Items</span> 
                </p>
            </div>
          </div>

        </div>

      </div>


    </main>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</script>
<script>
  /* globals Chart:false, feather:false */

(() => {
  'use strict'

  feather.replace({ 'aria-hidden': 'true' })

  // Graphs
  const ctx = document.getElementById('myChart')
  // eslint-disable-next-line no-unused-vars
  const myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [
        <?php while($row10 = mysqli_fetch_array($result10)):;?>
          ['<?php echo $row10['month'];?>'],
          <?php endwhile; ?>
      ],
      datasets: [{
        data: [
          <?php while($row9 = mysqli_fetch_array($result9)):;?>
          <?php echo $row9['amount'];?>,
          <?php endwhile; ?>
        ],
        lineTension: 0,
        backgroundColor: '#610C9F'
      }]
    },
    options: {
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          boxPadding: 3
        }
      }
    }
  })
}

)()

</script>
<script>
  /* globals Chart:false, feather:false */

(() => {
  'use strict'

  feather.replace({ 'aria-hidden': 'true' })

  // Graphs
  const ctx = document.getElementById('myChart2')
  // eslint-disable-next-line no-unused-vars
  const myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: [
        <?php while($row16 = mysqli_fetch_array($result16)):;?>
          ['<?php echo $row16['category'];?>'],
          <?php endwhile; ?>
  ],
      datasets:  [{
    label: 'My First Dataset',
    data: [<?php while($row17 = mysqli_fetch_array($result17)):;?>
          <?php echo $row17['pcs'];?>,
          <?php endwhile; ?>],
    backgroundColor: [
      '#0d6efd','#DA0C81','#198754','#FFB000','#dc3545'
    ],
    hoverOffset: 4
  }]
    },
    options: {
      aspectRatio: 2,
      plugins: {
        legend: {
          display: true
        }
        
      }
    }
  })
}
)()

</script>

  </body>
</html>
