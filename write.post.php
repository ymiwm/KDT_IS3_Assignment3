<?php
require_once("inc/db.php");

$id = $_POST['id'];
$title = $_POST['title'];
$content = $_POST['content'];

if ($title == '') {
    ?>
    <script>
        alert("Title must be at least 1 character.");
        location.replace("write.php");
    </script>
    <?php
    exit();
}

$query = "ALTER TABLE board auto_increment = 1";

$result = db_update_delete($query);

$query = "INSERT INTO board (number, title, content, id, date, hit) 
        values (null, :title, :content, :id, NOW(), 0)";

$result = db_insert($query,
    array(
    'title' => $title,
    'content' => $content,
    'id' => $id,
    )
);

if ($result) {
    ?>
	<script>
		alert("Post created successfully!");
	</script>
    <?php
}
else {
    ?>
	<script>
		alert("Failed to create post.");
	</script>
    <?php
}
?>
<script>
    location.replace('index.php');
</script>
