<?php 
    $hostname = "localhost";
    $hostusername = "root";
    $hostpassword = "";
    $hostdatabase = "point_of_sales_2";
    $config = mysqli_connect($hostname, $hostusername, $hostpassword, $hostdatabase);
    if(!$config){
        echo "Koneksi gagal";
    }
?>