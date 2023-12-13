<?php
session_start();
session_destroy();
?>
<script>
    alert("Sign Out.");
    location.replace('index.php');
</script>
