<?php
session_start();
echo "<p>你的Session ID : ".session_id()."<p/>";
echo "session_save_path : ".session_save_path();
?>
<li><?php echo $_SESSION['name']; ?></li>