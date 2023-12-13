<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <style>
            table.table2 {
                border-collapse: separate;
                border-spacing: 1px;
                text-align: left;
                line-height: 1.5;
                border-top: 1px solid #ccc;
                margin: 20px 10px;
            }

            table.table2 tr {
                width: 50px;
                padding: 10px;
                font-weight: bold;
                vertical-align: top;
                border-bottom: 1px solid #ccc;
            }

            table.table2 td {
                width: 100px;
                padding: 10px;
                vertical-align: top;
                border-bottom: 1px solid #ccc;
            }
        </style>
    </head>

    <body>
        <?php
        require_once("inc/db.php");
        require_once("inc/header.php");
        
        $number = $_GET['number'];
        
        $query = "select title, content, date, id from board where number = ?";
        
        $result = db_select($query, array($number));

        $title = $result[0]['title'];
        $content = $result[0]['content'];
        $id = $result[0]['id'];

        $URL = "index.php";

        if (isset($_SESSION['id']) and $_SESSION['id'] == $id) {
            ?>
            <form method="POST" action="modify.post.php">
                <table style="padding-top:50px" align=center width=auto border=0 cellpadding=2>
                    <tr>
                        <td style="height:40; float:center; background-color:#3C3C3C">
                            <p style="font-size:25px; text-align:center; color:white; margin-top:15px; margin-bottom:15px"><b>Modify Post</b></p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor=white>
                            <table class="table2">
                                <tr>
                                    <td>Author</td>
                                    <td><input type="hidden" name="id" value="<?= $_SESSION['id'] ?>"><?= $_SESSION['id'] ?></td>
                                </tr>

                                <tr>
                                    <td>Title</td>
                                    <td><input type=text name=title size=87 value="<?= $title ?>"></td>
                                </tr>

                                <tr>
                                    <td>Content</td>
                                    <td><textarea name=content cols=75 rows=15><?= $content ?></textarea></td>
                                </tr>
                            </table>
                            <center>
                                <input type="hidden" name="number" value="<?= $number ?>">
                                <input style="height:26px; width:64px; font-size:16px;" type="submit" value="Submit">
                                <input style="height:26px; width:64px; font-size:16px;" type="button" onclick="location.href='read.php?number=<?php echo $number ?>'" value="Back">
                            </center>
                        </td>
                    </tr>
                </table>
            </form>
            <?php
        }
        else {
            ?>
            <script>
                alert("Access denied.");
                location.replace("<?php echo $URL ?>");
            </script>
            <?php
        }
        ?>
    </body>
</html>
