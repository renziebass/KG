<?php
include('user_session.php');
$sql1a = "SELECT
tb_products.id,
CONCAT(tb_products.category,' ',tb_products.product_brand,' ',tb_products.mc_brand,' ',tb_products.mc_model)
AS specification
FROM tb_products";
$result1a=mysqli_query($db,$sql1a);

$sql4a = "SELECT * FROM `tb_products`";
$result4a=mysqli_query($db,$sql4a);

$sql1b="SELECT
tb_products.id,
tb_products.supplier_id,
tb_supplier.name,
tb_products.price,
tb_products.capital,
CONCAT(tb_products.price - tb_products.capital) AS profit,
tb_products.product_brand,
tb_products.category,
CONCAT(tb_products.category,' ',tb_products.product_brand,' ',tb_products.mc_brand,' ',tb_products.mc_model) AS specification,
CONCAT(tb_products.available,'/',tb_products.stocks) AS stocks
FROM tb_products
LEFT JOIN tb_supplier
ON tb_products.supplier_id=tb_supplier.id
WHERE CONCAT(tb_products.category,' ',tb_products.product_brand,' ',tb_products.mc_brand,' ',tb_products.mc_model)
LIKE '%".$_GET['search']."%'";
$result1b=mysqli_query($db,$sql1b);
$row1b = mysqli_fetch_assoc($result1b);
$id = $row1b['id'];

