<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login Admin Property Penjualan Rumah</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="assets/css/sb-admin.css" rel="stylesheet">

  </head>

  <body class="bg-dark">

    <div class="container">
    <?php 
        $uri = $_SERVER["REQUEST_URI"];
        $uri = str_replace("login.php","",$uri);
        // var_dump($uri);
        // exit();

        session_start();
        if (isset($_SESSION["user_admin"])) {
          // echo "<script> window.location.href = '/admin/'; </script>"; // nanti cari redirect path nya..
          echo "<script> window.location.href = '".$uri."'; </script>";
        }

        require_once 'core/db_mysqli.php';
        $model = new Model_mysqli();
        $model->setTable("users");

        if (isset($_POST["btnLogin"])) {
            $email = $_POST["email"];
            $password = $_POST["password"];

            $where = array(
                "email"  =>  $email,
                "password"  =>  md5($password)
              );
            $result = $model->getByWhere($where);
        } else {
            $email = "";
            $password = "";
        }
    ?>
      <div class="card card-login  mx-auto mt-5">
        <div class="card-header text-info">
         <i class="fa fa-sign-in"></i> Login
        </div>
        <div class="card-body">
          <?php 
              if (isset($_POST["btnLogin"])) {
                  // var_dump($result);
                  if ($result == NULL) {
                      echo "<span class='text-danger'>Opps, Kombinasi email, dan password tidak benar..!!</span>";
                      echo "<br>";
                      echo "<span class='text-danger'>Atau mungkin belum terdaftar.!</span>";
                      // var_dump($result);
                  } else {
                      // var_dump($result);
                      $_SESSION["user_admin"] = $result;
                      // echo "<script> window.location.href = '/admin/'; </script>";
                      echo "<script> window.location.href = '".$uri."'; </script>";
                  }
                  echo "<br><br>";
              }
           ?>  
          <form method="post"> 
            <div class="form-group">
              <label for="exampleInputEmail1">Email</label>
              <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" placeholder="Email" required>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" name="password" class="form-control" value="<?php echo $password; ?>" placeholder="Password" required>
            </div>
            <!-- <a class="btn btn-primary btn-block" href="index.html">Login</a> -->
            <button type="submit" name="btnLogin" class="btn btn-primary btn-block">Login</button>
          </form>
        </div>
      </div>

    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/popper/popper.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>

  </body>

</html>
