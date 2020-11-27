<?php
	//Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "dblatihan";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));


	//jika tombol save di klik
	if (isset($_POST['bsave'])) 
	{
		//pengujian data akan diedit atau disimpan
		if($_GET['hal'] == "edit")
		{
			//data akan diedit
			$edit = mysqli_query($koneksi, "UPDATE tmhs set
												nim = '$_POST[tnim]',
												nama = '$_POST[tnama]',
												alamat = '$_POST[talamat]',
												prodi = '$_POST[tprodi]'
											WHERE id_mhs = '$_GET[id]'
											 ");
			if($edit)
			{
				echo "<script>
						alert('Data Berasil Di Ubah');
						document.location='index.php'
					 </script>";
			}
			else
			{
				echo "<script>
						alert('Data Tidak Berhasil Di Ubah');
						document.location='index.php'
					 </script>";
			}
		}
		else
		{
			//data akan disimpan baru
			$simpan = mysqli_query($koneksi, "INSERT INTO tmhs (nim, nama, alamat, prodi)
											  VALUES ('$_POST[tnim]', 
											  		 '$_POST[tnama]', 
											  		 '$_POST[talamat]', 
											  		 '$_POST[tprodi]')
											 ");
			if($simpan)
			{
				echo "<script>
						alert('Data Berhasil Disimpan');
						document.location='index.php'
					 </script>";
			}
			else
			{
				echo "<script>
						alert('Data Gagal Disimpan');
						document.location='index.php'
					 </script>";
			}
		}
		
	}

	//pengujian jika tombol edit atau delete di klik
	if(isset($_GET['hal']))
	{
		//pengujian jika edit data
		if($_GET['hal'] == "edit")
		{
			//tampilkan data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//jika data ditemukan ditampung ke variable
				$vnim = $data['nim'];
				$vnama = $data['nama'];
				$valamat = $data['alamat'];				
				$vprodi = $data['prodi'];
			}
		}
		else if($_GET['hal'] == "hapus")
		{
			//persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Data Berhasil Di Hapus');
						document.location='index.php'
					 </script>";
			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Latihan CRUD KK4B</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
	
<font color ="black" style="font-family: Monserrat">
<h1 class="text-center">Daftar Murid SMK Telkom Purwokerto</h1>
<h2 class="text-center">Frezza Bintang XIRPL3 (16)</h2>

<!-- Awal Card Form -->
<div class="card mt-5">
  <div class="card-header bg-danger text-white">
    From Input Data Siswa
  </div>
  <div class="card-body">
   <form method="post" action="">
   		<div class="form-group">
   			<label>ID Siswa</label>
   			<input type="text" name="tnim" value="<?=@$vnim?>" class="form-control" placeholder="Masukan ID Anda" required>
   		</div>
   		<div class="form-group">
   			<label>Nama Siswa</label>
   			<input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Input Nama Anda" required>
   		</div>
   		<div class="form-group">
   			<label>Alamat Siswa</label>
   			<textarea class="form-control" name="talamat" placeholder="Input Alamat Anda"><?=@$valamat?></textarea>
   		</div>
   		<div class="form-group">
   			<label>Jurusan</label>
   			<select class="form-control" name="tprodi">
   				<option value="<?=@$vjurusan?>"><?=@$vjurusan?></option>
   				<option value="RPL">RPL</option>
   				<option value="TKJ">TKJ</option>
   				<option value="TJA">TJA</option>
   				<option value="Multimedia">Multimedia</option>
   			</select>
   		</div>

   		<button type="submit" class="btn btn-success" name="bsave">Simpan</button>
   		<button type="reset" class="btn btn-danger" name="breset">Set Ulang Form</button>

   </form>
  </div>
</div>
<!-- Akhir Card Form -->

<!-- Awal Card Tabel -->
<div class="card mt-3">
  <div class="card-header bg-success text-white">
    Daftar Siswa SMK TELKOM Purwokerto
  </div>
  <div class="card-body">
   
   <table class="table table-bordered table-striped">
   		<tr>
   			<th>No.</th>
   			<th>ID</th>
   			<th>Nama</th>
   			<th>Alamat</th>
   			<th>Jurusan</th>
   			<th>Perintah</th>
   		</tr>
   		<?php
   			$no = 1;
   			$tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
   			while($data = mysqli_fetch_array($tampil)) :
   		?>
   		<tr>
   			<td><?=$no++?></td>
   			<td><?=$data['nim']?></td>
   			<td><?=$data['nama']?></td>
   			<td><?=$data['alamat']?></td>
   			<td><?=$data['prodi']?></td>
   			<td>
   				<a href="index.php?hal=edit&id=<?=$data['id_mhs']?>" class="btn btn-warning"> Edit </a>
   				<a href="index.php?hal=hapus&id=<?=$data['id_mhs']?>" onclick="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-success"> Hapus </a>
   			</td>
   		</tr>
   	<?php endwhile; //penutup perulangan while ?>
   </table>

  </div>
</div>
<!-- Akhir Card Tabel -->
</div>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>