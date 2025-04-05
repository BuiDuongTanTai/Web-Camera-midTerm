<?php
include("dao/view/header.php");

if(!isset($_SESSION[""]) || $_SESSION[""] != "")
include("dao/view/home.php");

include("dao/view/footer.php");

?>