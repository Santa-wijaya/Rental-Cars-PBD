<?php
// connect to database
$conn = mysqli_connect("localhost", "root", "", "rental");

// read data
function read($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$records = [];
	while ($tuples = mysqli_fetch_assoc($result)) {
		$records[] = $tuples;
	}
	return $records;
}

// Insert data to database
function execute_query($query) {
	global $conn;
	mysqli_query($conn, $query);
	if (mysqli_affected_rows($conn) > 0) {
		return true;
	}
	return false;
}

function execute_multi_query($query) {
	global $conn;
	mysqli_multi_query($conn, $query);
	if (mysqli_affected_rows($conn) > 0) {
		return true;
	}
	return false;
}

function check_file_type($file_type) {
	$accepted_values = ["image/jpeg", "image/jpg", "image/png"];
	if (in_array($file_type, $accepted_values)) {
		return true;
	}
	return false;
}

function insert_driver($record, $img) {
	global $conn;
	$nama_driver = htmlspecialchars($record["nama-driver"]);
	$jenis_kelamin_driver = htmlspecialchars($record["jenisKelamin"]);
	$harga = htmlspecialchars($record["harga"]);
	$nama_foto = $img['foto-driver']['name'];
	$tipe_file = $img['foto-driver']['type'];
	$file_path_sementara = $img['foto-driver']['tmp_name'];
	$dummy = explode("/", $tipe_file);
	$ekstensi = "." . $dummy[1];
	$nama_foto_simpan = uniqid() . $ekstensi;
	if(!check_file_type($tipe_file)) {
		return false;
	} elseif ($img['foto-driver']['size'] > 500000) {
		return false;
	}
	move_uploaded_file($file_path_sementara, 'Images/Driver/' . $nama_foto_simpan);
	// $query = "INSERT INTO driver VALUES('', '$nama_driver', '$jenis_kelamin_driver', $harga, '$nama_foto_simpan')";
	$query = "CALL input_data_driver('$nama_driver', '$jenis_kelamin_driver', $harga, '$nama_foto_simpan')";
	if(execute_query($query)){
		return true;
	}
	return false;
}

function insert_unit($record) {
	$id_model = htmlspecialchars($record["id-model-kendaraan"]);
	$plat_nomor = htmlspecialchars($record["plat-nomor-kendaraan"]);
	// $query = "INSERT INTO unit_kendaraan VALUES('', $id_model, '$plat_nomor')";
	$query = "CALL input_unit_kendaraan($id_model, '$plat_nomor')";
	if(execute_query($query)){
		return true;
	}
	return false;
}

function update_unit($record) {
	$ID_kendaraan = htmlspecialchars($record["id-kendaraan-update"]);
	$plat_nomor = htmlspecialchars($record["plat-nomor-update"]);
	$query = "UPDATE unit_kendaraan SET plat_nomor = '$plat_nomor' WHERE ID_kendaraan = $ID_kendaraan";
	if(execute_query($query)){
		return true;
	}
	return false; 
}

function delete_unit($record){
	$ID_kendaraan = htmlspecialchars($record["id-kendaraan-hapus"]);
	$query = "DELETE FROM unit_kendaraan WHERE ID_kendaraan = $ID_kendaraan";
	if(execute_query($query)){
		return true;
	}
	return false; 
}



