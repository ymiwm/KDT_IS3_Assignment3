<?php
if(!session_id()){
    session_start();
}

if (isset($_SESSION['id'])){
    ?>
    <h2>Hello, <?php echo $_SESSION['name']?>!</h2>
    <?php
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <style>
            table {
                border-top: 1px solid #444444;
                border-collapse: collapse;
            }

            tr {
                border-bottom: 1px solid #444444;
                padding: 10px;
            }

            td {
                border-bottom: 1px solid #efefef;
                padding: 10px;
            }

            table .even {
                background: #efefef;
            }

            .text {
                text-align: center;
                padding-top: 20px;
                color: #000000
            }

            .text:hover {
                text-decoration: underline;
            }

            a:link {
                color: #57A0EE;
                text-decoration: none;
            }

            a:hover {
                text-decoration: underline;
            }
        </style>
    </head>
    
    <body>
        <script>alert(document.cookie)</script>
        <?php
        require_once("inc/db.php");
        require_once("inc/header.php");
        $query = "select * from board order by number desc";
        $result = db_select($query);
        $total = count($result);
        ?>
        <p style="font-size:25px; text-align:center"><b>Board</b></p>
        <table align=center>
            <thead align="center">
                <tr>
                    <td width="50" align="center">Number</td>
                    <td width="500" align="center">Title</td>
                    <td width="100" align="center">Author</td>
                    <td width="200" align="center">Date</td>
                    <td width="50" align="center">Hit</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $index = 0;
                while ($total) {
                    if ($total % 2 == 0) {
                        ?>
                        <tr class="even">
                        <?php
                    }
                    else {
                        ?>
                        <tr>
                        <?php
                     }
                    ?>
                        <td width="50" align="center"><?php echo $total ?></td>
                        <td width="500" align="center">
                            <a href="read.php?number=<?php echo $result[$index]['number'] ?>">
                                <?php echo $result[$index]['title'] ?>
                        </td>
                        <td width="100" align="center"><?php echo $result[$index]['id'] ?></td>
                        <td width="200" align="center"><?php echo $result[$index]['date'] ?></td>
                        <td width="50" align="center"><?php echo $result[$index]['hit'] ?></td>
                    </tr>
                    <?php
                    $total--;
                    $index++;
                }
                ?>
            </tbody>
        </table>
        <div class=text>
            <font style="cursor: hand" onClick="location.href='write.php'">Create Post</font>
        </div>
    </body>
</html>
