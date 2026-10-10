<?php
include "koneksi.php";

/* =====================================================
   HAPUS PESANAN
===================================================== */

if (isset($_GET["hapus"])) {

    $id = (int) $_GET["hapus"];

    if ($id > 0) {

        $hapus = mysqli_query(
            $conn,
            "DELETE FROM pesanan WHERE id = $id"
        );

        if (!$hapus) {
            die("Gagal menghapus data: " . mysqli_error($conn));
        }
    }

    header("Location: data_pesanan.php");
    exit;
}


/* =====================================================
   DATA UNTUK EDIT
===================================================== */

$editData = null;

if (isset($_GET["edit"])) {

    $idEdit = (int) $_GET["edit"];

    if ($idEdit > 0) {

        $resultEdit = mysqli_query(
            $conn,
            "SELECT * FROM pesanan WHERE id = $idEdit"
        );

        if ($resultEdit && mysqli_num_rows($resultEdit) > 0) {
            $editData = mysqli_fetch_assoc($resultEdit);
        }
    }
}


/* =====================================================
   SIMPAN PERUBAHAN
===================================================== */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = (int) ($_POST["id"] ?? 0);

    $nama = trim($_POST["nama"] ?? "");
    $whatsapp = trim($_POST["whatsapp"] ?? "");
    $ruangan = trim($_POST["ruangan"] ?? "");
    $jenis_material = trim($_POST["jenis_material"] ?? "");
    $kode_material = trim($_POST["kode_material"] ?? "");
    $nama_material = trim($_POST["nama_material"] ?? "");
    $jumlah = (int) ($_POST["jumlah"] ?? 0);
    $harga_satuan = (int) ($_POST["harga_satuan"] ?? 0);
    $pesan = trim($_POST["pesan"] ?? "");

    if (
        $id <= 0 ||
        $nama === "" ||
        $whatsapp === "" ||
        $ruangan === "" ||
        $jenis_material === "" ||
        $kode_material === "" ||
        $nama_material === "" ||
        $jumlah < 1
    ) {

        die("Data pesanan belum lengkap.");
    }


    $total_harga = $harga_satuan * $jumlah;


    $produk = "1. " . $jenis_material . "\n"
            . "Kode: " . $kode_material . "\n"
            . "Nama: " . $nama_material . "\n"
            . "Jumlah: " . $jumlah . " " .
              (($jenis_material === "Lem & Perekat") ? "pcs" : "m²") . "\n"
            . "Harga: Rp " . number_format(
                $harga_satuan,
                0,
                ",",
                "."
              )
              . " / "
              . (($jenis_material === "Lem & Perekat") ? "pcs" : "m²");


    $nama = mysqli_real_escape_string($conn, $nama);
    $whatsapp = mysqli_real_escape_string($conn, $whatsapp);
    $ruangan = mysqli_real_escape_string($conn, $ruangan);
    $produk = mysqli_real_escape_string($conn, $produk);
    $pesan = mysqli_real_escape_string($conn, $pesan);


    $update = mysqli_query(
        $conn,
        "UPDATE pesanan SET
            nama = '$nama',
            whatsapp = '$whatsapp',
            ruangan = '$ruangan',
            produk = '$produk',
            total_jumlah = $jumlah,
            total_harga = $total_harga,
            pesan = '$pesan'
         WHERE id = $id"
    );


    if (!$update) {
        die("Gagal menyimpan perubahan: " . mysqli_error($conn));
    }


    header("Location: data_pesanan.php");
    exit;
}


/* =====================================================
   DATA PESANAN
===================================================== */

$query = mysqli_query(
    $conn,
    "SELECT * FROM pesanan ORDER BY id DESC"
);

if (!$query) {
    die("Gagal mengambil data: " . mysqli_error($conn));
}


/* =====================================================
   FUNGSI HTML
===================================================== */