function insert_vehicle($record, $img) {
	global $conn;
	$model_kendaraan = htmlspecialchars($record["model-kendaraan"]);
	$manufaktur = htmlspecialchars($record["manufaktur-kendaraan"]);
	$harga = htmlspecialchars($record["harga"]);
	$nama_foto = $img['foto-kendaraan']['name'];
	$tipe_file = $img['foto-kendaraan']['type'];
	$file_path_sementara = $img['foto-kendaraan']['tmp_name'];
	$dummy = explode("/", $tipe_file);
	$ekstensi = "." . $dummy[1];
	$nama_foto_simpan = uniqid() . $ekstensi;
	if(!check_file_type($tipe_file)) {
		return false;
	} elseif ($img['foto-kendaraan']['size'] > 500000) {
		return false;
	}
	move_uploaded_file($file_path_sementara, 'Images/TipeMobil/' . $nama_foto_simpan);
	$query = "INSERT INTO tipe_kendaraan VALUES('', '$model_kendaraan', '$manufaktur', $harga, '$nama_foto_simpan')";
	$query = "CALL input_data_model_kendaraan('$model_kendaraan', '$manufaktur', $harga, '$nama_foto_simpan')";
	if(execute_query($query)){
		return true;
	}
	return false;
}

function update_driver($record, $img) {
	global $conn;
	$id = htmlspecialchars($record["id-driver"]);
	$nama_driver = htmlspecialchars($record["nama-driver-update"]);
	$jenis_kelamin_driver = htmlspecialchars($record["jenisKelamin-update"]);
	$harga = htmlspecialchars($record["harga-driver-update"]);
	if($img["foto-driver-update"]["error"] == 4) {
		// $query = "UPDATE driver SET nama = '$nama_driver', jenis_kelamin = '$jenis_kelamin_driver', tarif = $harga WHERE ID_driver = $id;";
		$query = "CALL update_data_driver_tanpa_foto($id, '$nama_driver', '$jenis_kelamin_driver', $harga)";
	} else {
		$nama_foto = $img['foto-driver-update']['name'];
		$tipe_file = $img['foto-driver-update']['type'];
		$file_path_sementara = $img['foto-driver-update']['tmp_name'];
		$dummy = explode("/", $tipe_file);
		$ekstensi = "." . $dummy[1];
		$nama_foto_simpan = uniqid() . $ekstensi;
		if(!check_file_type($tipe_file)) {
			return false;
		} elseif ($img['foto-driver-update']['size'] > 500000) {
			return false;
		}
		move_uploaded_file($file_path_sementara, 'Images/Driver/' . $nama_foto_simpan);
		$query = "CALL update_data_driver($id, '$nama_driver', '$jenis_kelamin_driver', $harga, '$nama_foto_simpan')";
		// $query = "UPDATE driver SET nama = '$nama_driver', jenis_kelamin = '$jenis_kelamin_driver', tarif = $harga, nama_foto = '$nama_foto_simpan' WHERE ID_driver = $id;";
	}
	if(execute_query($query)){
		return true;
	}
	return false;
}



function update_vehicle($record, $img) {
	global $conn;
	$id = htmlspecialchars($record["id-model"]);
	$model = htmlspecialchars($record["nama-model-update"]);
	$manufaktur = htmlspecialchars($record["nama-manufaktur-update"]);
	$harga = htmlspecialchars($record["harga-model-update"]);
	if($img["foto-model-update"]["error"] == 4) {
		$query = "UPDATE tipe_kendaraan SET model = '$model', manufaktur = '$manufaktur', harga_sewa = $harga WHERE ID_model = $id;";
	} else {
		$nama_foto = $img['foto-model-update']['name'];
		$tipe_file = $img['foto-model-update']['type'];
		$file_path_sementara = $img['foto-model-update']['tmp_name'];
		$dummy = explode("/", $tipe_file);
		$ekstensi = "." . $dummy[1];
		$nama_foto_simpan = uniqid() . $ekstensi;
		if(!check_file_type($tipe_file)) {
			return false;
		} elseif ($img['foto-model-update']['size'] > 500000) {
			return false;
		}
		move_uploaded_file($file_path_sementara, 'Images/TipeMobil/' . $nama_foto_simpan);
		$query = "UPDATE tipe_kendaraan SET model = '$model', manufaktur = '$manufaktur', harga_sewa = $harga, gambar = '$nama_foto_simpan' WHERE ID_model = $id;";
	}
	if(execute_query($query)){
		return true;
	}
	return false;
}

