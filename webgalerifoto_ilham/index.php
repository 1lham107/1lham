<?php
    include 'db.php';
	$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_address FROM tb_admin WHERE admin_id = 2");
	$a = mysqli_fetch_object($kontak);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Galeri Fotoku</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
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
    
    <div class="search">
    <div class="container">
       
        <div class="search-wrapper">
            <form action="galeri.php" method="GET" class="search-form">
                <input type="text" name="search" placeholder="Cari Foto" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>" />    
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
    <div class="container">
       <h3>Foto Terbaru</h3>
       <div class="box">
          <?php
              $foto = mysqli_query($conn, "SELECT * FROM tb_image WHERE image_status = 1 ORDER BY image_id DESC LIMIT 8");
			  if(mysqli_num_rows($foto) > 0){
				  while($p = mysqli_fetch_array($foto)){
		  ?>
          <a href="detail-image.php?id=<?php echo $p['image_id'] ?>">
          <div class="col-4">
              <img src="foto/<?php echo $p['image'] ?>" height="150px" />
              <p class="nama"><?php echo substr($p['image_name'], 0, 30)  ?></p>
              <p class="admin">Nama User : <?php echo $p['admin_name'] ?></p>
              <p class="nama"><?php echo $p['date_created']  ?></p>
          </div>
          </a>
          <?php }}else{ ?>
              <p>Foto tidak ada</p>
          <?php } ?>
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
    const dropdown = document.querySelector('.dropdown');

    // Event listener untuk membuka/tutup dropdown
    filterButton.addEventListener('click', () => {
        dropdown.classList.toggle('active');
    });

    // Tutup dropdown jika klik di luar area
    document.addEventListener('click', (e) => {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove('active');
        }
    });
</script>

</html>