function e($value)
{
    return htmlspecialchars(
        (string) $value,
        ENT_QUOTES,
        "UTF-8"
    );
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Data Pesanan | Wallpaper Market</title>


    <!-- Bootstrap -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <!-- Bootstrap Icons -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet">


    <!-- Google Font -->

    <link
        href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@500;600;700&family=Montserrat:wght@300;400;500;600&display=swap"
        rel="stylesheet">


    <link
        rel="stylesheet"
        href="style.css">


    <style>

        body {
            background: #e8e5de;
            color: #263238;
            font-family: 'Montserrat', sans-serif;
        }


        /* HEADER */

        .page-header {
            text-align: center;
            padding: 70px 20px 40px;
        }

        .page-header small {
            color: #b08b3d;
            letter-spacing: 3px;
            font-size: 11px;
            font-weight: 600;
        }

        .page-header h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 52px;
            font-weight: 600;
            margin: 8px 0;
        }

        .page-header p {
            font-size: 13px;
            color: #666;
            margin: 0;
        }


        /* CONTENT */

        .content-box {
            background: #ffffff;
            max-width: 1200px;
            margin: 0 auto 60px;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 5px 25px rgba(0,0,0,.05);
        }


        /* TOP BAR */

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .top-bar h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 30px;
            margin: 0;
        }


        /* TAMBAH */

        .btn-tambah {
            background: #b08b3d;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            font-size: 12px;
        }

        .btn-tambah:hover {
            background: #263238;
            color: white;
        }


        /* TABLE */

        .table-responsive {
            border: 1px solid #e5e5e5;
        }

        table {
            margin-bottom: 0 !important;
            font-size: 12px;
            vertical-align: middle;
        }

        thead th {
            background: #263238 !important;
            color: white !important;
            font-weight: 500;
            padding: 14px 10px !important;
            white-space: nowrap;
        }

        tbody td {
            padding: 13px 10px !important;
            color: #444;
        }

        tbody tr:hover {
            background: #faf9f6;
        }


        /* BUTTON */

        .btn-edit,
        .btn-hapus {
            display: inline-block;
            text-decoration: none;
            padding: 6px 10px;
            font-size: 11px;
            margin: 2px;
        }

        .btn-edit {
            background: #b08b3d;
            color: white;
        }

        .btn-edit:hover {
            background: #263238;
            color: white;
        }

        .btn-hapus {
            background: #555;
            color: white;
        }

        .btn-hapus:hover {
            background: #222;
            color: white;
        }


        /* FORM EDIT */

        .edit-box {
            background: #faf9f6;
            border: 1px solid #e5e5e5;
            padding: 30px;
            margin-bottom: 30px;
        }

        .edit-box h3 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 32px;
            margin-bottom: 8px;
        }

        .edit-box > p {
            color: #777;
            font-size: 12px;
            margin-bottom: 25px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
        }

        .form-control,
        .form-select {
            font-size: 13px;
        }

        .material-info {
            background: #ffffff;
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 15px;
            border-radius: 4px;
        }

        .material-info small {
            display: block;
            color: #888;
            font-size: 10px;
            letter-spacing: 1px;
        }

        .material-info strong {
            display: block;
            margin-top: 4px;
            font-size: 14px;
            color: #263238;
        }

        .auto-total {
            background: #f3f0e9;
            font-weight: 600;
        }

        .btn-simpan {
            background: #b08b3d;
            color: white;
            border: none;
            padding: 10px 18px;
        }

        .btn-simpan:hover {
            background: #263238;
            color: white;
        }


        /* FOOTER */

        footer {
            text-align: center;
            padding: 25px;
            font-size: 11px;
            color: #777;
            letter-spacing: .5px;
        }


        @media (max-width: 768px) {

            .page-header h1 {
                font-size: 40px;
            }

            .content-box {
                margin: 0 15px 40px;
                padding: 20px;
            }

            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     NAVBAR
===================================================== -->

<nav class="navbar navbar-expand-lg home-navbar">

    <div class="container">

        <a
            href="index.html"
            class="market-logo">

            <span class="logo-icon">

                <i class="bi bi-house-door-fill"></i>

            </span>

            <span class="logo-text">

                <strong>
                    WALLPAPER MARKET
                </strong>

                <small>
                    INTERIOR &amp; WALLPAPER
                </small>

            </span>

        </a>


        <div
            class="collapse navbar-collapse show"
            id="menuNavbar">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="index.html">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="tentang.html">
                        Tentang
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="koleksi.html">
                        Koleksi
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link"
                        href="galeri.html">
                        Galeri
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link nav-pesan active"
                        href="pesan.php">
                        Pesan
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link active"
                        href="data_pesanan.php">
                        Data Pesanan
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>



<!-- =====================================================
     HEADER
===================================================== -->

<section class="page-header">

    <small>
        DATA PEMESANAN
    </small>

    <h1>
        Data Pesanan
    </h1>

    <p>
        Daftar pesanan yang telah masuk melalui Wallpaper Market.
    </p>

</section>



<section>

<div class="content-box">


<?php if ($editData): ?>

<!-- =====================================================
     FORM EDIT
===================================================== -->

<div class="edit-box">

    <h3>
        Edit Data Pesanan
    </h3>

    <p>
        Pilih kembali material dan ubah data pesanan yang diperlukan.
    </p>


    <form method="POST">

        <input
            type="hidden"
            name="id"
            value="<?= e($editData["id"]); ?>">


        <!-- DATA PELANGGAN -->

        <div class="row g-3">

            <div class="col-md-6">

                <label class="form-label">
                    Nama
                </label>

                <input
                    type="text"
                    name="nama"
                    class="form-control"
                    value="<?= e($editData["nama"]); ?>"
                    required>

            </div>


            <div class="col-md-6">

                <label class="form-label">
                    No. WhatsApp
                </label>

                <input
                    type="text"
                    name="whatsapp"
                    class="form-control"
                    value="<?= e($editData["whatsapp"]); ?>"
                    required>

            </div>


            <!-- RUANGAN -->

            <div class="col-md-6">

                <label class="form-label">
                    Ruangan
                </label>

                <select
                    name="ruangan"
                    id="ruangan"
                    class="form-select"
                    required>

                    <option value="" disabled>
                        Pilih ruangan
                    </option>

                    <option
                        value="Ruang Tamu"
                        <?= $editData["ruangan"] === "Ruang Tamu" ? "selected" : ""; ?>>
                        Ruang Tamu
                    </option>

                    <option
                        value="Kamar Tidur"
                        <?= $editData["ruangan"] === "Kamar Tidur" ? "selected" : ""; ?>>
                        Kamar Tidur
                    </option>

                    <option
                        value="Ruang Keluarga"
                        <?= $editData["ruangan"] === "Ruang Keluarga" ? "selected" : ""; ?>>
                        Ruang Keluarga
                    </option>

                    <option
                        value="Kantor"
                        <?= $editData["ruangan"] === "Kantor" ? "selected" : ""; ?>>
                        Kantor
                    </option>

                    <option
                        value="Toko"
                        <?= $editData["ruangan"] === "Toko" ? "selected" : ""; ?>>
                        Toko
                    </option>

                    <option
                        value="Lainnya"
                        <?= $editData["ruangan"] === "Lainnya" ? "selected" : ""; ?>>
                        Lainnya
                    </option>

                </select>

            </div>


            <!-- JENIS MATERIAL -->

            <div class="col-md-6">

                <label class="form-label">
                    Jenis Material
                </label>

                <select
                    id="jenisMaterial"
                    name="jenis_material"
                    class="form-select"
                    required>

                    <option
                        value=""
                        selected
                        disabled>

                        Pilih jenis material

                    </option>

                </select>

            </div>


            <!-- KODE + NAMA -->

            <div class="col-md-8">

                <label class="form-label">
                    Kode &amp; Nama Material
                </label>

                <select
                    id="materialPilihan"
                    name="kode_material"
                    class="form-select"
                    required>

                    <option
                        value=""
                        selected
                        disabled>

                        Pilih kode &amp; nama material

                    </option>

                </select>

            </div>


            <!-- JUMLAH -->

            <div class="col-md-4">

                <label class="form-label">
                    Jumlah
                </label>

                <input
                    type="number"
                    id="jumlah"
                    name="jumlah"
                    class="form-control"
                    min="1"
                    value="1"
                    required>

            </div>


            <!-- NAMA MATERIAL HIDDEN -->

            <input
                type="hidden"
                id="nama_material"
                name="nama_material">


            <!-- HARGA SATUAN HIDDEN -->

            <input
                type="hidden"
                id="harga_satuan"
                name="harga_satuan">


            <!-- INFORMASI MATERIAL -->

            <div class="col-12">

                <div class="material-info">

                    <small>
                        MATERIAL TERPILIH
                    </small>

                    <strong id="materialTampil">
                        -
                    </strong>


                    <small class="mt-3">
                        HARGA PER UNIT
                    </small>

                    <strong id="hargaMaterial">
                        -
                    </strong>


                    <small class="mt-3">
                        TOTAL HARGA
                    </small>

                    <strong id="totalHargaTampil">
                        Rp0
                    </strong>

                </div>

            </div>


            <!-- TOTAL HARGA -->

            <div class="col-md-6">

                <label class="form-label">
                    Total Harga
                </label>

                <input
                    type="number"
                    id="total_harga"
                    name="total_harga"
                    class="form-control auto-total"
                    value="0"
                    readonly>

            </div>


            <!-- CATATAN -->

            <div class="col-12">

                <label class="form-label">
                    Catatan Pesanan
                </label>

                <textarea
                    name="pesan"
                    class="form-control"
                    rows="4"><?= e($editData["pesan"]); ?></textarea>

            </div>

        </div>


        <!-- BUTTON -->

        <div class="mt-4">

            <button
                type="submit"
                class="btn-simpan">

                <i class="bi bi-save"></i>

                Simpan Perubahan

            </button>


            <a
                href="data_pesanan.php"
                class="btn btn-outline-secondary ms-2">

                Batal

            </a>

        </div>

    </form>

</div>

<?php endif; ?>



<!-- =====================================================
     DAFTAR PESANAN
===================================================== -->

<div class="top-bar">

    <h3>
        Daftar Pesanan
    </h3>


    <a
        href="pesan.php"
        class="btn-tambah">

        <i class="bi bi-plus-circle"></i>

        Tambah Pesanan

    </a>

</div>



<div class="table-responsive">

<table class="table">

<thead>

<tr>

    <th>No</th>
    <th>Nama</th>
    <th>WhatsApp</th>
    <th>Ruangan</th>
    <th>Produk</th>
    <th>Jumlah</th>
    <th>Total Harga</th>
    <th>Aksi</th>

</tr>

</thead>


<tbody>

<?php

$no = 1;

if (mysqli_num_rows($query) > 0):

    while ($data = mysqli_fetch_assoc($query)):

?>

<tr>

    <td>
        <?= $no++; ?>
    </td>

    <td>
        <?= e($data["nama"]); ?>
    </td>

    <td>
        <?= e($data["whatsapp"]); ?>
    </td>

    <td>
        <?= e($data["ruangan"]); ?>
    </td>

    <td style="min-width:250px;">

        <?= nl2br(
            e($data["produk"])
        ); ?>

    </td>

    <td>
        <?= e($data["total_jumlah"]); ?>
    </td>

    <td>

        Rp<?= number_format(
            $data["total_harga"],
            0,
            ",",
            "."
        ); ?>

    </td>

    <td>

        <!-- EDIT -->

        <a
            href="data_pesanan.php?edit=<?= $data["id"]; ?>"
            class="btn-edit">

            <i class="bi bi-pencil-square"></i>
            Edit

        </a>


        <!-- HAPUS -->

        <a
            href="data_pesanan.php?hapus=<?= $data["id"]; ?>"
            class="btn-hapus"
            onclick="return confirm('Apakah kamu yakin ingin menghapus pesanan ini?');">

            <i class="bi bi-trash"></i>
            Hapus

        </a>

    </td>

</tr>

<?php

    endwhile;

else:

?>

<tr>

    <td
        colspan="8"
        class="text-center py-4">

        Belum ada data pesanan.

    </td>

</tr>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</section>



<footer>

    © 2026 Wallpaper Market Interior

</footer>



<!-- =====================================================
     JAVASCRIPT MATERIAL
===================================================== -->

<script>

const materialData = {

    "wall-panel-kayu": {
        label: "Wall Panel Kayu",
        price: 75000,
        unit: "m²",
        items: [
            ["WM-01", "Merah Cokelat Kayu"],
            ["WM-02", "Kuning Krem"],
            ["WM-04", "Cokelat Kayu Muda"],
            ["WM-05", "Putih"],
            ["WM-06", "Cokelat Abu (Taupe)"],
            ["WM-07", "Cokelat Tua"],
            ["WM-08", "Abu-abu"],
            ["WM-09", "Cokelat Oranye Kayu"],
            ["WM-10", "Hitam"],
            ["WM-12", "Kuning Keemasan"],
            ["WM-13", "Cokelat Abu-abu"],
            ["WMB-04", "Cokelat Cream"]
        ]
    },

    "wallpaper-motif": {
        label: "Wallpaper Motif",
        price: 150000,
        unit: "m²",
        items: [
            ["WP-001", "Marmer Merah Muda"],
            ["WP-002", "Emas Putih"],
            ["WP-003", "Elegansi Beige"],
            ["WP-004", "Emas Klasik"],
            ["WP-005", "Hamparan Pasir"],
            ["WP-006", "Laut Abu-abu"],
            ["WP-007", "Batu Daun"],
            ["WP-008", "Emas Daun"],
            ["WP-009", "Marmer Ivory"],
            ["WP-010", "Emas Biru"],
            ["WP-011", "Emas Mawar"],
            ["WP-012", "Marmer Hijau"],
            ["WP-013", "Cokelat Krim"],
            ["WP-014", "Emas Hitam"],
            ["WP-015", "Emas Perak"],
            ["WP-016", "Klasik Beige"]
        ]
    },

    "marmer-gold": {
        label: "Marmer Gold",
        price: 490000,
        unit: "m²",
        items: [
            ["FM-04", "Marmer Gold Putih"],
            ["FM-06", "Marmer Abu Gold"]
        ]
    },

    "panel-marmer": {
        label: "Panel Marmer",
        price: 80000,
        unit: "m²",
        items: [
            ["TB-09", "Hitam Marmer Glossy"],
            ["B109-34", "Putih Abu Marmer"],
            ["B109-38", "Abu Tua Marmer"],
            ["B109-40", "Krem Marmer"]
        ]
    },

    "panel-premium": {
        label: "Panel Premium",
        price: 55000,
        unit: "m²",
        items: [
            ["B812-6", "Abu-abu Muda Tekstur Kain"],
            ["B814-1", "Gold Mengkilap"],
            ["B814-2", "Putih Tekstur Halus"],
            ["B812-2", "Putih Krem Tekstur Kain"]
        ]
    },

    "panel-tekstur-kain": {
        label: "Panel Tekstur Kain",
        price: 120000,
        unit: "m²",
        items: [
            ["X7052-A109", "Abu-abu Tua Tekstur Kayu"],
            ["WV-08", "Abu-abu Muda Tekstur Kain"],
            ["WV-10", "Kayu Natural Cokelat Muda"],
            ["WV-10-2", "Abu-abu Terang"],
            ["WV-04", "Putih Tekstur Halus"],
            ["WV-05", "Putih Krem Tekstur Kain"],
            ["WV-07", "Kayu Cokelat Keemasan"],
            ["FWB-03", "Putih Abu-abu Tekstur Halus"],
            ["WV-09", "Kayu Cokelat Tua"],
            ["FWB-02", "Kayu Natural Cokelat Muda"],
            ["X7053-A109", "Abu-abu Beige Tekstur Kayu"],
            ["WV-06", "Putih Gading Tekstur Halus"],
            ["X7051-A109", "Abu-abu Muda Tekstur Kayu"]
        ]
    },

    "tekstur-kayu-kain": {
        label: "Tekstur Kayu & Kain",
        price: 90000,
        unit: "m²",
        items: [
            ["FB-01", "Cokelat Kayu Natural"],
            ["FB-02", "Putih Marmer Elegan"],
            ["FB-05", "Krem Marmer Classic"],
            ["FG-07", "Abu Marmer Modern"],
            ["FG-01", "Beige Kayu Natural"],
            ["FG-02", "Putih Cream Minimalis"],
            ["FB-06", "Hitam Gold Premium"],
            ["ACJ-02", "Putih Abu Marmer"],
            ["ACJ-15", "Beige Marmer Natural"],
            ["AC-14", "Abu Tua Marmer"]
        ]
    },

    "lem-perekat": {
        label: "Lem & Perekat",
        price: 45000,
        unit: "pcs",
        items: [
            ["LN-01", "Lem Liquid Nail"]
        ]
    }

};


/* =====================================================
   FORMAT RUPIAH
===================================================== */

function formatRupiah(angka) {

    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        maximumFractionDigits: 0
    }).format(angka);

}


