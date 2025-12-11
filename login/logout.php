<?php
session_start();
session_unset(); // hapus semua variabel session
session_destroy(); // hancurkan session

echo "<script>
alert('Anda telah logout!');
window.location='login.php';
</script>";
?>
