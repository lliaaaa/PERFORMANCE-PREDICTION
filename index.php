<?php
$page = $_GET['page'] ?? 'login';

include 'header.php';

$pagePath = "templates/$page.php";
if (file_exists($pagePath)) {
    include $pagePath;
} else {
    echo "<div class='container text-center mt-5'><h4>Page not found.</h4></div>";
}

include 'footer.php';
?>