/* =====================================================
   ELEMEN
===================================================== */

const jenisSelect =
    document.getElementById("jenisMaterial");

const materialSelect =
    document.getElementById("materialPilihan");

const jumlahInput =
    document.getElementById("jumlah");

const namaMaterialInput =
    document.getElementById("nama_material");

const hargaSatuanInput =
    document.getElementById("harga_satuan");

const totalHargaInput =
    document.getElementById("total_harga");

const materialTampil =
    document.getElementById("materialTampil");

const hargaMaterial =
    document.getElementById("hargaMaterial");

const totalHargaTampil =
    document.getElementById("totalHargaTampil");


/* =====================================================
   ISI JENIS MATERIAL
===================================================== */

Object.entries(materialData).forEach(
    function ([key, material]) {

        const option =
            document.createElement("option");

        option.value = key;

        option.textContent =
            material.label;

        jenisSelect.appendChild(option);

    }
);


/* =====================================================
   ISI KODE + NAMA
===================================================== */

function isiMaterial(jenis) {

    materialSelect.innerHTML = "";

    const awal =
        document.createElement("option");

    awal.value = "";

    awal.textContent =
        "Pilih kode & nama material";

    awal.disabled = true;

    awal.selected = true;

    materialSelect.appendChild(awal);


    if (!jenis || !materialData[jenis]) {
        return;
    }


    materialData[jenis].items.forEach(
        function (item, index) {

            const option =
                document.createElement("option");

            option.value = index;

            option.textContent =
                item[0] + " — " + item[1];

            materialSelect.appendChild(option);

        }
    );

}


