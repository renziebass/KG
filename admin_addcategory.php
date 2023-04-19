<?php
include('user_session.php');
$sql1 = "SELECT * FROM tb_product_category";
$result1=mysqli_query($db,$sql1);

$sql2 = "SELECT * FROM `tb_mc_brand`";
$result2=mysqli_query($db,$sql2);

$sql3 = "SELECT * FROM `tb_mc_brand`";
$result3=mysqli_query($db,$sql3);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["category"])) {
    $category_err = "* ";
  } else {
    $category = validateInput($_POST["category"]);
  }
  if (empty($_POST["mb"])) {
    $mb_err = "* ";
  } else {
    $mb = validateInput($_POST["mb"]);
  }
  if (empty($_POST["mcbrand"])) {
    $mcbrand_err = "* ";
  } else {
    $mcbrand = validateInput($_POST["mcbrand"]);
  }
  if (empty($_POST["mcmodel"])) {
    $mcmodel_err = "* ";
  } else {
    $mcmodel = validateInput($_POST["mcmodel"]);
  }
  
}
function validateInput($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
if(!empty($_POST["category"]))
  {
    try {
      $sql4check = "SELECT tb_product_category.category
      FROM tb_product_category
      WHERE tb_product_category.category='$category'";
      $CategoryCheck4 = mysqli_query($db, $sql4check);
      $result4 = mysqli_fetch_assoc($CategoryCheck4);
      if(empty($result4)) {
        $sql4 = "INSERT INTO tb_product_category (category) VALUES ('$category');";
        $AddCategory = mysqli_query($db, $sql4);
        
        header("Location: admin_addcategory.php");
      } else {
        echo '<script>alert("Category Already Exist!")</script>';
        header("Refresh:0");
      }

    }
    catch(PDOException $e)
      {
        echo $sql1 . "<br>" . $e->getMessage();
      }
    $db=null;
}
if(!empty($_POST["mb"]))
  {
    try {
      $sql5check = "SELECT tb_mc_brand.brand
      FROM tb_mc_brand
      WHERE tb_mc_brand.brand='$mb'";
      $Check5 = mysqli_query($db, $sql5check);
      $result5 = mysqli_fetch_assoc($Check5);
      if(empty($result5)) {
        $sql5 = "INSERT INTO tb_mc_brand (brand) VALUES ('$mb');";
        $Addmb = mysqli_query($db, $sql5);
        header("Location: admin_addcategory.php");
      } else {
        echo '<script>alert("Motorcycle Brand Already Exist!")</script>';
        header("Refresh:0");
      }

    }
    catch(PDOException $e)
      {
        echo $sql1 . "<br>" . $e->getMessage();
      }
    $db=null;
}
if(!empty($_POST["mcbrand"]) && !empty($_POST["mcmodel"]))
  {
    try {
      $sql6check = "SELECT 
      tb_mc_model.brand,
      tb_mc_model.model
      FROM tb_mc_model
      WHERE tb_mc_model.brand='$mcbrand'
      AND tb_mc_model.model='$mcmodel'";
      $Check6 = mysqli_query($db, $sql6check);
      $result6 = mysqli_fetch_assoc($Check6);
      if(empty($result6)) {
        $sql6 = "INSERT INTO tb_mc_model (brand,model) VALUES ('$mcbrand','$mcmodel')";
        $Addmc = mysqli_query($db, $sql6);
        header("Location: admin_addcategory.php");
      } else {
        echo '<script>alert("Motorcycle Model Already Exist!")</script>';
        header("Refresh:0");
      }

    }
    catch(PDOException $e)
      {
        echo $sql1 . "<br>" . $e->getMessage();
      }
    $db=null;
}
if(!empty($_GET['xcategory'])) {
  $sql7="DELETE FROM tb_product_category WHERE tb_product_category.category='" .$_GET['xcategory']. "'";

  if (($db->query($sql7)) === TRUE) {
    echo "Category Deleted";
    header("Location: admin_addcategory.php");
  } else {
    echo "Error updating record: " . $db->error;
  }
}
if(!empty($_GET['xbrand'])) {
  $sql8="DELETE FROM tb_mc_brand WHERE tb_mc_brand.brand='" .$_GET['xbrand']. "'";

  if (($db->query($sql8)) === TRUE) {
    echo "Brand Deleted";
    header("Location: admin_addcategory.php");
  } else {
    echo "Error updating record: " . $db->error;
  }
}
if(!empty($_GET['xmcbrand']) && !empty($_GET['xmcmodel'])) {
  $sql9="DELETE FROM tb_mc_model WHERE tb_mc_model.brand='" .$_GET['xmcbrand']. "' AND tb_mc_model.model='" .$_GET['xmcmodel']. "'";

  if (($db->query($sql9)) === TRUE) {
    echo "Model Deleted";
    header("Location: admin_addcategory.php");
  } else {
    echo "Error updating record: " . $db->error;
  }
}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>ADD CATEGORY</title>

  </head>
  <body style="background-color: #c7c7c7;" onload = "navbar();">
  <script type="text/javascript">
      function navbar(){
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function(){
          document.getElementById("navbar").innerHTML = this.responseText;
        }
        xhttp.open("GET", "admin_navbar.php");
        xhttp.send();
      }
      setInterval(function(){
        navbar();
      }, 10000);
    </script>
    <div style="background-color: #ffc067;" id="navbar"></div><!--navbar -->
    <div class="mx-5">
      <div class="m-3 bg-light rounded">
        <!--A1-->
        <div class="container-fluid">
          <div class="row">
            <!--B1-->
            <div class="col">
                <h5 class="mt-3 text-muted">CATEGORY</h5>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                            <input name="category" onkeyup="this.value = this.value.toUpperCase();" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="New Category">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-add" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Z"/>
  <path d="M12.096 6.223A4.92 4.92 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.493 4.493 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.525 4.525 0 0 1-.813-.927C8.5 14.992 8.252 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.552 4.552 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10c.262 0 .52-.008.774-.024a4.525 4.525 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777ZM3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4Z"/>
</svg> Add</button>
                            </div>
                    </div >    
                </form>
                <table class="mb-3">
                  <tbody>
                  <?php
                    $sql="SELECT
                    tb_product_category.category
                    FROM tb_product_category  
                    ORDER BY tb_product_category.category ASC";
                                                        
                    $result = mysqli_query($db,$sql);
        
                    if (mysqli_num_rows($result) > 0) 
                    {
                    foreach($result as $items)
                    {
                  ?>
                        <tr>
                        <td><button onclick="location.href='admin_addcategory.php?xcategory=<?php echo $items['category'];?>'" type="button" class="close text-danger" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </td>
                        <td><?php echo $items['category']; ?></td>
                        </tr>
                  <?php
                    } 
                  } 
                    ?>
                  </tbody>
                </table> 
              
            </div>
            <!--B1-->
            <div class="col">
            <h5 class="mt-3 text-muted">MOTORCYCLE BRAND</h5>
              <form method="post" action="" enctype="multipart/form-data">
                <div class="input-group mb-3">
                    
                        <input name="mb" onkeyup="this.value = this.value.toUpperCase();" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="New Motorcycle Brand">
                        <div class="input-group-append">
                          <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-add" viewBox="0 0 16 16">
  <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Z"/>
  <path d="M12.096 6.223A4.92 4.92 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.493 4.493 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.525 4.525 0 0 1-.813-.927C8.5 14.992 8.252 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.552 4.552 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10c.262 0 .52-.008.774-.024a4.525 4.525 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777ZM3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4Z"/>
</svg> Add</button>
                          </div>
                </div>
              </form>
              <table class="mb-3">
                  <tbody>
                  <?php
                    $sql="SELECT * FROM `tb_mc_brand` ORDER BY `tb_mc_brand`.`brand` ASC";
                                                        
                    $result = mysqli_query($db,$sql);
        
                    if (mysqli_num_rows($result) > 0) 
                    {
                    foreach($result as $items)
                    {
                  ?>
                        <tr>
                        <td><button onclick="location.href='admin_addcategory.php?xbrand=<?php echo $items['brand'];?>'" type="button" class="close text-danger" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </td>
                        <td><?php echo $items['brand']; ?></td>
                        </tr>
                  <?php
                    } 
                  } 
                    ?>
                  </tbody>
                </table> 
            </div>
            <div class="col">
            <h5 class="mt-3 text-muted">MOTORCYCLE MODEL</h5>
                <form method="post" action="" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                                <select name="mcbrand">
                                <?php while($row3 = mysqli_fetch_array($result3)):;?> 
                                <option class="dropdown-item" href="admin_inventory_manage.php?pcategory=<?php echo $row3['brand'];?>" value="<?php echo $row3['brand'];?>">
                                <?php echo $row3['brand'];?></option>
                                <?php endwhile; ?>
                                </select>
                      </div>
                            <input name="mcmodel" onkeyup="this.value = this.value.toUpperCase();" type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="New MC Model">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="submit" id="button-addon2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-database-add" viewBox="0 0 16 16">
                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0Z"/>
                                <path d="M12.096 6.223A4.92 4.92 0 0 0 13 5.698V7c0 .289-.213.654-.753 1.007a4.493 4.493 0 0 1 1.753.25V4c0-1.007-.875-1.755-1.904-2.223C11.022 1.289 9.573 1 8 1s-3.022.289-4.096.777C2.875 2.245 2 2.993 2 4v9c0 1.007.875 1.755 1.904 2.223C4.978 15.71 6.427 16 8 16c.536 0 1.058-.034 1.555-.097a4.525 4.525 0 0 1-.813-.927C8.5 14.992 8.252 15 8 15c-1.464 0-2.766-.27-3.682-.687C3.356 13.875 3 13.373 3 13v-1.302c.271.202.58.378.904.525C4.978 12.71 6.427 13 8 13h.027a4.552 4.552 0 0 1 0-1H8c-1.464 0-2.766-.27-3.682-.687C3.356 10.875 3 10.373 3 10V8.698c.271.202.58.378.904.525C4.978 9.71 6.427 10 8 10c.262 0 .52-.008.774-.024a4.525 4.525 0 0 1 1.102-1.132C9.298 8.944 8.666 9 8 9c-1.464 0-2.766-.27-3.682-.687C3.356 7.875 3 7.373 3 7V5.698c.271.202.58.378.904.525C4.978 6.711 6.427 7 8 7s3.022-.289 4.096-.777ZM3 4c0-.374.356-.875 1.318-1.313C5.234 2.271 6.536 2 8 2s2.766.27 3.682.687C12.644 3.125 13 3.627 13 4c0 .374-.356.875-1.318 1.313C10.766 5.729 9.464 6 8 6s-2.766-.27-3.682-.687C3.356 4.875 3 4.373 3 4Z"/>
                              </svg> Add</button>
                            </div>
                    </div>
                </form>
                <table class="mb-3">
                  <tbody>
                  <?php
                    $sql="SELECT
                    tb_mc_model.brand,
                    tb_mc_model.model
                    FROM `tb_mc_model`  
                    ORDER BY `tb_mc_model`.`brand` ASC";
                                                        
                    $result = mysqli_query($db,$sql);
        
                    if (mysqli_num_rows($result) > 0) 
                    {
                    foreach($result as $items)
                    {
                  ?>
                        <tr>
                        <td><button onclick="location.href='admin_addcategory.php?xmcbrand=<?php echo $items['brand'];?>&xmcmodel=<?php echo $items['model'];?>'" type="button" class="close text-danger" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </td> 
                        <td><?php echo "".$items['brand']."-".$items['model'].""; ?></td>
                        </tr>
                  <?php
                    } 
                  } 
                    ?>
                  </tbody>
                </table> 
            </div>
          </div>
        </div>
        <!--A2-->
        
    
        
      </div><!-- last div-->
      <footer class="m-3 mt-4 text-muted border-top">
      <p>&copy; R-Click Solutions 2023</p>
      </footer>
    </div>
    

    <!--  -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    -->
  </body>
</html>