function delete_driver($driver_p_k) {
	global $conn;
	$query = "DELETE FROM driver WHERE ID_driver = $driver_p_k;";
	if(execute_query($query)){
		return true;
	}
	return false;
}



function delete_vehicle($model_p_k) {
	global $conn;
	$res = read("SELECT COUNT(*) AS jumlah_unit FROM unit_kendaraan WHERE ID_model = $model_p_k;");
	if($res[0]["jumlah_unit"] == 0) {
		$query = "DELETE FROM tipe_kendaraan WHERE ID_model = $model_p_k;";
		if(execute_query($query)){
			return true;
		}
	} else {
		$query = "DELETE FROM unit_kendaraan WHERE ID_model = $model_p_k; DELETE FROM tipe_kendaraan WHERE ID_model = $model_p_k;";
		if(execute_query($query)){
			if(execute_multi_query($query)){
				return true;
			}
		}
	}
	return false;

}

function check_username($uname, $tabel) {
	global $conn;
	mysqli_query($conn, "SELECT * FROM $tabel WHERE username = '$uname';");
	return mysqli_affected_rows($conn);
}

function check_NIK($nik) {
	global $conn;
	mysqli_query($conn, "SELECT * FROM pelanggan WHERE NIK = '$nik';");
	return mysqli_affected_rows($conn);
}

// register user
function register_new_user($record) {
	global $conn;
	$nik = $record["NIK"];
	$uname = stripslashes($record["username"]);
	$pwd = mysqli_real_escape_string($conn, $record["password_akun_login"]);
	$pwd_konf = mysqli_real_escape_string($conn, $record["password_akun_konfirmasi"]);
	if ($pwd !== $pwd_konf) {
		return 1;
	} elseif (check_NIK($nik) > 0) {
		return 2;
	} elseif ((check_username($uname, "akun_pelanggan")) > 0 || (check_username($uname, "admin") > 0)) {
		return 3;
	} else {
  		$nama = $record["nama"];
  		$alamat = $record["alamat"];
  		$kabupaten = $record["asal_kabupaten"];
  		$jenis_kelamin = $record["jenisKelamin"];
  		$no_telp = $record["nomor_telepon"];
  		$hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);
  		$query_pelanggan = "INSERT INTO pelanggan VALUES('', '$nik', '$nama', '$alamat', '$kabupaten', '$jenis_kelamin', '$no_telp');";
  		$query_akun = "INSERT INTO akun_pelanggan VALUES('', '$uname', '$hashed_pwd', 'not verified', LAST_INSERT_ID());";
		
  		if (execute_query($query_pelanggan) && execute_query($query_akun)) {
  			return 4;
  		}
	}
}

function user_validation($ID_akun, $status) {
	global $conn;
	$query = "UPDATE akun_pelanggan SET status_akun = '$status' WHERE ID_akun = $ID_akun;";
	return execute_query($query);
}

function payment_validation($id_peminjaman, $status) {
	global $conn;
	$query = "UPDATE peminjaman SET status_peminjaman = '$status' WHERE ID_peminjaman = $id_peminjaman;";
	return execute_query($query);
}

function login($record) {
	global $conn;
	$uname = stripslashes($record["username_login"]);
	$pwd = mysqli_real_escape_string($conn, $record["password_akun_login"]);
	$query = "SELECT * FROM akun WHERE username = \"$uname\";";
	$res_set = mysqli_query($conn, $query);
	if(mysqli_num_rows($res_set) === 1){
		$tuple = mysqli_fetch_assoc($res_set);
		if (password_verify($pwd, $tuple["password_akun"])) {
			if ($tuple['jenis_akun'] === 'pelanggan') {
				$_SESSION["login_pelanggan"] = true;
				$_SESSION["username"] = $uname;
				$_SESSION["id_akun"] = $tuple["ID_akun"];
				$_SESSION["status_akun"] = $tuple["status_akun"];
				header("Location: beranda_user.php");
				exit;
			} else {
				$_SESSION["login_admin"] = true;
				$_SESSION["username"] = $uname;
				header("Location: beranda_admin.php");
				exit;
			}
		}
	}
	
	$wrong_pass = true;
	return $wrong_pass;
}

