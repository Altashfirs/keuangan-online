<?php  

if (isset($_SESSION['username']) && isset($_SESSION['id'])) {
    
    $id_user = $_SESSION['id'];
    $sql = "SELECT * FROM hutang WHERE id_peminjam = $_GET[id]";
    $res = mysqli_query($conn, $sql);
}else{
	header("Location: index.php");
} 