<?php
include('user_session.php');
$sql1="SELECT
tb_products.id,
tb_supplier.name,
tb_products.price,
tb_products.capital,
CONCAT(tb_products.price - tb_products.capital) AS profit,
tb_products.product_brand,
tb_products.category,
CONCAT(tb_products.category,' ',tb_products.product_brand,' ',tb_products.mc_brand,' ',tb_products.mc_model) AS specification,
CONCAT(tb_products.available,'/',tb_products.stocks) AS stocks
FROM tb_products
LEFT JOIN tb_supplier ON tb_products.supplier_id=tb_supplier.id
WHERE tb_products.id='" .$_GET['id']. "'";
$result1=mysqli_query($db,$sql1);
$row1 = mysqli_fetch_assoc($result1);
?>
<!doctype html>
<html lang="en" data-bs-theme="auto">
  <head><script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.111.3">
    <title>PRODUCT</title>
 
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
    <main class="col-md-9 ms-sm-auto col-lg-10">
    <div class="d-flex justify-content-end mt-3">
    <button class="btn btn-success me-1" type="button" 
    onclick="btn_modify(this.getAttribute('data-1'),this.getAttribute('data-2'),this.getAttribute('data-3'))"
          data-1="<?php echo $row1['specification']; ?>"
          data-2="<?php echo $_GET['id']; ?>"
          data-3="<?php echo date("Y-m-d"); ?>"
    ><span data-feather="edit" class="align-text-bottom"></button>

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
  
      <img class="p-0 m-0 mx-auto d-block" onclick="location.href='admin_productqr.php?product_id=<?php echo $_GET['id'];?>&line=1'" src="https://chart.googleapis.com/chart?chs=140x140&cht=qr&chl=<?php echo $_GET['id']; ?>">
      <div class="table" id="page">
      <div class="">
        <div class="row">
          
          <div class="col text-center">
            <div class="card-body p-2">
                <h6 class="fw-bold mt-0" title="Number of Customers"><?php echo $row1['specification'];?></h6>
                <h3 class=""><?php echo $row1['stocks'];?></h3>
                <p class="mb-0 text-muted">
                <p class="mb-0 text-muted">
                <span class="text-primary me-2 fw-bold"><?php echo $row1['name'];?></span>
                <span class="text-nowrap">Supplier</span>  
                </p>
                </p>
            </div>
          </div>
          <div class="col text-center">
            <div class="card-body p-2">
                <h6 class="text-muted fw-normal mt-0" title="Number of Customers">Price</h6>
                <h3 class=""><?php echo $row1['price'];?></h3>
                <p class="mb-0 text-muted">
                <p class="mb-0 text-muted">
                <span class="text-primary fw-bold"><?php echo $row1['capital'];?></span>
                <span class="text-nowrap me-2">Capital</span>  
                <span class="text-primary fw-bold"><?php echo $row1['profit'];?></span>
                <span class="text-nowrap">Profit</span>  
                </p>
                </p>
            </div>
          </div>

        </div>
      </div>

      <h6 class="mt-3 text-center text-muted">Product Sales History</h6>
        <table class="table table-hover table-sm">
          <thead>
            <tr class="text-muted">
              <th scope="col">Date</th>
              <th scope="col">QTY</th>
              <th scope="col">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
                $sql="SELECT
                tb_transactions.id,
                DATE_FORMAT(tb_transactions.date,'%M %d,%Y') AS date,
                SUM(tb_cart.quantity) AS quantity,
                SUM(tb_cart.price) AS total
                FROM tb_products 
                LEFT JOIN tb_cart ON tb_products.id=tb_cart.product_id
                RIGHT JOIN tb_transactions ON tb_cart.transaction_id=tb_transactions.id
                WHERE tb_products.id='" .$_GET['id']. "'
                GROUP BY tb_transactions.id
                ORDER BY tb_transactions.date DESC";
                                                                                    
                $result = mysqli_query($db,$sql);

                if (mysqli_num_rows($result) > 0) 
                {
                foreach($result as $items)
                {
            ?>
            <tr onclick="location.href='admin_transaction.php?id=<?php echo $items['id'];?>'">
                <td><?php echo $items['date']; ?></td>
                <td><?php echo $items['quantity']; ?></td>
                <td><?php echo $items['total']; ?></td>
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

<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
    function btn_modify(data_1,data_2,data_3) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-secondary me-1"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: "MODIFY "+data_1+ " ?",
        showCancelButton: true,
        confirmButtonText: "Modify",
        cancelButtonText: "Cancel",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          location.href='admin_update_product.php?search='+data_1+'&date='+data_3;
        } else {
          result.dismiss === Swal.DismissReason.cancel
        }
      });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</script><script src="dashboard.js"></script>

  </body>
</html>
