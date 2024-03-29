
<?php
include('user_session.php');

$isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile")); 
if($isMob){ 
  $newTR_loc = "cashier_new_transaction";
}else{ 
  $newTR_loc = "cashier_new_transaction2";
}

$sql2="SELECT
DATE_FORMAT(tb_payments.date,'%M %d,%Y') AS date1,
FORMAT(SUM(tb_payments.total),2)AS sales,
COUNT(tb_payments.id) AS paidcustomers
FROM tb_payments
WHERE tb_payments.date='".date("Y-m-d")."'";
$result2=mysqli_query($db,$sql2);
$row2 = mysqli_fetch_assoc($result2);

$sql2b = "SELECT
SUM(tb_cart.quantity) AS paiditems
FROM tb_cart
WHERE tb_cart.date='".date("Y-m-d")."'";
$result2b=mysqli_query($db,$sql2b);
$row2b = mysqli_fetch_assoc($result2b);

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
CONCAT(FORMAT(SUM(tb_products.available*tb_products.price), 2)) AS amount
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


$sql13="SELECT
SUM(tb_cart.quantity) AS items
FROM tb_transactions
JOIN tb_cart ON tb_transactions.id=tb_cart.transaction_id
WHERE tb_transactions.status='unpaid';";
$result13=mysqli_query($db,$sql13);
$row13 = mysqli_fetch_assoc($result13);

  //$TR = $_SESSION['id']."-".date("Ymd")."-".date("His");
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


    <div class="dropdown position-fixed bottom-0 end-0 mb-3 me-3">
      <div class="btn-group-vertical">
        <button type="button" class="btn btn-success btn-sm" accesskey="c" onclick="location.href='<?php echo $newTR_loc;?>.php?date=<?php echo date('Y-m-d')?>'" >ALT+C</button>
        <button type="button" class="btn btn-outline-success fw-bold" accesskey="c" onclick="location.href='<?php echo $newTR_loc;?>.php?date=<?php echo date('Y-m-d')?>'" >NEW TR</button>
      </div>
      <div class="btn-group-vertical">
        <button type="button" class="btn btn-warning btn-sm" accesskey="v" onclick="location.href='cashier_new_transaction3.php?date=<?php echo date('Y-m-d')?>'" >ALT+V</button>
        <button type="button" class="btn btn-outline-warning fw-bold" accesskey="v" onclick="location.href='cashier_new_transaction3.php?date=<?php echo date('Y-m-d')?>'" >WS TR</button>
      </div>
    </div>
    
 
  
  

    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">R-Click POS</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
 
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-body-tertiary sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
      <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="cashier_dashboard.php">
              <span data-feather="home" class="align-text-bottom"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cashier_transactions_history.php">
              <span data-feather="file" class="align-text-bottom"></span>
              Paid Transactions
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cashier_unpaid_transactions.php">
              <span data-feather="file" class="align-text-bottom"></span>
              Unpaid Transactions
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cashier_products.php">
              <span data-feather="shopping-cart" class="align-text-bottom"></span>
              Products
            </a>
          </li>
        </ul>
        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
          <span>Account</span>
        </h6>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <span data-feather="user" class="align-text-bottom"></span>
              <strong><?php echo $name; ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="cashier_settings.php">Settings</a></li>
                <li><a class="dropdown-item" href="signout.php">Sign out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10">
    <div class="">
        <div class="row">
          
          <div class="col text-center">
            <div class="card-body p-2">
                <h6 class="fw-bold mt-0" title="Number of Customers"><?php echo date("M j,Y");?></h6>
                <h3 class="text-success"><?php echo $row2['sales'];?></h3>
                <p class="mb-0 text-muted">
                <span class="text-success fw-bold"><?php echo $row2['paidcustomers'];?></span>
                <span class="text-nowrap me-2">Receipts</span>
                <span class="text-success fw-bold"><?php echo $row2b['paiditems'];?></span>
                <span class="text-nowrap">Products Sold</span> 
                </p>
            </div>
          </div>
          
          <div class="col text-center">
            <div class="card-body p-2">
                <h6 class="text-muted fw-normal mt-0" title="Number of Customers">Amount Receivables</h6>
                <h3 class="text-danger"><?php echo $row4['unpaid'];?></h3>
                <p class="mb-0 text-muted">
                <span class="text-danger fw-bold"><?php echo $row3['transactions'];?></span>
                <span class="text-nowrap me-2">Accounts</span>
                <span class="text-danger fw-bold"><?php echo $row13['items'];?></span>
                <span class="text-nowrap">Items</span> 
                </p>
            </div>
          </div>

          <div class="col text-center">
            <div class="card-body p-2">
                <h6 class="text-muted fw-normal mt-0" title="Number of Customers">Low Stocks</h6>
                <h3 class="text-danger"><?php echo $row6['products']; ?></h3>
                <p class="mb-0 text-muted">
                <span class="text-danger fw-bold"><?php echo $row7['products']; ?></span>
                <span class="text-nowrap">Zero Stocks</span>  
                </p>
            </div>
          </div>
          
        </div>
      </div>

      <h6 class="mt-3 text-center text-muted">Recent Paid Transactions</h6>
      <div class="table-responsive">
        <table class="table table-hover table-sm">
          <thead>
            <tr class="text-muted">
              <th scope="col">Time</th>
              <th scope="col">Items</th>
              <th scope="col">Total</th>
              <th scope="col">Payment</th>
              <th scope="col">Change</th>
            </tr>
          </thead>
          <tbody>
            <?php
                $sql="SELECT *
                FROM (SELECT
                        tb_transactions.id,
                        tb_transactions.time,
                        tb_transactions.date
                        FROM tb_transactions WHERE tb_transactions.status='paid') AS A
                JOIN (SELECT
                        tb_payments.id,
                        COUNT(tb_cart.transaction_id) as items,
                        CONCAT(FORMAT(SUM(tb_cart.price*tb_cart.quantity), 2)) AS total2,
                        tb_payments.total,
                        CONCAT(tb_payments.payment1,' - ',FORMAT(tb_payments.payment, 2)) AS payment,
                          tb_payments.change1
                        FROM tb_payments
                      JOIN tb_cart ON tb_payments.id=tb_cart.transaction_id
                      WHERE tb_payments.date='".date("Y-m-d")."'
                        GROUP BY tb_payments.id) AS B
                ON A.id=B.id
                GROUP BY A.id
                ORDER BY A.time DESC";
                                                                                    
                $result = mysqli_query($db,$sql);

                if (mysqli_num_rows($result) > 0) 
                {
                foreach($result as $items)
                {
            ?>
            <tr onclick="location.href='cashier_transaction.php?id=<?php echo $items['id'];?>'">  
                <td><?php echo $items['time']; ?></td>
                <td><?php echo $items['items']; ?></td>
                <td><?php echo $items['total']; ?></td>
                <td><?php echo $items['payment']; ?></td>
                <td><?php echo $items['change1']; ?></td>
            </tr>
            <?php
            } 
            } 
            ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</script><script src="dashboard.js"></script>
  </body>
</html>
