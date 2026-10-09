<?php

include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    exit("Method tidak sesuai");
}

$nama = $_POST["nama"] ?? "";
$whatsapp = $_POST["whatsapp"] ?? "";
$ruangan = $_POST["ruangan"] ?? "";
$pesan = $_POST["pesan"] ?? "";
$produk = $_POST["produk"] ?? "";
$total_jumlah = (int) ($_POST["total_jumlah"] ?? 0);
$total_harga = (int) ($_POST["total_harga"] ?? 0);

$sql = "INSERT INTO pesanan
        (nama, whatsapp, ruangan, pesan, produk, total_jumlah, total_harga)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    exit("Gagal membuat query: " . mysqli_error($conn));
}

mysqli_stmt_bind_param(
    $stmt,
    "sssssii",
    $nama,
    $whatsapp,
    $ruangan,
    $pesan,
    $produk,
    $total_jumlah,
    $total_harga
);

if (mysqli_stmt_execute($stmt)) {
    echo "success";
} else {
    http_response_code(500);
    echo "Gagal menyimpan data: " . mysqli_stmt_error($stmt);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);

?>