<?php

if (!function_exists("protectAdmin")) {
    function protectAdmin () {
        if(!isset($_SESSION)) {
            session_start();
        }
        if(!isset($_SESSION['username']) || !is_numeric($_SESSION['username'])) {
            echo "<script>alert('Você precisa estar logado para acessar esta área');</script>";
            header("location: login.php");
        } else {
            include_once '../database/database.ini.php';
            $admin = pg_fetch_assoc(pg_query($conn, "SELECT * FROM public.\"funcionario\" WHERE id = $_SESSION[username]"));
            if($admin['adm'] == 0) {
                header("location: login.php");  
            } 
        }
    }
}
if (!function_exists("protect")) {
    function protect() {
        if(!isset($_SESSION)) {
            session_start();
        }
        if(!isset($_SESSION['username']) || !is_numeric($_SESSION['username'])) {
            echo "<script>alert('Você precisa estar logado para acessar esta área');</script>";
            header("location: login.php");
        }
    }
}
?>