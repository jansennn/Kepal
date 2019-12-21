<?php  
	session_start();
	global $conn;
	$conn = new mysqli("localhost","root","","db_pa1") or die("Error connection to database");
?>

<?php  
	if(isset($_GET['loginAcc'])) {
		loginAcc();
	}

	if(isset($_GET['do_logout'])) {
		session_destroy();
		header("location: index.php");
	}

	if(isset($_GET['registerMember'])) {
		registrasi();
	}

	if(isset($_GET['editCurAccount'])) {
		$id = $_GET['editCurAccount'];
		editAkun($id);
	}

	if(isset($_GET['editPass'])) {
		$id = $_GET['editPass'];
		editPassword($id);
	}

	if(isset($_GET['deleteUser'])) {
		$id = $_GET['deleteUser'];
		deleteUser($id);
	}

	if(isset($_GET['buatKomentar'])) {
		$id = $_GET['buatKomentar'];
		buat_komentar($id);
	}

	if(isset($_GET['deleteComent'])) {
		$id = $_GET['deleteComent'];
		hapusKomentar($id);
	}

	if(isset($_GET['tanggapKomentar'])) {
		$id_komentar = $_GET['tanggapKomentar'];
		tanggapi_komentar($id_komentar);
	}

	if(isset($_GET['ubahDeskripsi'])) {
		$id_gambar = $_GET['ubahDeskripsi'];
		ubah_Deskripsi($id_gambar);
	}
	
	if(isset($_GET['buatGambarBaru'])) {
		tambah_Gambar();
	}

	if(isset($_GET['deleteGambar'])) {
		$id = $_GET['deleteGambar'];
		Hapus_gambar($id);
	}

	if(isset($_GET['hapusAkun'])) {
		$id = $_GET['hapusAkun'];
		hapus_akun($id);
	}

	if(isset($_GET['updateProduks'])) {
		$id_produk = $_GET['updateProduks'];
		update_Produk($id_produk);
	}

	if(isset($_GET['buatProduks'])) {
		buat_Produks();
	}

	if(isset($_GET['deleteProduk'])) {
		$id = $_GET['deleteProduk'];
		hapusProduk($id);
	}

	if(isset($_GET['masukKeranjang'])) {
		// $id = $_GET['masukKeranjang'];
		tambahKeKeranjang($_GET['masukKeranjang']);
	}

	if(isset($_GET['batalPesan'])) {
		$id = $_GET['batalPesan'];
		batalPesan($id);
	}

	if(isset($_GET['prosesKeranjang'])) {		
		prosesKeranjang();
	}

	if(isset($_GET['terimaTrans'])) {
		updateTransaksi();
		terimaTrans();
	}

	if(isset($_GET['tolakTrans'])) {
		updateTransaksis();
		tolakTrans();
	}

	if(isset($_GET['hapusRiwayatTransaksi'])) {
		$id_transaksi = $_GET['hapusRiwayatTransaksi'];
		hapusRiwayatTransaksi($id_transaksi);
	}

	if(isset($_GET['bokingSekarang'])) {
		bokingSekarang($_GET['bokingSekarang']);
	}

	if(isset($_GET['terimaRequest'])) {
		updateInformasiKursi($_GET['terimaRequest']);
		terimaRequest($_GET['terimaRequest']);
	}

	if(isset($_GET['tolakRequest'])) {
		tolakRequest($_GET['tolakRequest']);
	}

	if(isset($_GET['ubahDeskripsiKursi'])) {
		$id_meja = $_GET['ubahDeskripsiKursi'];
		ubahDeskripsiKursi($id_meja);
	}

	if(isset($_GET['deleteMeja'])) {
		$id_meja = $_GET['deleteMeja'];
		deleteMeja($id_meja);
	}

	if(isset($_GET['buatMejaBarus'])) {
		mejaBaru();
	}

	if(isset($_GET['deleteRequestMeja'])) {
		$id_request = $_GET['deleteRequestMeja'];
		deleteRequestMeja($id_request);
	}

	if(isset($_GET['hapusSemuaRequest'])) {
		hapusSemuaRequest();
	}

	if(isset($_GET['hapusRiwayatTrans'])) {
		$id_transaksi = $_GET['hapusRiwayatTrans'];
		hapusRiwayatTransaksi1($id_transaksi);
	}

	if(isset($_GET['updateKaryawan1'])) {
		$id_karyawan = $_GET['updateKaryawan1'];
		updateKaryawan($id_karyawan);
	}

	if(isset($_GET['deleteKaryawan'])) {
		$id_karyawan = $_GET['deleteKaryawan'];
		deleteKaryawan($id_karyawan);
	}

	if(isset($_GET['tambahKaryawan1'])) {
		tambah_karyawan11();
	}

	if(isset($_GET['deletePemasukan'])) {
		$id = $_GET['deletePemasukan'];
		deletePemasukan1($id);
	}

	if(isset($_GET['hapusAllPemasukan'])) {
		hapusAllPemasukan1();
	}
?>

<!-- Fungsi-fungsi -->

