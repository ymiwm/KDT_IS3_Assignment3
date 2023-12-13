<?php
function db_get_pdo()
{
    $host = 'localhost';
    $port = '3306'; // 3306(Internal) / #(External Port Number - Goorm IDE)
    $dbname = 'ASSIGNMENT2';
    $charset = 'utf8';
    $username = 'root';
    $db_pw = "";
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $username, $db_pw);
    return $pdo;
}

function db_select($query, $param=array()){
    $pdo = db_get_pdo();
    try {
        $st = $pdo->prepare($query);
        $st->execute($param);
        $result =$st->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;
        return $result;
    }
    catch (PDOException $ex) {
        return false;
    }
    finally {
        $pdo = null;
    }
}

function db_insert($query, $param = array())
{
    $pdo = db_get_pdo();
    try {
        $st = $pdo->prepare($query);
        $result = $st->execute($param);
        $last_id = $pdo->lastInsertId();
        $pdo = null;
        if ($result) {
            return $last_id;
        }
        else {
            return false;
        }
    }
    catch (PDOException $ex) {
        return false;
    }
    finally {
        $pdo = null;
    }
}

function db_update_delete($query, $param = array())
{
    $pdo = db_get_pdo();
    try {
        $st = $pdo->prepare($query);
        $result = $st->execute($param);
        $pdo = null;
        return $result;
    }
    catch (PDOException $ex) {
        return false;
    }
    finally {
        $pdo = null;
    }
}
?>