function request_peminjaman($record, $id_model) {
	$tanggal_peminjaman = $record["konfirmasi-tgl-peminjaman"];
	$tanggal_pengembalian = $record["konfirmasi-tgl-pengembalian"];
	$id_akun = $_SESSION["id_akun"];
	$butuh_driver = $record["konfirmasi-driver"];
	// $jumlah_helper = $record["konfirmasi-helper"];
	if($_SESSION["status_akun"] == "valid") {
		if($butuh_driver === "Ya") {
			$query = "INSERT INTO peminjaman (ID_model_kendaraan, ID_akun, tanggal_peminjaman, tanggal_pengembalian, opsi_driver, status_peminjaman) VALUES($id_model, $id_akun, '$tanggal_peminjaman', '$tanggal_pengembalian', 1, 'not accepted yet')";
		} else {
			$query = "INSERT INTO peminjaman (ID_model_kendaraan, ID_akun, tanggal_peminjaman, tanggal_pengembalian, status_peminjaman) VALUES($id_model, $id_akun, '$tanggal_peminjaman', '$tanggal_pengembalian', 'not accepted yet')";
		}
	} else {
		return 0;
	}
	if (execute_query($query)) {
		return 1;
	} else {
		return 2;
	}
}

function accept_peminjaman($record) {
	// assign ke variabel
	$id_peminjaman = $record["ID-peminjaman-accept"];
	$status_driver = $record["butuh-driver-accept"];
	$id_kendaraan = $record["unit-kendaraan"];

	if ($id_kendaraan == -1) {
		return 0;
	}

	// check apakah butuh driver atau tidak
	if ($status_driver == 0) {
		$query = "UPDATE peminjaman SET ID_kendaraan = $id_kendaraan, status_peminjaman = 'accepted' WHERE ID_peminjaman = $id_peminjaman;";
	} else {
		$id_driver = $record["driver-selection"];
		if ($id_driver == -1) {
			return 0;
		}
		$query = "UPDATE peminjaman SET ID_kendaraan = $id_kendaraan, ID_driver = $id_driver, status_peminjaman = 'accepted' WHERE ID_peminjaman = $id_peminjaman;";
	}

	$query2 = "";
	
	


	$concatted_query = $query . $query2;
	if (execute_multi_query($concatted_query)) {
		return 1;
	} else {
		return 2;
	}
}

function reject_peminjaman($record){
	$id_peminjaman = $record["ID-peminjaman-reject"];
	$keterangan = $record["keterangan-reject-peminjaman"];
	$query = "UPDATE peminjaman SET status_peminjaman = 'rejected', keterangan = '$keterangan' WHERE ID_peminjaman = $id_peminjaman;";
	if (execute_query($query)){
		return true;
	}
	return false;
}

function uploadBuktiPembayaran($record, $img){
	$id_peminjaman = $record["ID-peminjaman-payment"];
	$nama_foto = $img['bukti-pembayaran']['name'];
	$tipe_file = $img['bukti-pembayaran']['type'];
	$file_path_sementara = $img['bukti-pembayaran']['tmp_name'];
	$dummy = explode("/", $tipe_file);
	$ekstensi = "." . $dummy[1];
	$nama_foto_simpan = uniqid() . $ekstensi;
	if(!check_file_type($tipe_file)) {
		return false;
	} elseif ($img['bukti-pembayaran']['size'] > 2000000) {
		return false;
	}
	move_uploaded_file($file_path_sementara, 'Images/BuktiPembayaran/' . $nama_foto_simpan);
	$query = "UPDATE peminjaman SET gambar_bukti_pembayaran = '$nama_foto_simpan' WHERE ID_peminjaman = $id_peminjaman;";
	if(execute_query($query)) {
		return true;
	} else{
		return false;
	}
}

