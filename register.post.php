<?php
require_once("inc/db.php");

$signin_id = isset($_POST['signin_id']) ? $_POST['signin_id'] : null;
$signin_pw = isset($_POST['signin_pw']) ? $_POST['signin_pw'] : null;
$signin_name = isset($_POST['signin_name']) ? $_POST['signin_name'] : null;

if ($signin_id == null || $signin_pw == null || $signin_name == null){    
    ?>
    <script>
        alert("Not enough information. Please try again.");
        location.replace('register.php');
    </script>
    <?php
    exit();
}

$member_count = db_select("select count(id) cnt from member where id = ?" , array($signin_id));

if ($member_count && $member_count[0]['cnt'] == 1){
    ?>
    <script>
        alert("Account already exists. Please try again.");
        location.replace('register.php');
    </script>
    <?php
    exit();
}

$bcrypt_pw = password_hash($signin_pw, PASSWORD_BCRYPT);

db_insert("insert into member (id, pw, name, date, permit) values (:id, :pw, :name, NOW(), 0)",
    array(
        'id' => $signin_id,
        'pw' => $bcrypt_pw,
        'name' => $signin_name
    )
);

echo "<script>
    alert('Account created successfully. Go to login...');
    location.href='/login.php'
	</script>";
?>