/* =====================================================
   UPDATE DETAIL
===================================================== */

function updateDetail() {

    const jenis =
        jenisSelect.value;

    const index =
        materialSelect.value;

    if (
        !jenis ||
        !materialData[jenis] ||
        index === ""
    ) {

        materialTampil.textContent = "-";

        hargaMaterial.textContent = "-";

        totalHargaTampil.textContent = "Rp0";

        totalHargaInput.value = 0;

        namaMaterialInput.value = "";

        hargaSatuanInput.value = 0;

        return;
    }


    const material =
        materialData[jenis];

    const item =
        material.items[index];

    const jumlah =
        Number(jumlahInput.value) || 1;


    const total =
        material.price * jumlah;


    materialTampil.textContent =
        item[0] + " — " + item[1];


    hargaMaterial.textContent =
        formatRupiah(material.price)
        + " / "
        + material.unit;


    totalHargaTampil.textContent =
        formatRupiah(total);


    totalHargaInput.value =
        total;


    namaMaterialInput.value =
        item[1];


    hargaSatuanInput.value =
        material.price;

}


/* =====================================================
   EVENT
===================================================== */

jenisSelect.addEventListener(
    "change",
    function () {

        isiMaterial(this.value);

        updateDetail();

    }
);


materialSelect.addEventListener(
    "change",
    updateDetail
);


