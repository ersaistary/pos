<?php
ob_clean();
require_once 'vendor/autoload.php';
require_once 'config/koneksi.php';

$mpdf = new \Mpdf\Mpdf();
$idPrint = $_GET['print'] ?? null;
$qTransaction = mysqli_query($config, "SELECT * FROM transactions WHERE id = '$idPrint'");
$row = mysqli_fetch_assoc($qTransaction);
$html="
<h1>Transaction Receipt</h1>
<h1>Transaction ID: {$row['no_transaction']}</h1>
";
$mpdf->WriteHTML($html);
$mpdf->Output();