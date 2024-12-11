<?php
error_reporting(0);
include 'db.php';

// Default untuk WHERE kondisi
$where = "WHERE image_status = 1";

// Tambahkan filter berdasarkan parameter
if (!empty($_GET['filter'])) {
    $filter = mysqli_real_escape_string($conn, $_GET['filter']);
    $where .= " AND category_name = '$filter'";
}

// Tambahkan pencarian jika ada
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where .= " AND image_name LIKE '%$search%'";
}

// Query untuk mengambil data
$foto = mysqli_query($conn, "SELECT * FROM tb_image $where ORDER BY image_id DESC");
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galeri Fotoku</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .filterOption.selected {
            font-weight: bold;
            color: #2a6fdb;
        }
        .dropdownFilterOptions {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>
    <!-- header -->
    <header>
        <div class="container">
        <h1><a href="index.php"><span style="color:black;">GALERI </span>FOTO</a></h1>
            <ul>
                <li><a href="galeri.php">Galeri</a></li>
                <li><a href="registrasi.php">Registrasi</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </div>
    </header>

    <!-- search -->
    <div class="search">
    <div class="container">
        <!-- Wrapper untuk search bar dan dropdown -->
        <div class="search-wrapper">
            <form action="galeri.php" method="GET" class="search-form">
                <!-- Input teks untuk pencarian -->
                <input type="text" name="search" placeholder="Cari Foto" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" />
                <!-- Tombol untuk memulai pencarian -->
                <input type="submit" value="Cari Foto" />
            </form>
            <!-- Dropdown filter -->
            <div class="dropdown">
                <button id="dropdownBtnFilter">Filter<i class="fa-solid fa-chevron-down"></i></button>
                <div id="dropdownFilterOptions" class="dropdownFilterOptions">
                    <?php
                    $filters = ["Perjalanan", "Bawah Air", "Hewan Peliharaan", "Satwa Liar", "Makanan", "Olahraga", "Fashion", "Seni Rupa", "Dokumenter", "Arsitektur"];
                    $activeFilter = $_GET['filter'] ?? '';

                    foreach ($filters as $filterOption) {
                        echo '<a href="galeri.php?filter=' . urlencode($filterOption) . '" class="filterOption ' . ($activeFilter == $filterOption ? 'selected' : '') . '">' . $filterOption . '</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

   
    <!-- new product -->
    <div class="section">
        <div class="container">
            <h3>Galeri Foto</h3>
            <div class="box">
                <?php
                if (mysqli_num_rows($foto) > 0) {
                    while ($p = mysqli_fetch_array($foto)) {
                ?>
                <a href="detail-image.php?id=<?php echo $p['image_id']; ?>">
                    <div class="col-4">
                        <img src="foto/<?php echo $p['image']; ?>" height="150px" />
                        <p class="nama"><?php echo substr($p['image_name'], 0, 30); ?></p>
                        <p class="admin">Nama User: <?php echo $p['admin_name']; ?></p>
                        <p class="nama"><?php echo $p['date_created']; ?></p>
                    </div>
                </a>
                <?php 
                    }
                } else { 
                ?>
                <p>Foto tidak ada</p>
                <?php } ?>
            </div>
        </div>
    </div>

    <!-- footer -->
    <footer>
        <div class="container">
            <small>Copyright &copy; 2024 - Web Galeri Foto.</small>
        </div>
    </footer>

</body>
<script>
    const filterButton = document.getElementById('dropdownBtnFilter');
    const dropdownFilterOptions = document.getElementById('dropdownFilterOptions');

    dropdownFilterOptions.style.display = "none";

    filterButton.addEventListener('click', () => {
        if (dropdownFilterOptions.style.display === 'none') {
            dropdownFilterOptions.style.display = 'flex';
        } else {
            dropdownFilterOptions.style.display = 'none';
        }
    });
</script>
</html>
