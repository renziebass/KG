
<?php
include('user_session.php');
$sql1="SELECT
COUNT(tb_payments.id)AS transactions
FROM tb_payments
WHERE MONTH(tb_payments.date)='".$_GET['m']."' AND YEAR(tb_payments.date)='".$_GET['y']."'";
$result1=mysqli_query($db,$sql1);
$row1 = mysqli_fetch_assoc($result1);

$sql2="SELECT
SUM(tb_cart.quantity)AS items
FROM tb_payments
LEFT JOIN tb_cart ON tb_payments.id=tb_cart.transaction_id
WHERE MONTH(tb_payments.date)='".$_GET['m']."' AND YEAR(tb_payments.date)='".$_GET['y']."'
GROUP BY year(tb_payments.date),month(tb_payments.date)
ORDER BY year(tb_payments.date),month(tb_payments.date) DESC";
$result2=mysqli_query($db,$sql2);
$row2 = mysqli_fetch_assoc($result2);

$sql3="SELECT
CONCAT(FORMAT(SUM(tb_cart.price*tb_cart.quantity), 2)) AS paid
FROM tb_payments
LEFT JOIN tb_cart ON tb_payments.id=tb_cart.transaction_id
WHERE MONTH(tb_payments.date)='".$_GET['m']."' AND YEAR(tb_payments.date)='".$_GET['y']."'
GROUP BY year(tb_payments.date),month(tb_payments.date)
ORDER BY year(tb_payments.date),month(tb_payments.date) DESC";
$result3=mysqli_query($db,$sql3);
$row3 = mysqli_fetch_assoc($result3);

$sql4="SELECT
FORMAT(SUM(tb_payments.total) / 24, 2) AS daily
FROM tb_payments
WHERE MONTH(tb_payments.date)='".$_GET['m']."' AND YEAR(tb_payments.date)='".$_GET['y']."'";
$result4=mysqli_query($db,$sql4);
$row4 = mysqli_fetch_assoc($result4);

