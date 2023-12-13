<?php
require_once("inc/db.php");
require_once("inc/header.php");

$title = $_POST['title'];
$content = $_POST['content'];
$number = $_POST['number'];

if ($title == '') {
    ?>
    <script>
        alert("Title must be at least 1 character.");
        location.replace("modify.php?number=<?= $number ?>&id=<?= $id ?>");
    </script>
    <?php
    exit();
}

$query = "update board set title=:title, content=:content, date=NOW(), hit=0 where number=:number";

$result = db_update_delete($query,
	array(
	'title' => $title,
	'content' => $content,
	'number' => $number
	)
);
if ($result) {
    ?>
    <script>
        alert("Modify complete.");
    </script>
    <?php
}
else {
    ?>
    <script>
        alert("Something gone wrong. Please try again.");
    </script>
    <?php
}
?>
<script>
    location.replace("read.php?number=<?= $number ?>");
</script>
