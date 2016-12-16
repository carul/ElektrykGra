<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<?php
unset($_SESSION['user_name']);
header("Location:index.php?msg=logout");
exit();
?>
</head>
<body>
</body>
</html>