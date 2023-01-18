<?php
include("koneksi.php");

//Query untuk menampilkan, mencari, membagi data perhalaman
$q = "";
if (isset($_GET['submit']) && !empty($_GET['q'])) {
    $q = $_GET['q'];
    $sql_where = "WHERE nama LIKE '{$q}%'"; 
}
$title = 'Data Barang';
$sql = 'SELECT * FROM data_barang ';
$sql_count = "SELECT COUNT(*) FROM data_barang";
if (isset($sql_where)) {
    $sql .= $sql_where;
    $sql_count .= $sql_where;
}
$result_count = mysqli_query($conn, $sql_count);
$count = 0;
if ($result_count) {
    $r_data = mysqli_fetch_row($result_count);
    $count = $r_data[0];
}
$per_page = 2;
$num_page = ceil ($count / $per_page);
$limit = $per_page;
if(isset($_GET['page'])) {
    $page = $_GET['page'];
    $offset = ($page - 1) * $per_page;
    $previous = $page - 1;
    $next = $page + 1;
} else {
    $offset = 0;
    $page = 1;
}
$sql .= "LIMIT {$offset},{$limit}";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Data Barang</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="container">
        <header>
            <h1>Membuat Database Sederhana</h1>
        </header>
        <nav>
            <a href="index.php" li class=active>Home</a>
            <a href="login.php">Login</a>
        </nav>
        <div class="container">
            <tr>
                <a href="tambah.php?id=" class="buttontambah">Tambah Barang</a> <br><br><br>
            </tr>
            <form action="" method="get">
                <label for="q">Cari Data </label>
                <input type="text" id="q" name="q" class="input-q" value="<?php echo $q ?>">
                <input type="submit" name="submit" value="Cari" class="buttoncari"> <br><br>
            </form>
            <table class="table table-striped table-hover">
            <tr>
                <th>Gambar</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            <?php if($result): ?>
            <?php while($row = mysqli_fetch_array($result)): ?>
            <tr>
                <td><img src="gambar/<?= $row['gambar'];?>" alt="<?=$row['nama'];?>"></td>
                <td><?= $row['nama'];?></td>
                <td><?= $row['kategori'];?></td>
                <td><?= $row['harga_jual'];?></td>
                <td><?= $row['harga_beli'];?></td>
                <td><?= $row['stok'];?></td>
                <td>
                    <a class="button1" href="ubah.php?id=<?= $row['id_barang'];?>">Ubah</a>
                    <a class="button2" href="hapus.php?id=<?= $row['id_barang'];?>">Hapus</a> 
                </td>
            </tr>
            <?php endwhile; else: ?>
            <tr>
                <td colspan="7">Belum ada data</td>
            </tr>
            <?php endif; ?>
            </table><br>
            <ul class = "pagination">
                <li class="page-item">
                    <a class="page-link" <?php if($page > 1){ echo "href='?page=$previous'"; }  ?>><<</a>
				</li>
                <?php for ($i=1; $i <= $num_page; $i++) {
                    $link = "?page={$i}";
                    if (!empty($q)) $link .= "&q={$q}";
                    $class = ($page == $i ? 'active' : '');
                    echo "<li><a class=\"{$class}\" href=\"{$link}\">{$i}</a></li>";
                } ?>
                
                <li class="page-item">
					<a  class="page-link" <?php if($offset < $page){ echo "href='?page=$next'"; } ?>>>></a>
				</li>
            </ul>
        </div>
        <footer>
            <p>&copy; 2023, Teknik Informatika, Universitas Pelita Bangsa</p>
        </footer>
    </div>
</body>
</html>