jumlahInput.addEventListener(
    "input",
    updateDetail
);


/* =====================================================
   DATA LAMA SAAT EDIT
===================================================== */

<?php if ($editData): ?>

const produkLama = <?= json_encode($editData["produk"]); ?>;

// Ambil jenis material dari baris pertama, misalnya: 1. wallpaper-motif
const jenisMatch = produkLama.match(/^\s*\d+\.\s*([^\n]+)/i);
const kodeMatch = produkLama.match(/Kode:\s*([^\n]+)/i);
const jumlahMatch = produkLama.match(/Jumlah:\s*(\d+)/i);

if (jumlahMatch) {
    jumlahInput.value = parseInt(jumlahMatch[1], 10);
}

let jenisDitemukan = "";
let indexDitemukan = "";
const jenisLama = jenisMatch ? jenisMatch[1].trim() : "";
const kodeLama = kodeMatch ? kodeMatch[1].trim() : "";

// Format pesanan lama yang menyimpan key jenis dan indeks item, seperti Kode: 10.
if (jenisLama && materialData[jenisLama]) {
    jenisDitemukan = jenisLama;
    const material = materialData[jenisLama];

    // Utamakan pencocokan kode material asli, misalnya WP-011.
    let index = material.items.findIndex(function (item) {
        return item[0].toLowerCase() === kodeLama.toLowerCase();
    });

    // Jika yang tersimpan adalah indeks numerik dari dropdown, gunakan indeks itu.
    if (index === -1 && /^\d+$/.test(kodeLama)) {
        const angkaKode = parseInt(kodeLama, 10);
        if (angkaKode >= 0 && angkaKode < material.items.length) {
            index = angkaKode;
        }
    }

    if (index !== -1) {
        indexDitemukan = index;
    } else {
        jenisDitemukan = "";
    }
}

// Cadangan untuk data lama yang hanya menyimpan kode material asli.
if (!jenisDitemukan && kodeLama) {
    Object.entries(materialData).some(function ([key, material]) {
        const index = material.items.findIndex(function (item) {
            return item[0].toLowerCase() === kodeLama.toLowerCase();
        });

        if (index !== -1) {
            jenisDitemukan = key;
            indexDitemukan = index;
            return true;
        }
        return false;
    });
}

if (jenisDitemukan && indexDitemukan !== "") {
    jenisSelect.value = jenisDitemukan;
    isiMaterial(jenisDitemukan);
    materialSelect.value = String(indexDitemukan);
    updateDetail();
}

<?php endif; ?>

</script>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


</body>

</html>