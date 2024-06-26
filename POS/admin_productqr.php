<?php
include('user_session.php');
$sql1 = "SELECT
tb_products.id,
CONCAT(tb_products.category,'-',tb_products.product_brand) AS cpb,
tb_products.price,
CONCAT(tb_products.mc_brand,' ',tb_products.mc_model) AS specification
 FROM tb_products WHERE tb_products.id='".$_GET['product_id']."'";
$result1=mysqli_query($db,$sql1);
$row1 = mysqli_fetch_assoc($result1);

function validateInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["product_id"])) {
    $product_id_err = "* ";
  } else {
    $product_id = validateInput($_POST["product_id"]);
  }
  
  if(!empty($_POST["product_id"]))
  {
    try {
      $sql2check = "SELECT * FROM tb_products
      WHERE tb_products.id='$product_id'";
      $CategoryCheck2 = mysqli_query($db, $sql2check);
      $result2 = mysqli_fetch_assoc($CategoryCheck2);
      if(empty($result2)) {
        echo '<script>alert("Product Doesnt Exist Exist!")</script>';
        header("Refresh:0");
      } else {
        header("Location: admin_productqr.php?product_id=$product_id&line=1");
        
      }
    }
    catch(PDOException $e)
      {
        echo $sql1 . "<br>" . $e->getMessage();
      }
    $db=null;
  }
}
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.111.3">
    <title>PRODUCT QR GENERATOR</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <style>
      .datalistOptions {
        width: 100%;
      }
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
  <?php
  include 'admin_navbar.php';
  ?>

    <main class="col-md-9 ms-sm-auto col-lg-10">
    <h6 class="text-center mb-3 mt-5">Generate Product Multiple QR</h6>
    <div class="d-flex justify-content-end mt-3 mb-3">
    <button type="button" onclick="printDiv();" class="btn btn btn-secondary"><span data-feather="printer" class="align-text-bottom"></button>
    
    </div>
      <div class=" align-items-center ">
      <form method="post" action="" enctype="multipart/form-data">
        <div class="input-group input-group shadow">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">3 PCS</button>
              <div class="dropdown-menu">
                  <a class="dropdown-item" href="admin_productqr.php?product_id=<?php echo $row1['id'];?>&line=1" value="">3</a>
                  <a class="dropdown-item" href="admin_productqr.php?product_id=<?php echo $row1['id'];?>&line=2" value="">6</a>
                  <a class="dropdown-item" href="admin_productqr.php?product_id=<?php echo $row1['id'];?>&line=3" value="">9</a>
                  <a class="dropdown-item" href="admin_productqr.php?product_id=<?php echo $row1['id'];?>&line=4" value="">12</a>
                  <a class="dropdown-item" href="admin_productqr.php?product_id=<?php echo $row1['id'];?>&line=5" value="">15</a>
                  <a class="dropdown-item" href="admin_productqr.php?product_id=<?php echo $row1['id'];?>&line=6" value="">18</a>
                  <a class="dropdown-item" href="admin_productqr.php?product_id=<?php echo $row1['id'];?>&line=7" value="">21</a>
                  <a class="dropdown-item" href="admin_productqr.php?product_id=<?php echo $row1['id'];?>&line=8" value="">24</a>
                  <a class="dropdown-item" href="admin_productqr.php?product_id=<?php echo $row1['id'];?>&line=9" value="">27</a>
                  <a class="dropdown-item" href="admin_productqr.php?product_id=<?php echo $row1['id'];?>&line=10" value="">30</a>
                  <a class="dropdown-item" href="admin_productqr.php?product_id=<?php echo $row1['id'];?>&line=11" value="">33</a>
                  <a class="dropdown-item" href="admin_productqr.php?product_id=<?php echo $row1['id'];?>&line=12" value="">36</a>
              </div>
          <input type="text" name="product_id" class="form-control" placeholder="<?php echo $_GET['product_id']; ?>">
          <button class="btn btn-secondary" type="submit"><span data-feather="search" class="align-text-end"></button>
        </div>
        </form>
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

      <div class="mt-3" id="page">
      <?php
        for ($i = 0; $i < $_GET['line']; $i++) {
          include('line.php');
        }
      ?> 
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
