<?php
include('user_session.php');
if(!empty($_GET['xid'])) {
  $sql7="DELETE FROM tb_discount WHERE tb_discount.id='" .$_GET['xid']. "'";

  if (($db->query($sql7)) === TRUE) {
    echo "Product Deleted";
    header("Location: admin_add_discount.php");
  } else {
    echo "Error updating record: " . $db->error;
  }
}
function validateInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["id"])) {
    $id_err = "* ";
  } else {
    $id = validateInput($_POST["id"]);
  }
  if (empty($_POST["description"])) {
    $description_err = "* ";
  } else {
    $description = validateInput($_POST["description"]);
  }
  if (empty($_POST["percent"])) {
    $percent_err = "* ";
  } else {
    $percent = validateInput($_POST["percent"]);
  }
  if (empty($_POST["min"])) {
    $min_err = "* ";
  } else {
    $min = validateInput($_POST["min"]);
  }
  if (empty($_POST["cap"])) {
    $cap_err = "* ";
  } else {
    $cap = validateInput($_POST["cap"]);
  }
  
  
  if(!empty($_POST["id"]) && !empty($_POST["percent"] && !empty($_POST["min"])))
  {
    try {
      $sql5check = "SELECT *
      FROM
      tb_discount
      WHERE 
      tb_discount.id='$id'
      AND tb_discount.description='$description'
      AND tb_discount.percent='$percent'
      AND	tb_discount.min='$min'
      AND tb_discount.cap='$cap'";
      $CategoryCheck5 = mysqli_query($db, $sql5check);
      $result5 = mysqli_fetch_assoc($CategoryCheck5);
      if(empty($result5)) {
        $sql4 = "INSERT INTO `tb_discount` (`id`, `description`, `percent`, `min`, `cap`)
        VALUES ('$id', '$description', '$percent', '$min', '$cap')";
        $AddCategory = mysqli_query($db, $sql4);
        header("Location: admin_add_discount.php");
      } else {
        echo '<script>alert("Discount Already Exist!")</script>';
        header("Refresh:0");
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
    <title>ADD DISCOUNT</title>
 
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
    <h6 class="text-center mb-3 mt-5">Add New Discount</h6>
      <div class="align-items-center ">
      <form method="post" action="" enctype="multipart/form-data">
          
         
          <div class="row">
            <div class="col-md p-2">
              <div class="form-floating shadow">
                <input class="form-control" name="id" type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" aria-label="Text input with dropdown button" placeholder="Product Brand" required>
                <label for="floatingInputGrid">ID</label>
              </div>
            </div>
            <div class="col-md p-2">
              <div class="form-floating shadow">
                <input class="form-control" name="description" type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control" aria-label="Text input with dropdown button" placeholder="Product Brand" required>
                <label for="floatingInputGrid">DESCRIPTION</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md p-2">
              <div class="form-floating shadow">
                <input name="percent" type="decimal" class="form-control" aria-label="Text input with dropdown button" placeholder="CAP" required>
                <label for="floatingInputGrid">PERCENT</label>
              </div>
            </div>
            <div class="col-md p-2">
              <div class="form-floating shadow">
                <input name="min" type="number" class="form-control" aria-label="Text input with dropdown button" placeholder="QTY" required>
                <label for="floatingInputGrid">MINIMUM AMMOUNT</label>
              </div>
            </div>
            <div class="col-md p-2">
              <div class="form-floating shadow">
                <input name="cap" type="number" class="form-control" aria-label="Text input with dropdown button" placeholder="SRP" required>
                <label for="floatingInputGrid">MAXIMUM DISCOUNT</label>
              </div>
            </div>
          </div>      
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button class="btn btn-success" type="submit">SAVE <span data-feather="upload-cloud" class="align-text-end"></button>
          </div>
        </form>
      </div>
      <div class="table" id="page">
      <h6 class="mt-3 text-muted text-center">Recently added discount</h6>
        <table class="table table-hover table-sm">
          <thead>
            <tr class="text-muted">
              <th scope="col">ID</th>
              <th scope="col">Description</th>
              <th scope="col">Percent</th>
              <th scope="col">Minimum Purchase</th>
              <th scope="col">Capped</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <?php
                $sql="SELECT
                tb_discount.id,
                tb_discount.description,
                tb_discount.percent,
                tb_discount.min,
                tb_discount.cap
                FROM
                tb_discount";
                                                                                    
                $result = mysqli_query($db,$sql);

                if (mysqli_num_rows($result) > 0) 
                {
                foreach($result as $items)
                {
            ?>
            <tr>
                <td><?php echo $items['id']; ?></td>
                <td><?php echo $items['description']; ?></td>
                <td><?php echo $items['percent']; ?></td>
                <td><?php echo $items['min']; ?></td>
                <td><?php echo $items['cap']; ?></td>
                <td>
        
                  <button type="button" class="btn btn-sm p-0 m-0"
                  onclick="btn_delete(this.getAttribute('data-1'))"
                  data-1="<?php echo $items['id']; ?>"
                  data-2="<?php echo $items['description']; ?>">
                    <span>
                      <svg  class="text-danger" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill" viewBox="0 0 16 16">
                      <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                      </svg>
                    </span>
                  </button>

                </td>
               
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
  function btn_delete(data_1) {
      const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-danger",
          cancelButton: "btn btn-secondary me-1"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: "DELETE "+data_1+" ?",
        showCancelButton: true,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          swalWithBootstrapButtons.fire({
          title: "DELETED",
          icon: "success",
          showConfirmButton: false,
          timer: 1500
         }).then((result2) => {
          if (result2.dismiss === swalWithBootstrapButtons.DismissReason.timer) {
            window.location.href = window.location.href+'?xid='+data_1;
          }
          });
          
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