function update_biodata($record, $id_pelanggan, $nik_pelanggan, $id_akun) {
	$NIK = $record["update-NIK"];
	$nama = $record["update-nama"];
	$alamat = $record["update-alamat"];
	$kabupaten = $record["update-kabupaten"];
	$nomor_telepon = $record["update-nomor-telepon"];
	$jenis_kelamin = $record["update-jenis-kelamin"];
	if($nik_pelanggan!=$NIK) {
		if(check_NIK($NIK) > 0) {
			return false;
		}
		$query = "UPDATE pelanggan SET NIK = '$NIK', nama = '$nama', alamat = '$alamat', kabupaten = '$kabupaten', jenis_kelamin = '$jenis_kelamin', nomor_telepon = '$nomor_telepon' WHERE ID_pelanggan = $id_pelanggan; UPDATE akun_pelanggan SET status_akun = 'not verified' WHERE ID_akun = $id_akun;";
	} else {
		$query = "UPDATE pelanggan SET nama = '$nama', alamat = '$alamat', kabupaten = '$kabupaten', jenis_kelamin = '$jenis_kelamin', nomor_telepon = '$nomor_telepon' WHERE ID_pelanggan = $id_pelanggan; UPDATE akun_pelanggan SET status_akun = 'not verified' WHERE ID_akun = $id_akun;";
	}
	$_SESSION["status_akun"] = "not verified";
	if(execute_multi_query($query)) {
		return true;
	} else{
		return false;
	}
}

function update_username($record, $password, $id_akun) {
	global $conn;
	$username_baru = stripslashes($record["update-username"]);
	$pwd_input = mysqli_real_escape_string($conn, $record["update-password-konfirmasi"]);
	if (password_verify($pwd_input, $password)) {
		if(check_username($username_baru, "akun_pelanggan") > 0){
			return 1;
		}
		$query = "UPDATE akun_pelanggan SET username = '$username_baru' WHERE ID_akun = $id_akun;";
		if(execute_query($query)) {
			return 0;
		} else{
			return 3;
		}
	} else {
		return 2;
	}
}


function update_password($record, $password, $id_akun){
	global $conn;
	$pwd_sekarang = mysqli_real_escape_string($conn, $record["update-password-sekarang"]);
	$pwd_baru = mysqli_real_escape_string($conn, $record["update-password-baru"]);
	$pwd_konfirmasi_baru = mysqli_real_escape_string($conn, $record["update-konfirmasi-password-baru"]);
	// check password lama sesuai atau tidak
	if (password_verify($pwd_sekarang, $password)) {
		// check kesamaan password baru dan password konfirmasi
		if ($pwd_baru == $pwd_konfirmasi_baru) {
			$hashed_pwd = password_hash($pwd_baru, PASSWORD_DEFAULT);
			$query = "UPDATE akun_pelanggan SET password_pelanggan = '$hashed_pwd' WHERE ID_akun = $id_akun;";
			if(execute_query($query)) {
				return 4;
			} else{
				return 3;
			}
		} else {
			return 2;
		}
	} else {
		return 1;
	}
	
}

function pengembalian($id_peminjaman, $denda_per_hari, $tgl_seharusnya) {
	date_default_timezone_set('Asia/Makassar');
	$tanggal_saat_ini = date("Y-m-d");
	$query = "INSERT INTO pengembalian VALUES('', $id_peminjaman, '$tgl_seharusnya', '$tanggal_saat_ini', $denda_per_hari);";
	if(execute_query($query)) {
		return true;
	} else{
		return false;
	}
}

function blokir_pelanggan($id_akun) {
	$query = "UPDATE akun_pelanggan SET status_akun = 'not valid' WHERE ID_akun = $id_akun;";
	if(execute_query($query)) {
		return true;
	} else{
		return false;
	}
}

?>