<?php  
	
	function execQ($strQ) {
		global $conn;
		$res = mysqli_query($conn,$strQ);
		return $res;
	}

	function loginAcc() {
		global $conn;
		$email = $_POST['email'];
		$pass = $_POST['password'];
		$query = "SELECT * FROM t_akun WHERE email = '$email' AND password = '$pass'";

		$result = mysqli_query($conn, $query);

		$email_konfirmasi = "";
		$pass_konfirmasi = "";
		$nama_konfirmasi = "";
		$role_konfirmasi = "";
		$id_member = "";

		while($row = mysqli_fetch_array($result)) {
			$email_konfirmasi = $row['email'];
			$pass_konfirmasi = $row['password'];
			$nama_konfirmasi = $row['nama'];
			$role_konfirmasi = $row['role'];
			$id_member = $row['id'];	
		}

		if($email == $email_konfirmasi && $pass == $pass_konfirmasi && $role_konfirmasi == 1) {
			$_SESSION['admin'] = 1;
			$_SESSION['is_logged_in'] = 1;
			// $_SESSION['alert'] = 0;
			$_SESSION['nama'] = $nama_konfirmasi;
			$_SESSION['id'] = $id_member;
			header('location: index.php');
 		}
 		else if($email == $email_konfirmasi && $pass == $pass_konfirmasi && $role_konfirmasi == 2) {		
 			$_SESSION['user_biasa'] = 1;
			$_SESSION['is_logged_in'] = 1;
			$_SESSION['alert'] = 0;
			$_SESSION['nama'] = $nama_konfirmasi;
			$_SESSION['id'] = $id_member;
			header('location: index.php');
 		}

 		else {
 			echo"<script>alert('$email_konfirmasi xemail and password was incorrect');</script>";
            var_dump($_SESSION);
            $_SESSION['is_logged_in'] = 0;
 			header("Refresh:0 url=login.php");
 		}
	}

	function registrasi() {
		global $conn;
		$nama = $_POST['nama'];
		$email = $_POST['email'];
		$alamat = $_POST['alamat'];
		$pass = $_POST['password'];
		$konf_pass = $_POST['password_konf'];
		$role = 2;

		$email_valid = mysqli_query($conn,"SELECT email from t_akun WHERE email = '$email'");
		$hitung = mysqli_num_rows($email_valid);
		if($hitung != 0) {
			echo"<script>alert('Email sudah ada!');</script>";
			header('Refresh:1;url=register.php');
		}
		else if($pass != $konf_pass) {
			echo"<script>alert('Kombinasi password tidak sesuai!');</script>";
			header('Refresh:1;url=register.php');	
		}
		else {
			$query = mysqli_query($conn,"INSERT INTO t_akun VALUES('','$nama','$email','$pass','$alamat','$role')");
			
			echo"<script>alert('Berhasil terdaftar!');</script>";
			header('Refresh:1;url=login.php');						
	 }

	 $id_user = mysqli_insert_id($conn);
	 $querii = "INSERT INTO t_keranjang VALUES('$id_user','$id_user')";
	 $hasilkan = mysqli_query($conn,$querii);
}

	function editAkun($id) {
		global $conn;

		$nama = $_POST['nama'];
		$alamat = $_POST['alamat'];
		// $email = $_POST['email'];
		$password = $_POST['password'];

		$query = "SELECT * FROM t_akun WHERE id = '$id'";
		$hasil = $conn->query($query);
		$data = $hasil->fetch_assoc();

		if($password == $data['password']) {
			$querys = mysqli_query($conn,"UPDATE t_akun SET nama='$nama',alamat='$alamat' WHERE id='$id'");

			if($querys) {
				$queries = "SELECT * FROM t_akun WHERE id='$id'";

				$hasil = mysqli_query($conn,$queries);

				$nama = '';
				$alamat = '';
				$email = '';

				while($row = mysqli_fetch_array($hasil)) {
					$nama = $row['nama'];
					$alamat = $row['alamat'];
					$email = $row['email'];
				}
				$_SESSION['nama'] = $nama;
				$_SESSION['alamat'] = $alamat;
				$_SESSION['email'] = $email;
				echo "<script>alert('Akun telah diperbarui!');</script>";
				header("Refresh:0 url=profile.php?lihatUser=$id");
			}
		}
			else {
				echo "<script>alert('Password salah, silahkan coba lagi!');</script>";
				header("Refresh:0 url=profile.php?editAkun=$id");
			}
		}

		function editPassword($id) {
			global $conn;

			$password = $_POST['password'];
			$n_password = $_POST['npassword'];
			$cnpassword = $_POST['cnpassword'];

			$query = "SELECT * FROM t_akun WHERE id='$id'";
			$hasil = $conn->query($query);
			$data = $hasil->fetch_assoc();

			if($password == $data['password']) {
				if($n_password == $cnpassword) {
					$queries = mysqli_query($conn,"UPDATE t_akun SET password='$n_password' WHERE id='$id'");
					if($queries) {
						echo "<script>alert('Password telah diperbarui!');</script>";
						header("Refresh:0 url=profile.php?lihatUser=$id");
					}
				}
				else {
					echo "<script>alert('Kombinasi Password Salah!');</script>";
					header("Refresh:0 url=profile.php?lihatUser=$id");
				}
			}
			else {
				echo "<script>alert('Password salah, silahkan mencoba lagi!');</script>";
				header("Refresh:0 url=profile.php?lihatUser=$id");
			}

		}

		function getAllUser() {
			global $conn;

			$strQ = "SELECT * FROM t_akun ORDER BY role ASC";
			$resItem = execQ($strQ);

			if(mysqli_num_rows($resItem) != 0) {
				$ret = array();
				while ($data = mysqli_fetch_assoc($resItem)) {
					array_push($ret, array (
						'id' => $data['id'],
						'nama' => $data['nama'],
						'email' => $data['email'],
						'alamat' => $data['alamat'],
						'role' => $data['role'],
					));
				}
				return $ret;
			} else {
				return false;
			}
		}

		function deleteUser($id) {
			global $conn;
			
			$id_user = $id;

			$kueri = "DELETE FROM t_bookmeja WHERE id_user = '$id_user'";
			$hapus = mysqli_query($conn,$kueri)or die(mysqli_error($conn));

			$kueri2 = "DELETE FROM t_items WHERE id_user = '$id_user'";
			$hapus2 = mysqli_query($conn,$kueri2)or die(mysqli_error($conn));

			$kueri3 = "DELETE FROM t_komentar WHERE id_user = '$id_user'";
			$hapus3 = mysqli_query($conn,$kueri3)or die(mysqli_error($conn));			

			$kueri4 = "DELETE FROM t_transaksi WHERE id_user = '$id_user'";
			$hapus4 = mysqli_query($conn,$kueri4)or die(mysqli_error($conn));						

			$kueri5 = "DELETE FROM t_keranjang WHERE id_user = '$id_user'";
			$hapus5 = mysqli_query($conn,$kueri5)or die(mysqli_error($conn));									

			$queri = "DELETE FROM t_akun WHERE id = '$id_user'";
			$delete = mysqli_query($conn,$queri);
			if($conn->query($queri) == TRUE) {
				echo "<script>alert('Pengguna Telah dihapus!')</script>";
				header("Refresh:0 url=kelola_user.php");
			} else {
				echo "<script>alert('Pengguna Belum dihapus!')</script>";
				header("Refresh:0 url=kelola_user.php");
			}			
		}

		function buat_komentar($id) {
			global $conn;

			date_default_timezone_set('Asia/Jakarta');

			$tanggal = date('Y-m-d');
			$isi = $_POST['komentar'];

			if($isi == NULL) {
				echo "<script>alert('Harap isi komentar anda!');</script>";
				header("Refresh:0 url=komentar.php");
			} else {
				$tambah_komentar = mysqli_query($conn,"INSERT INTO t_komentar VALUES('','$id','$isi','$tanggal','')");
				if($tambah_komentar) {
					echo "<script>alert('Komentar berhasil dikirim!');</script>";
					header("Refresh:0 url=komentar.php?getAllComentar");
				} else {
					echo "<script>alert('Komentar gagal dikirim!');</script>";
					header("Refresh:0 url=komentar.php?buatKomentari");
				}

			}
		}

		function getAllComentar() {
			global $conn;

			$strQ = "SELECT id_komentar,id_user,isi,tanggal_komentar,tanggapan,nama FROM t_komentar,t_akun WHERE t_komentar.id_user = t_akun.id ORDER BY tanggal_komentar DESC";
			$resItem = execQ($strQ);

			if(mysqli_num_rows($resItem) != 0) {
				$ret = array();
				while($data = mysqli_fetch_assoc($resItem)) {
					array_push($ret,array(
						'id_komentar' => $data['id_komentar'],
						'id_user' => $data['id_user'],
						'isi_komentar' => $data['isi'],
						'tanggal_komentar' => $data['tanggal_komentar'],
						'nama' => $data['nama'],
						'tanggapan' => $data['tanggapan'],

					));
				}
				return $ret;
			} else {
				return false;
			}
		}

		function hapusKomentar($id) {
			global $conn;
			
			$hapus = "DELETE FROM t_komentar WHERE id_komentar = '$id'";
			if($conn->query($hapus) == TRUE) {
				echo "<script>alert('Komentar telah dihapus!')</script>";
				header("Refresh:0 url=komentar.php?allKomentar");
			}
			else {
				echo "<script>alert('Tidak terhapus!')</script>";
				header("Refresh:0 url=komentar.php?allKomentar");
			}
		}

		function tanggapi_komentar($id) {
			global $conn;

			$tanggapan = $_POST['tanggapan'];
			
			$tanggapi = "UPDATE t_komentar SET tanggapan = '$tanggapan' WHERE id_komentar = '$id'";
			if($conn->query($tanggapi) == TRUE) {
				echo "<script>alert('tanggapan telah terkirim!')</script>";
				header("Refresh:0 url=komentar.php?allKomentar");
			}
			else {				
				echo "<script>alert('tanggapan gagal terkirim!')</script>";
				header("Refresh:0 url=komentar.php?allKomentar");					
			}
		}

		function ubah_Deskripsi($id) {
			global $conn;

			$updata_deskripsi = $_POST['deskripsi'];

			$ubah = "UPDATE t_galeri SET deskripsi = '$updata_deskripsi' WHERE id_gambar = '$id'";
			if($conn->query($ubah) == TRUE) {
				echo "<script>alert('Deskripsi telah diubah!')</script>";
				header("Refresh:0 url=galeri.php?crudGaleri");	
			}
			else {
				echo "<script>alert('Deskripsi gagal diubah!')</script>";
				header("Refresh:0 url=galeri.php?crudGaleri");		
			}
		}

		function tambah_Gambar() {

			global $conn;

			$fileExistsFlag = 0; 
			$fileName = $_FILES['picture']['name'];

			$query = "SELECT gambar FROM t_galeri WHERE gambar='$fileName'";	
			$result = $conn->query($query) or die("Error : ".mysqli_error($conn));

			while($row = mysqli_fetch_array($result)) {
			if($row['gambar'] == $fileName) {
			$fileExistsFlag = 1;
				}		
			}

			if($fileExistsFlag == 0) { 
				$target = "assets/img/galeri/";
				$fileTarget = $target.$fileName;
				$tempFileName = $_FILES["picture"]["tmp_name"];
				$fileDescription = $_POST['description'];	
				$result = move_uploaded_file($tempFileName,$fileTarget);

				if($result) {
					echo "<script>alert('Berhasil!')</script>";
					header("Refresh:0 url=galeri.php?crudGaleri");
					$query = "INSERT INTO t_galeri VALUES ('','$fileName','$fileDescription')";
					$conn->query($query) or die("Error : ".mysqli_error($conn));		
				}
				else {			
				echo "Sorry !!! There was an error in uploading your file";
					
			}	

			}
			else {			
			echo "<script>alert('File telah ada di di folder,Coba lagi!')</script>";
			header("Refresh:0 url=galeri.php?createNewImage");
			}	
		}

		function Hapus_gambar($id) {

			global $conn;

			$queri = "DELETE FROM t_galeri WHERE id_gambar = '$id'";
			if($conn->query($queri) == TRUE) {
				echo "<script>alert('Berhasil dihapus!')</script>";
				header("Refresh:0 url=galeri.php?crudGaleri");
			}
			else {
				echo "<script>alert('Gagal dihapus!')</script>";
				header("Refresh:0 url=galeri.php?crudGaleri");	
			}
		}

		function hapus_akun($id) {
			global $conn;

			$queri = "DELETE FROM t_akun WHERE id = '$id'";
			if($conn->query($queri) == TRUE) {
				$_SESSION['is_logged_in'] = 0;
				echo "<script>alert('Berhasil dihapus!')</script>";
				header("Refresh:0 url=index.php");
			}
			else {
				echo "<script>alert('Gagal dihapus!')</script>";
				header("Refresh:0 url=profile.php?lihatUser='$id'");	
			}
		}

		function update_Produk($id_prod) {
			global $conn;

			$nama = $_POST['nama_prod'];
			$harga = $_POST['harga_prod'];
			$stok = $_POST['stok_prod'];
			$deskripsi = $_POST['deskripsi'];
			$profile = $nama.'.jpg';
			
			$filename =$_FILES['picture']['name'];
			
			if(isset($filename)) {
				move_uploaded_file($_FILES['picture']['tmp_name'], 'assets/img/produk/'.$nama.'.jpg');
				$profile = $nama.'.jpg';
			}

			$queri = mysqli_query($conn,"UPDATE t_produk SET nama_prod='$nama',harga='$harga',stok='$stok',gambar='$profile',deskripsi_prod = '$deskripsi' WHERE id_produk = '$id_prod'");
			if($queri) {
				echo "<script>alert('berhasil diupdate!')</script>";
				header("Refresh:0 url=produk.php?crudProduk");	
			} else {
				echo "<script>alert('gagal!')</script>";
				header("Refresh:0 url=produk.php?updateProduct=$id_prod");	
			}
		}

		function buat_Produks() {
			global $conn;

			$nama = $_POST['nama_prod'];
			$harga = $_POST['harga_prod'];
			$stok = $_POST['stok_prod'];
			$kategori = $_POST['kategori'];
			$deskripsi = $_POST['deskripsi'];

			$filename = $_FILES['picture']['name'];
			if(isset($filename)) {
				move_uploaded_file($_FILES['picture']['tmp_name'],'assets/img/produk/'.$nama.'.jpg');
				$profile = $nama.'.jpg';
			}

			$queri = mysqli_query($conn,"INSERT INTO t_produk VALUES('','$nama','$harga','$stok','$profile','$deskripsi','$kategori')");
			$res = execQ($queri);

			if($res) {
				echo "<script>alert('berhasil dibuat!')</script>";
				header("Refresh:0 url=produk.php?crudProduk");	
			} else {
				echo "<script>alert('berhasil dibuat!')</script>";
				header("Refresh:0 url=produk.php?crudProduk");	
			}
		}

		function hapusProduk($id_produk) {
			global $conn;
			$id_produks = $id_produk;

			$kuer = "DELETE FROM t_rating WHERE id_produk = '$id_produk'";
			$exa = mysqli_query($conn,$kuer);			

			$queri = "DELETE FROM t_produk WHERE id_produk = '$id_produk'";
			if($conn->query($queri) == TRUE) {
				echo "<script>alert('berhasil dihapus!')</script>";
				header("Refresh:0 url=produk.php?crudProduk");	
			} else {
				echo "<script>alert('gagal dihapus!')</script>";
				header("Refresh:0 url=produk.php?crudProduk");	
			}
		}

		function tambahKeKeranjang($id_produk) {
			global $conn;

			$id_user = $_SESSION['id'];
			$id_cart = $id_user;
			$id_produks = $id_produk;
			$jumlah = $_POST['jumlah'];			
			$status = "waiting";

			$queri = "SELECT stok,harga FROM t_produk WHERE id_produk='$id_produks'";
			$hasil = $conn->query($queri);
			$data = $hasil->fetch_assoc();
			$stok_lama = $data['stok'];
			$harga_produk = $data['harga'];
			
			if($jumlah < 1) {
				echo "<script>alert('Masukkan Jumlah Yang Mau Dibeli')</script>";
				header("Refresh:0 url=beli.php?beliProduct=$id_produk");				
			}
			else {
				$total_harga = $jumlah * $harga_produk;
				$masukKeranjang = mysqli_query($conn, "INSERT INTO t_items VALUES('', '$id_cart', '$id_produks', '$id_user', NULL, '$total_harga','$status','$jumlah')");
				if($masukKeranjang) {
					echo "<script>alert('Berhasil!')</script>";
					header("Refresh:0 url=keranjang.php?keranjangSaya=$id_user");						
				}
				else {
					echo "<script>alert('Gagal!')</script>";
					header("Refresh:0 url=beli.php?beliProduct=$id_produk");							
				}
			}
		}
		
		function getKeranjang() {
			global $conn;

			$id_user = $_SESSION['id'];
			// $q = "SELECT * FROM t_keranjang WHERE id_user = '$id_user'";
			// $qq = mysqli_query($conn,$q);		
			// $id_keranjang = mysqli_fetch_array($qq);
			// $id_keranjangs = $id_keranjang['id_keranjang'];

			$queri = "SELECT nama_prod, harga, id_keranjang, jumlah, status, total_harga,id_items FROM t_items,t_produk WHERE t_items.id_produk = t_produk.id_produk AND t_items.id_user = '$id_user' AND t_items.status = 'waiting'";
			$hasil = execQ($queri);

			if(mysqli_num_rows($hasil) != 0) {
				$ret = array();
				while($data = mysqli_fetch_assoc($hasil)) {
					array_push($ret, array(
						'nama_produk' => $data['nama_prod'],
						'harga_produk' => $data['harga'],
						'total_pesanan' => $data['jumlah'],
						'total_harga' => $data['total_harga'],
						'status' => $data['status'],
						'id_keranjang' => $data['id_keranjang'],
						'id_item' => $data['id_items'],				
					));
				}
				return $ret;
			} else {
				return false;
			}
		}
 
		function batalPesan($id_item) {
			global $conn;

			$queri = "DELETE FROM t_items WHERE id_items = '$id_item'";
			if($conn->query($queri) == TRUE) {
				echo "<script>alert('Berhasil dibatalkan!')</script>";
				header("Refresh:0 url=keranjang.php?keranjangSaya=$id_item");						
			}
		}

		function prosesKeranjang(){
		global $conn;

		date_default_timezone_get('Asia/Jakarta');

		$id_member = $_SESSION['id'];
		$id_cart = $_GET['prosesKeranjang'];
		$tanggal = date('Y-m-d');
		// $kodeTransaksi = kodeTransaksi();
		$status  = "Requested";
		
		$confirm = mysqli_query($conn, "INSERT INTO t_transaksi VALUES('', '$tanggal', NOW(), '$id_member', '$status')");
				
		$id_trans = mysqli_insert_id($conn);

		if($confirm){
			$query = mysqli_query($conn, "UPDATE t_items SET status='$status', id_transaksi='$id_trans' WHERE id_transaksi IS NULL AND id_keranjang = '$id_member'") or die(mysqli_error($conn));
			if($query){
				$strQ = "SELECT * FROM t_items WHERE id_transaksi='$id_trans'";
				$resItem = mysqli_query($conn, $strQ);
				while($item = mysqli_fetch_array($resItem)){
					$item_id = $item['id_produk'];
					$item_tot = $item['jumlah'];
					$strQ = "SELECT * FROM t_produk WHERE id_produk='$item_id'";
					$resItems = mysqli_query($conn, $strQ);
					// while($items = mysqli_fetch_array($resItems)){
					// 	$prod_id = $items['id_produk'];
					// 	$prod_stok = $items['stok'];
					// 	$new_stok = $prod_stok - $item_tot;
					// 	decreaseProduct($prod_id, $new_stok);
					// } 
				}

				echo "<script>alert('Berhasil');</script>";
				header("Refresh:0 url=keranjang.php?riwayatTransaksi=".$id_member."");
			}
		} else {
			echo "<script>alert('Gagal');</script>";
			header("Refresh:0 url=cart.php");
		}
	}
	
		function decreaseProduct($stok_baru,$id_produk) {
			global $conn;

			$queri = "UPDATE t_produk SET stok = '$stok_baru' WHERE id_produk = '$id_produk'";
			mysqli_query($conn,$queri);	
		}

		function getAllCarting(){
		
		global $conn;
		
		$id_member = $_SESSION['id'];

		$strQ = "SELECT * FROM t_transaksi WHERE id_user='$id_member' ORDER BY tanggal_transaksi DESC, jam DESC";
		$resItem = mysqli_query($conn, $strQ);
		return $resItem;
		}

		function getDetailCart($id_trans){
		
		global $conn;
		
		$id_member = $_SESSION['id'];

		$strQ = "SELECT * FROM t_items WHERE id_transaksi='$id_trans'";
		$resItem = mysqli_query($conn, $strQ);
		return $resItem;
	}

		function getAllDetailCarting($id_trans){
		
		global $conn;
		
		$id_member = $_SESSION['id'];

		$strQ = "SELECT * FROM t_transaksi WHERE id_transaksi='$id_trans'";
		$resItem = mysqli_query($conn, $strQ);
		return $resItem;
	}

	function semuaTransaksi() {
		global $conn;

		$queri = "SELECT * FROM t_transaksi ORDER BY tanggal_transaksi ASC";
		$hasil = mysqli_query($conn,$queri) or die(mysqli_error($conn));
		return $hasil;
	}

	function terimaTrans() {
		global $conn;

		$id_transaksi = $_GET['terimaTrans'];
		$status = 'Accepted';

		$queri = mysqli_query($conn,"UPDATE t_items SET status = '$status' WHERE status='Requested' AND id_transaksi = '$id_transaksi'" )or die(mysqli_error($conn));

		if($queri) {
			$queris = "SELECT * FROM t_items WHERE id_transaksi = '$id_transaksi'";
			$hasil = mysqli_query($conn,$queris)or die(mysqli_error($conn));
			while($data = mysqli_fetch_array($hasil)) {
				$id_produks = $data['id_produk'];
				$jumlah_pesananan = $data['jumlah'];

				$queriss = "SELECT * FROM t_produk WHERE id_produk = '$id_produks'";
				$hasils = mysqli_query($conn,$queriss)or die(mysqli_error($conn));
				// while($datas = mysqli_fetch_array($hasils)) {
				// 	$id_prod = $datas['id_produk'];
				// 	$stok = $datas['stok'];
				// 	$stok_baru = $stok - $jumlah_pesananan;
				// 	updateT_produk($id_prod,$stok_baru);
				// }
			}
			echo "<script>alert('Berhasil');</script>";
			header("Refresh:0 url=transaksi.php?semuaTransaksi");
		}
	}

	function updateT_produk($id_prod,$stok_baru) {
		global $conn;

		$queri = "UPDATE t_produk SET stok='$stok_baru' WHERE id_produk = '$id_prod'";
		mysqli_query($conn,$queri)or die(mysqli_error($conn));
	}

	function tolakTrans() {
		global $conn;

		$id_transaksi = $_GET['tolakTrans'];
		$status = 'Rejected';

		$queri = mysqli_query($conn,"UPDATE t_items SET status = '$status' WHERE status='Requested' AND id_transaksi = '$id_transaksi'" )or die(mysqli_error($conn));				
		echo "<script>alert('Berhasil');</script>";
		header("Refresh:0 url=transaksi.php?semuaTransaksi");
	}
	

	function updateTransaksi() {
		global $conn;

		$id_transaksi = $_GET['terimaTrans'];
		$status = 'Accepted';

		$queri = mysqli_query($conn,"UPDATE t_transaksi SET status = '$status' WHERE id_transaksi ='$id_transaksi'")or die(mysqli_error($conn));	
	}

	function updateTransaksis() {
		global $conn;
		
		$id_transaksi = $_GET['tolakTrans'];
		$status = 'Rejected';		

		$queri = mysqli_query($conn,"UPDATE t_transaksi SET status = '$status' WHERE id_transaksi ='$id_transaksi'")or die(mysqli_error($conn));	
	}
		
	function bokingSekarang($id_meja) {
		global $conn;

		date_default_timezone_set('Asia/Jakarta');  

		$id_user = $_SESSION['id'];
		$id_meja = $id_meja;

		$batas = $_POST['tgl_booked'];
		$batas1 = $_POST['tgl_booked1'];
		
		$kueri = "SELECT SUM(jumlah) AS jumlah_pesanan FROM t_bookmeja WHERE id_user = '$id_user' AND status = 'requested' AND id_meja = '$id_meja '";
		$kill = mysqli_query($conn,$kueri)or die(mysqli_error($conn));			
		while ($row = mysqli_fetch_assoc($kill)) { 
			$jumlah_pesanKursi =  $row['jumlah_pesanan'];
		}

		// waktu
		$batass = date('Y-m-d',strtotime("$batas"));
		$batass1 = date('Y-m-d',strtotime("$batas1"));

		$sekarang = date('Y-m-d');

		$jam_datang = date('H',strtotime("$batas"));
		$jam_selesai = date('H',strtotime("$batas1"));
		$jam_sekarang = date('H');


		$jumlah_pesananan = $_POST['jumlah'];
		$keterangan = $_POST['keterangan'];

		$status = 'requested';
		$id_user = $_SESSION['id'];
		$id_meja = $id_meja;
		
		$queri = "SELECT jumlah_kursi FROM t_meja WHERE id_meja='$id_meja'";
		$hasil = mysqli_query($conn,$queri)or die(mysqli_error($conn));
		$data = mysqli_fetch_assoc($hasil);

		$stok_lama = $data['jumlah_kursi'];
		// $harga_produk = $data['harga'];
		if($stok_lama == 0) {
			echo "<script>alert('Kursi Tidak Tersedia');</script>";
			header("Refresh:0 url=boking.php?bookingMeja=$id_meja");
		} else if(($jumlah_pesanKursi + $jumlah_pesananan) > $stok_lama) {
			echo "<script>alert('Kursi tidak cukup lagi!');</script>";
			header("Refresh:0 url=boking.php?bookingMeja=$id_meja");
		}
		else if($jumlah_pesananan > $stok_lama) {
			echo "<script>alert('Kursi tidak mencukupi!');</script>";
			header("Refresh:0 url=boking.php?bookingMeja=$id_meja");	
		}
		else if($jumlah_pesananan < 1) {
			echo "<script>alert('Tidak bisa memesan <=0 Kursi!');</script>";
			header("Refresh:0 url=boking.php?bookingMeja=$id_meja");			
		} 
		else if($batass < $sekarang) {
			echo "<script>alert('Tidak Bisa Memesan diwaktu kemarin!');</script>";
			header("Refresh:0 url=boking.php?bookingMeja=$id_meja");			
		}  
		else if($batass1 < $sekarang) {
			echo "<script>alert('Tidak valid!');</script>";
			header("Refresh:0 url=boking.php?bookingMeja=$id_meja");			
		} 
		else if($jam_datang < 10) {
			echo "<script>alert('Dallas Fried Chicken buka pada pukul 10:00 WIB');</script>";
			header("Refresh:0 url=boking.php?bookingMeja=$id_meja");			
		} 
		else if($jam_datang > 22) {
			echo "<script>alert('Dallas Fried Chicken sudah Tutup! ');</script>";
			header("Refresh:0 url=boking.php?bookingMeja=$id_meja");			
		}
		else if($jam_datang - $jam_sekarang > 1 || $jam_datang - $jam_sekarang < 0){
			echo "<script>alert('Jarak waktu Memesan dan datang Maksimal 1 JAM!');</script>";
			header("Refresh:0 url=boking.php?bookingMeja=$id_meja");			
		}
		else if($jam_selesai - $jam_datang > 3 || $jam_selesai - $jam_datang < 0){
			echo "<script>alert('Jarak waktu datang dan jam_selesai Maksimal 3 JAM!');</script>";
			header("Refresh:0 url=boking.php?bookingMeja=$id_meja");			
		}
		else if($batass != $sekarang || $batass1 != $sekarang){
			echo "<script>alert('Tidak bisa Memesan dilain Hari!');</script>";
			header("Refresh:0 url=boking.php?bookingMeja=$id_meja");			
		}
		else {
		$konfirmasi = mysqli_query($conn,"INSERT INTO t_bookmeja VALUES('','$id_user','$id_meja','$batas','$batas1','$jumlah_pesananan','$keterangan','$status')")or die(mysqli_error($conn));

		if($konfirmasi) {
			echo "<script>alert('request success');</script>";
			header("Refresh:0 url=boking.php?daftarRequest=$id_user");
		}
	}
}

	function terimaRequest($id_book) {
		global $conn;

		$status = 'Accepted';
		$id_booking = $id_book;

		

		$queri = "UPDATE t_bookmeja SET status = '$status' WHERE id_book = '$id_booking'";
		$hasil = mysqli_query($conn,$queri) or die (mysqli_error($conn));

		if($hasil) {
			echo "<script>alert('Berhasil meng-Accept');</script>";
			header("Refresh:0 url=transaksi.php?bokingMeja");	
		}
	}

	function tolakRequest($id_book) {
		global $conn;

		$status = 'Rejected';
		$id_booking = $id_book;

		$queri = "UPDATE t_bookmeja SET status = '$status' WHERE id_book = '$id_booking'";
		$hasil = mysqli_query($conn,$queri) or die (mysqli_error($conn));

		if($hasil) {
			echo "<script>alert('Berhasil meng-Rejected');</script>";
			header("Refresh:0 url=transaksi.php?bokingMeja");	
		}
	}

	function updateInformasiKursi($id_book) {
		global $conn;

		$queri = "SELECT * FROM t_bookmeja WHERE id_book = '$id_book'";
		$hasil = mysqli_query($conn,$queri) or die(mysqli_error($conn));
		$data = mysqli_fetch_array($hasil);

		$id_meja = $data['id_meja'];
		$jumlah_pesananan = $data['jumlah'];

		$queris = "SELECT * FROM t_meja WHERE id_meja = '$id_meja'";
		$result = mysqli_query($conn,$queris) or die(mysqli_error($conn));
		$datas = mysqli_fetch_array($result);

		$old_stok = $datas['jumlah_kursi'];

		$new_stok = $old_stok - $jumlah_pesananan;		
		updateInformasiKursis($id_meja,$new_stok);
	}

	function updateInformasiKursis($id_meja,$stok_terbaru) {
		global $conn;

		$queri = "UPDATE t_meja SET jumlah_kursi = '$stok_terbaru' WHERE id_meja = '$id_meja'";

		$hasil = mysqli_query($conn,$queri);

		if($hasil) {
			echo "<script>alert('Berhasil meng-UpdateInformasi Kursi');</script>";
		}
	}

	function ubahDeskripsiKursi($id) {
		global $conn;
		
		$jumlah = $_POST['jumlah_kursi'];
		$deskripsi = $_POST['deskripsi'];
		$id_meja = $id;

		$queris = "UPDATE t_meja SET jumlah_kursi = '$jumlah',Deskripsi = '$deskripsi' WHERE id_meja = '$id_meja'";	
		$hasil = mysqli_query($conn,$queris);
		
		if($hasil) {
			echo "<script>alert('Berhasil');</script>";
			header("Refresh:0 url=meja.php?semuaMeja");	
		}
		else {
			echo "<script>alert('Gagal');</script>";
			header("Refresh:0 url=meja.php?semuaMeja");	
		}
	}

	function deleteMeja($id_meja) {
		global $conn;

		$id_mejas = $id_meja;

		$queri = "DELETE FROM t_meja WHERE  id_meja = '$id_mejas'";
		$hasil = mysqli_query($conn,$queri);
		if($hasil) {
			echo "<script>alert('Berhasil');</script>";
			header("Refresh:0 url=meja.php?semuaMeja");	
		} else {
			echo "<script>alert('Gagal dihapus');</script>";
			header("Refresh:0 url=meja.php?semuaMeja");	
		}	
	}

	// function buatMejaBaru() {

	// 	global $conn;
	// 		$fileExistsFlag = 0; 
	// 		$fileName = $_FILES['picture']['name'];

	// 		$query = "SELECT gambar FROM t_meja WHERE gambar='$fileName'";	
	// 		$result = $conn->query($query) or die("Error : ".mysqli_error($link));

	// 		while($row = mysqli_fetch_array($result)) {
	// 		if($row['gambar'] == $fileName) {
	// 		$fileExistsFlag = 1;
	// 			}		
	// 		}

	// 		if($fileExistsFlag == 0) { 
	// 			$target = "assets/img/meja/";
	// 			$fileTarget = $target.$fileName;
	// 			$tempFileName = $_FILES["picture"]["tmp_name"];

	// 			$jumlah_kursi = $_POST['jumlah_kursi'];
	// 			$fileDescription = $_POST['deskripsi'];	

	// 			$result = move_uploaded_file($tempFileName,$fileTarget);

	// 			if($result) {
	// 				echo "<script>alert('Berhasil!')</script>";
	// 				header("Refresh:0 url=meja.php?semuaMeja");
	// 				$query = "INSERT INTO t_meja VALUES ('','$jumlah',$fileName','$fileDescription')";
	// 				$conn->query($query) or die("Error : ".mysqli_error($link));		
	// 			}
	// 			else {			
	// 			echo "Sorry !!! There was an error in uploading your file";
					
	// 		}	

	// 		}
	// 		else {			
	// 		echo "<script>alert('File telah ada di di folder,Coba lagi!')</script>";
	// 		header("Refresh:0 url=galeri.php?createNewImage");
	// 		}	
	// }

	function mejaBaru() {
		global $conn;

			$fileExistsFlag = 0; 
			$fileName = $_FILES['picture']['name'];

			$query = "SELECT gambar FROM t_meja WHERE gambar='$fileName'";	
			$result = $conn->query($query) or die("Error : ".mysqli_error($link));

			while($row = mysqli_fetch_array($result)) {
			if($row['gambar'] == $fileName) {
			$fileExistsFlag = 1;
				}		
			}

			if($fileExistsFlag == 0) { 
				$target = "assets/img/meja/";
				$fileTarget = $target.$fileName;
				$tempFileName = $_FILES["picture"]["tmp_name"];

				$jumlah_kursi = $_POST['jumlah_kursi'];
				$fileDescription = $_POST['deskripsi'];	

				$result = move_uploaded_file($tempFileName,$fileTarget);

				if($result) {
					echo "<script>alert('Berhasil!')</script>";
					header("Refresh:0 url=meja.php?semuaMeja");
					$query = "INSERT INTO t_meja VALUES ('','$jumlah_kursi','$fileName','$fileDescription')";
					$conn->query($query) or die("Error : ".mysqli_error($conn));		
				}
				else {			
				echo "Sorry !!! There was an error in uploading your file";
					
				}	
			}
			else {			
			echo "<script>alert('File telah ada di di folder,Coba lagi!')</script>";
			header("Refresh:0 url=meja.php?semuaMeja");
			}	
	}

	function deleteRequestMeja($id) {
		global $conn;

		$queri = "DELETE FROM t_bookmeja WHERE id_book = '$id'";
		$hasil = mysqli_query($conn,$queri);

		if($hasil) {
			echo "<script>alert('Berhasil Menghapus!')</script>";
			header("Refresh:0 url=transaksi.php?bokingMeja");
		}
	}

	function hapusSemuaRequest() {
		global $conn;

		$queri = "SELECT id_book FROM t_bookmeja";
		$hasil = mysqli_query($conn,$queri)or die(mysqli_error($conn));
		
		$data = mysqli_num_rows($hasil);
		if($data == 0) {
			echo "<script>alert('Data kosong,tidak bisa dihapus!')</script>";
			header("Refresh:0 url=transaksi.php?bokingMeja");	
		} else {
			$kueri = "DELETE FROM t_bookmeja WHERE status = 'Accepted' or status = 'Rejected'";
			$hasill = mysqli_query($conn,$kueri)or die(mysqli_error($conn));
			if($hasill) {
				echo "<script>alert('Berhasil Menghapus semua data!')</script>";
				header("Refresh:0 url=transaksi.php?bokingMeja");	
			} else {
				echo "<script>alert('Gagal Menghapus!')</script>";
				header("Refresh:0 url=transaksi.php?bokingMeja");	
			}
		}
	}

	function hapusRiwayatTransaksi($id_trans) {
		global $conn;
		$id_user = $_SESSION['id'];

		$id_transaksi = $id_trans;
		$queri = "DELETE FROM t_items WHERE id_transaksi = '$id_transaksi'";
		$execQ = mysqli_query($conn,$queri)or die(mysqli_error($conn));

		$queri2 = "DELETE FROM t_transaksi WHERE id_transaksi = '$id_transaksi'";
		$execQ2 = mysqli_query($conn,$queri2)or die(mysqli_error($conn));

		if($execQ2) {
			echo "<script>alert('Berhasil Menghapus semua data!')</script>";
			header("Refresh:0 url=keranjang.php?riwayatTransaksi=$id_user");	
		} else {
			echo "<script>alert('Gagal Menghapus semua data!')</script>";
			header("Refresh:0 url=keranjang.php?riwayatTransaksi=$id_user");	
		}
	}

	function hapusRiwayatTransaksi1($id) {
		global $conn;

		$id_trans = $id;
		$queri = "DELETE FROM t_items WHERE id_transaksi = '$id_trans' AND status = 'Rejected'
		OR id_transaksi = '$id_trans' AND status = 'Accepted'";
		$execQ = mysqli_query($conn,$queri);

		$queri2 = "DELETE FROM t_transaksi WHERE id_transaksi = '$id_trans' AND status = 'Rejected'
		OR id_transaksi = '$id_trans' AND status = 'Accepted'";
		$execQ2 = mysqli_query($conn,$queri2);

		if($execQ2) {
			echo "<script>alert('Berhasil Menghapus data!')</script>";
			header("Refresh:0 url=transaksi.php?semuaTransaksi");		
		} else {
			echo "<script>alert('Gagal Menghapus data!')</script>";
			header("Refresh:0 url=transaksi.php?semuaTransaksi");		
		}
	}

	function deleteKaryawan($id) {
		global $conn;

		$id_karyawan = $id;
		$kueri = "DELETE FROM t_karyawan WHERE id_karyawan = '$id_karyawan'";
		$execQ2 = mysqli_query($conn,$kueri)or die(mysqli_error($conn));

		if($execQ2 == TRUE) {
			echo "<script>alert('Berhasil Menghapus!')</script>";
			header("Refresh:0 url=kelola_karyawan.php");	
		} else {
			echo "<script>alert('Gagal Menghapus!')</script>";
			header("Refresh:0 url=kelola_karyawan.php");	
		}
	}

	 function updateKaryawan($id) {
	 	global $conn;

	 		$nama = $_POST['nama'];
			$alamat = $_POST['alamat'];
			$no_telp = $_POST['no_telp'];			
			$deskripsi = $_POST['deskripsi'];
			// $profile = $nama.'.jpg';
			
			$filename =$_FILES['picture']['name'];
			if(isset($filename)) {
				move_uploaded_file($_FILES['picture']['tmp_name'], 'assets/img/karyawan/'.$nama.'.jpg');
				$profile = $nama.'.jpg';
			}

			$queri = mysqli_query($conn,"UPDATE t_karyawan SET nama='$nama',gambar='$profile',alamat='$alamat',no_telp='$no_telp',deskripsi = '$deskripsi' WHERE id_karyawan = '$id'") or die(mysqli_error($conn));
			if($queri) {
				echo "<script>alert('berhasil diupdate!')</script>";
				header("Refresh:0 url=kelola_karyawan.php");	
			} else {
				echo "<script>alert('gagal!')</script>";
				header("Refresh:0 url=kelola_karyawan.php");	
			}	
	 }

	function tambah_karyawan11() {
			global $conn;

			$nama = $_POST['nama1'];
			$alamat = $_POST['alamat1'];
			$no_telp = $_POST['no_telp1'];			
			$deskripsi = $_POST['deskripsi1'];
			// $profile = $nama.'.jpg';
			
			$filename =$_FILES['picture']['name'];
			if(isset($filename)) {
				move_uploaded_file($_FILES['picture']['tmp_name'], 'assets/img/karyawan/'.$nama.'.jpg');
				$profile = $nama.'.jpg';
			}

			$queri = mysqli_query($conn,"INSERT INTO t_karyawan VALUES ('','$nama','$profile','$alamat','$no_telp','$deskripsi')") or die(mysqli_query($conn));
			if($queri) {
				echo "<script>alert('berhasil menambahkan!')</script>";
				header("Refresh:0 url=kelola_karyawan.php");	
			} else {
				echo "<script>alert('gagal!')</script>";
				header("Refresh:0 url=kelola_karyawan.php");	
			}	
	}	

	function deletePemasukan1($id) {
		global $conn;

		$id_transaksi = $id;

		$kueri = "DELETE FROM t_items WHERE id_transaksi = '$id_transaksi'";
		$exe = mysqli_query($conn,$kueri) or die(mysqli_error($conn));

		$kueri1 = "DELETE FROM t_transaksi WHERE id_transaksi = '$id_transaksi'";
		$execQ = mysqli_query($conn,$kueri1);
		if($execQ == TRUE) {
			echo "<script>alert('Berhasil Menghapus!')</script>";
			header("Refresh:0 url=pemasukan.php");	
		} else {
			echo "<script>alert('Gagal Menghapus!')</script>";
			header("Refresh:0 url=pemasukan.php");	
		}
	}

	function hapusAllPemasukan1() {
		global $conn;

		$kueri = "DELETE FROM t_items WHERE status = 'Accepted'";
		$execQ = mysqli_query($conn,$kueri);

		$kueri2 = "DELETE FROM t_transaksi WHERE status = 'Accepted'";
		$execQ2 = mysqli_query($conn,$kueri2);

		if($execQ2 ==TRUE ) {
			echo "<script>alert('Berhasil Menghapus!')</script>";
			header("Refresh:0 url=pemasukan.php");	
		} else {
			echo "<script>alert('Gagal Menghapus!')</script>";
			header("Refresh:0 url=pemasukan.php");	
		}
	}
?> 	