if(!empty($_GET['qty'])){
$sql3 = "UPDATE tb_products
SET tb_products.stocks=tb_products.stocks+'".$_GET['qty']."',tb_products.available=tb_products.available+'".$_GET['qty']."'
WHERE tb_products.id='" .$id. "'";
$RestockUpdate = mysqli_query($db, $sql3);

$sql4 = "INSERT INTO `tb_restock_history` (`product_id`, `date`, `qty`)
VALUES ('" .$id. "', '".date("Y-m-d H:i:s")."', '".$_GET['qty']."')";
$Restock = mysqli_query($db, $sql4);
        
header("Location: admin_product_restock.php?search=".$_GET['search']."");

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
    <title>RE-STOCK PRODUCT</title>
 
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
.autocomplete-items {
      position: absolute;
      border: 1px solid #d4d4d4;
      border-bottom: none;
      border-top: none;
      z-index: 99;
      /*position the autocomplete items to be the same width as the container:*/
      top: 100%;
      left: 0;
      right: 0;
    }
    .autocomplete {
      position: relative;
      display: inline-block;
    }
    .autocomplete-items div {
      padding: 10px;
      cursor: pointer;
      background-color: #fff; 
      border-bottom: 1px solid #d4d4d4; 
    }
    .autocomplete-items div:hover {
      background-color: #e9e9e9; 
    }
    .autocomplete-active {
      background-color: DodgerBlue !important; 
      color: #ffffff; 
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
            <a class="nav-link" href="admin_yearly_history.php">
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
            <a class="nav-link active" href="admin_product_restock.php">
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
    <h6 class="text-center mb-3 mt-3">Re-Stock Product: <?php echo $row1b['id'];?></h6>
    <div class="col">
        <form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete=off>
        <div class="mb-3">
            <div class="input-group shadow">
            <div class="autocomplete col">
            <input id="search" onkeyup="this.value = this.value.toUpperCase();" name="search" class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search product...">
            </div>
              <script>
                window.onload = init;
                function init(){
                document.getElementById("search").focus();
                }
              </script>
             
              <button class="btn btn-secondary" type="submit" id="button-addon2"><span data-feather="search" class="align-text-end"></button>
            </div>
        </div>
      </form>
        </div>
     
      
      <div class="table" id="page">
      <div class="mb-3">
        <div class="row ">
          
          <div class="col text-center">
            <div class="card-body p-2">
                <h6 class="fw-normal mt-0"><?php echo $row1b['name'];?></h6>
                <h3 class=""><?php echo $row1b['specification'];?></h3>
                <p class="mb-0 text-muted">
                <p class="mb-0 text-muted">
                <span class="text-primary fw-bold"><?php echo $row1b['stocks'];?></span>
                <span class="text-nowrap me-2">Stocks</span> 
                </p>
                </p>
            </div>
          </div>
          <div class="col text-center">
            <div class="card-body p-2">
                <h6 class="fw-normal mt-0" title="Number of Customers">Price</h6>
                <h3 class=""><?php echo $row1b['price'];?></h3>
                <p class="mb-0 text-muted">
                <p class="mb-0 text-muted">
                <span class="text-danger fw-bold"><?php echo $row1b['capital'];?></span>
                <span class="text-nowrap me-2">Capital</span>  
                <span class="text-primary fw-bold"><?php echo $row1b['profit'];?></span>
                <span class="text-nowrap">Profit</span>  
                </p>
                </p>
            </div>
          </div>

        </div>
      </div>
      <div class="col-md container text-center">
        <button class="btn btn-secondary"
        onclick="btn_qty(this.getAttribute('data-1'), this.getAttribute('data-2'), 
            this.getAttribute('data-3'), this.getAttribute('data-4'))"
            data-1="<?php echo $row1b['specification'];?>" 
            data-2="<?php echo $row1b['id'];?>" 
            data-3="<?php echo $row1b['stocks'];?>"
        type="button">RE-STOCK</button>
      </div>
      <h6 class="mt-3 text-center text-muted">Re-stock history</h6>  
        <table class="table table-hover table-sm">
          <thead>
            <tr class="text-muted">
              <th scope="col">Date</th>
              <th scope="col">QTY</th>
            </tr>
          </thead>
          <tbody>
            <?php
                $sql="SELECT 
                tb_restock_history.date,
                tb_restock_history.qty,
                CASE WHEN tb_products.available=0
                THEN 'text-danger' ELSE null END AS textcolor
                FROM tb_restock_history
                JOIN tb_products ON tb_restock_history.product_id=tb_products.id
                WHERE tb_restock_history.product_id='$id'";
                                                                                    
                $result = mysqli_query($db,$sql);

                if (mysqli_num_rows($result) > 0) 
                {
                foreach($result as $items)
                {
            ?>
            <tr class="<?php echo $items['textcolor']; ?>">
                <td><?php echo $items['date']; ?></td>
                <td><?php echo $items['qty']; ?></td>
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
  function init(){
    document.getElementById("search").focus();
    }
    function btn_qty(data_1,data_2,data_3) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-secondary me-1"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: data_1,
        input: "text",
        footer: '<h6 class="text-white text-center">Current stocks: '+data_3+'</h6>',
        showCancelButton: true,
        confirmButtonText: "Add",
        cancelButtonText: "Cancel",
        reverseButtons: true,
        inputValidator: (result) => {
          if (!result) {
            return "Enter quantity!";
          } else {
          }
        },
        inputAttributes: {
        maxlength: "10"
      }
      }).then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire({
          title: result.value+" Stock(s) Successfully Added",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
         }).then((result2) => {
          if (result2.dismiss === swalWithBootstrapButtons.DismissReason.timer) {
            window.location.href = window.location.href+'&qty='+result.value;
          }
          });
          
        } else {
          result.dismiss === Swal.DismissReason.cancel
        }
      });
    }
  function autocomplete(inp, arr) {
            var currentFocus;
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                closeAllLists();
                if (!val) { return false;}
                currentFocus = -1;
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                this.parentNode.appendChild(a);
                for (i = 0; i < arr.length; i++) {
                  if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    b = document.createElement("DIV");
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    b.addEventListener("click", function(e) {
                        inp.value = this.getElementsByTagName("input")[0].value;
                        closeAllLists();
                    });
                    a.appendChild(b);
                  }
                }
            });
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                  currentFocus++;
                  addActive(x);
                } else if (e.keyCode == 38) {
                  currentFocus--;
                  addActive(x);
                } else if (e.keyCode == 13) {
                  
                  if (currentFocus > -1) {
                    if (x) x[currentFocus].click();
                  }
                  if (inp.value == "") {
                    e.preventDefault();
                  }
                }
            });
            function addActive(x) {
              if (!x) return false;
              removeActive(x);
              if (currentFocus >= x.length) currentFocus = 0;
              if (currentFocus < 0) currentFocus = (x.length - 1);
              x[currentFocus].classList.add("autocomplete-active");
            }
            function removeActive(x) {
              for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
              }
            }
            function closeAllLists(elmnt) {
              var x = document.getElementsByClassName("autocomplete-items");
              for (var i = 0; i < x.length; i++) {
                if (elmnt != x[i] && elmnt != inp) {
                  x[i].parentNode.removeChild(x[i]);
                }
              }
            }
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });
          }
          var specification = [
            <?php while($row1a = mysqli_fetch_array($result1a)):;?>
            "<?php echo $row1a['specification'];?>",
            <?php endwhile; ?>
          ];
          var pb = [
            <?php while($row4a = mysqli_fetch_array($result4a)):;?>
            "<?php echo $row4a['product_brand'];?>",
            <?php endwhile; ?>
          ];

          autocomplete(document.getElementById("search"), specification.concat(pb));
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</script><script src="dashboard.js"></script>

  </body>
</html>
