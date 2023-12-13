<?php
require_once("inc/db.php");
require_once("inc/header.php");

$number = $_GET['number'];

$query = "select id from board where number = ?";
$result = db_select($query, array($number));

$id = $result[0]['id'];

$URL = "index.php";
?>

<?php
if (isset($_SESSION['id']) and $_SESSION['id'] == $id) {
    $query = "delete from board where number = ?";
    $result = db_update_delete($query, array($number));
    if ($result) {
    ?>
    <script>
        alert("Post is deleted.");
    </script>
    <?php
    }
    else {
    ?>
    <script>
    	alert("Delete error occured.");
    </script>
    <?php
    }
}
else {
    ?>
    <script>
        alert("Access denied.");
    </script>
<?php
}
?>
<script>
location.replace("<?php echo $URL ?>");
</script>
