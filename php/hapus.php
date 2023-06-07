<?php
session_start();
include "../db_conn.php";

if (isset($_SESSION['username']) && isset($_SESSION['id']) && $_SESSION['role'] == 'admin') {
	$data = $conn->query("DELETE FROM hutang WHERE id_hutang = $_GET[id]");
	if ($data) {
		echo "
		<script>
		alert('data behasil dihapus');
		document.location.href= '../home.php'
		</script>
		";
	} else {
		echo "
		<script>
		alert('data kelas digunakan ditabel Siswa');
		alert('data gagal dihapus');
		document.location.href = '../home.php';
		</script>
		";
	}
} else {
	echo "
	<script>
	alert('anda tidak punya akses dihalaman ini ');
	document.location.href = '../home.php';
	</script>
	";
}