$sql5="SELECT
FORMAT(SUM(tb_products.capital*tb_cart.quantity) , 2) AS capital,
FORMAT(SUM(tb_cart.price*tb_cart.quantity - tb_products.capital*tb_cart.quantity) , 2) AS profit
FROM tb_transactions
INNER JOIN tb_cart ON tb_transactions.id=tb_cart.transaction_id
LEFT JOIN tb_products ON tb_cart.product_id=tb_products.id
WHERE tb_transactions.status='paid' AND MONTH(tb_transactions.date)='".$_GET['m']."' AND YEAR(tb_transactions.date)='".$_GET['y']."';";
$result5=mysqli_query($db,$sql5);
$row5 = mysqli_fetch_assoc($result5);
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.111.3">
    <title><?php 
      $month = $_GET['m'];
      $year = $_GET['y'];
      
      $date=date_create();
      date_date_set($date,$year,$month,1);
      echo date_format($date,"F Y");
      ?></title>
 
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
            <a class="nav-link" aria-current="page" href="admin_dashboard.php">
              <span data-feather="home" class="align-text-bottom"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="admin_yearly_history.php">
              <span data-feather="file" class="align-text-bottom"></span>
              Paid Transactions
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_unpaid_transactions.php">
              <span data-feather="file" class="align-text-bottom"></span>
              Unpaid Transactions
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_products.php">
              <span data-feather="shopping-cart" class="align-text-bottom"></span>
              Products
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_inventory.php">
              <span data-feather="bar-chart-2" class="align-text-bottom"></span>
              Inventory
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_users.php">
              <span data-feather="users" class="align-text-bottom"></span>
              Users
            </a>
          </li>
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
          <span>Quick Links</span>
        </h6>
        <ul class="nav flex-column mb-5">
          <li class="nav-item">
            <a class="nav-link" href="admin_generateqr.php">
              <span data-feather="file-text" class="align-text-bottom"></span>
              QR Generator
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_add_products.php">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Add new product
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_product_restock.php?search=a">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Re-stock product
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_add_category.php">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Add new category
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_add_supplier.php">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Add new supplier
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_add_mc.php">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Add new brand & model
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_add_user.php">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Add new user
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_add_discount.php">
              <span data-feather="file-text" class="align-text-bottom"></span>
              Add new discounts
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
                <li><a class="dropdown-item" href="admin_settings.php">Settings</a></li>
                <li><a class="dropdown-item" href="signout.php">Sign out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10">
    <div class="d-flex justify-content-end mt-3 mb-3">
    <button class="btn btn-secondary" onclick="printDiv();"type="button"><span data-feather="printer" class="align-text-bottom"></button>
            <script>
              function printDiv() {
              var printContents = document.getElementById("page").innerHTML;
              var originalContents = document.body.innerHTML;
              document.body.innerHTML = printContents;
              window.print();
              document.body.innerHTML = originalContents;
              }
              function refreshDiv() {
              location.reload();
              }
            </script>
    </div>
      <div class="table" id="page">

      <h6 class="text-center mb-1"><?php 
      $month = $_GET['m'];
      $year = $_GET['y'];
      
      $date=date_create();
      date_date_set($date,$year,$month,1);
      echo date_format($date,"F Y");
      ?></h6>

      <div class="">
        <div class="row">
          
          <div class="col text-center">
            <div class="card-body">
                <h6 class="text-muted fw-normal mt-0" title="Number of Customers">Receipts</h6>
                <h3 class=""><?php echo $row1['transactions'];?></h3>
                <p class="mb-0 text-muted">
                <span class="text-primary fw-bold"><?php echo $row2['items'];?></span>
                <span class="text-nowrap">Products Sold</span>  
                </p>
            </div>
          </div>
          
          <div class="col text-center">
            <div class="card-body">
                <h6 class="text-muted fw-normal mt-0" title="Number of Customers">Capital</h6>
                <h3 class=""><?php echo $row5['capital'];?></h3>
                <p class="mb-0 text-muted">
                <span class="text-primary fw-bold"><?php echo $row5['profit'];?></span>
                <span class="text-nowrap">Net Profit</span>  
                </p>
            </div>
          </div>

          <div class="col text-center">
            <div class="card-body">
                <h6 class="text-muted fw-normal mt-0" title="Number of Customers">Revenue</h6>
                <h3 class=""><?php echo $row3['paid'];?></h3>
                <p class="mb-0 text-muted">
                <span class="text-primary fw-bold"><?php echo $row4['daily'];?></span>
                <span class="text-nowrap">Daily Avg</span>  
                </p>
            </div>
          </div>
          
        </div>
      </div>
        <table class="table table-hover table-sm mt-3">
          <thead>
            <tr class="text-muted">
              <th scope="col">Date</th>
              <th scope="col">Customers</th>
              <th scope="col">Items Sold</th>
              <th scope="col">Sales</th>
            </tr>
          </thead>
          <tbody>
            <?php
                $sql="SELECT *
                FROM (SELECT
                        tb_payments.date,
                        DATE_FORMAT(tb_payments.date,'%M %d,%Y') AS date1,
                        COUNT(tb_payments.payment) AS customers
                        FROM tb_payments
                        WHERE MONTH(tb_payments.date)='".$_GET['m']."' AND YEAR(tb_payments.date)='".$_GET['y']."'
                       GROUP BY tb_payments.date) AS A
                JOIN (SELECT
                      SUM(tb_cart.quantity) AS items,
                      CONCAT(FORMAT(SUM(tb_cart.price*tb_cart.quantity), 2)) AS amount,
                      DATE_FORMAT(tb_transactions.date,'%M %d,%Y') AS date1
                      FROM tb_transactions
                      JOIN tb_cart ON tb_transactions.id=tb_cart.transaction_id
                      WHERE tb_transactions.status='paid'
                      GROUP BY tb_transactions.date) AS B
                ON A.date1=B.date1
                ORDER BY A.date DESC";
                                                                                    
                $result = mysqli_query($db,$sql);

                if (mysqli_num_rows($result) > 0) 
                {
                foreach($result as $items)
                {
            ?>
            <tr onclick="location.href='admin_transactions.php?date=<?php echo $items['date'];?>'">  
                <td><?php echo $items['date1']; ?></td>
                <td><?php echo $items['customers']; ?></td>
                <td><?php echo $items['items']; ?></td>
                <td><?php echo $items['amount']; ?></td>
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