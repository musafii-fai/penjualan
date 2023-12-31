<?php 
    
    $uri = $_SERVER["REQUEST_URI"];
    // var_dump($uri);
    // exit();

    session_start();
    if (!isset($_SESSION["user_admin"])) {
        echo "<script> window.location.href = '".$uri."login.php'; </script>";
        // header("Location: admin/login.php");
        // exit();
    }

    if (isset($_SESSION["user_admin"])) {
        $admin = $_SESSION["user_admin"];
    } else {
        $admin = null;
    }
    
    require_once 'core/db_mysqli.php';
    require_once 'core/helper.php';

?>

<?php 
    // $uri = $_SERVER["REQUEST_URI"];

    if (isset($_GET["ajax"])) {
        $getAjax = $_GET["ajax"];
        $getAjax = explode("/", $getAjax);

        if($getAjax[0] == ""){
            echo "<script> document.location.href = '/admin'; </script>";
        } else if (!isset($getAjax[1])) {
            $getAjax = $getAjax[0]."/index";
        } else if ($getAjax[1] == "") {
            $getAjax = $getAjax[0]."/index";
        } else {
            $getAjax = $getAjax[0]."/".$getAjax[1];
        }

        if (!file_exists("ajax/".$getAjax.".php")) {
?>
            <h1>404 Page Not Found</h1>
            <p>The page you requested was not found.</p>
<?php
        } else {
            include_once 'ajax/'.$getAjax.".php";
        }
    } else {
?>

    <!-- template header -->
        <?php require 'template/header.php'; ?>
    <!-- end template header -->

    
    <!-- content menu -->
    <?php
        if (isset($_GET["menu"])) {
            $getMenu = $_GET["menu"];
            $getMenu = explode("/", $getMenu);

            /* for back redirect */
            $pageRedirect = isset($_GET["page"]) ? "&page=".$_GET["page"] : "";
            $searchRedirect = isset($_GET["search"]) ? "&search=".$_GET["search"] : "";
            
            $redirect = "&redirect=".$getMenu[0].$pageRedirect.$searchRedirect;     // untuk mengisi redirect
            $backRedirect = "?menu=".$getMenu[0].$pageRedirect.$searchRedirect; // mengembalikan isi get redirect;

            if($getMenu[0] == ""){
                echo "<script> document.location.href = '/admin'; </script>";
            } else if (!isset($getMenu[1])) {
                $getMenu = $getMenu[0]."/index";
            } else if ($getMenu[1] == "") {
                $getMenu = $getMenu[0]."/index";
            } else {
                $getMenu = $getMenu[0]."/".$getMenu[1];
            }

            // echo $getMenu;

            if (!file_exists("menu/".$getMenu.".php")) {
    ?>
                <h1>404 Page Not Found</h1>
                <p>The page you requested was not found.</p>
    <?php
            } else {
                include_once("menu/".$getMenu.".php");
            }
        } else {
            if (!isset($_GET["ajax"])) {
    ?>
            <!-- Breadcrumbs -->
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="/admin">Home</a>
              </li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>

    <?php
            include_once("menu/home/index.php");
            }
        }   
    ?>
    <!-- end content menu -->

    <!-- template footer -->
        <?php require 'template/footer.php'; ?>
    <!-- end template footer -->

<?php } ?>
