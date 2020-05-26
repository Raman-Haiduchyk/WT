<?php

function setConnection():mysqli
{
    $host = 'localhost'; // адрес сервера 
    $database = 'counting_ref'; // имя базы данных
    $user = 'root'; // имя пользователя
    $password = ''; // пароль
    $mysqli = new mysqli($host, $user, $password, $database);
    if ($mysqli->connect_error){
        die("Не удалось подключить базу данных: " . $mysqli->connect_errno);
    }
    $mysqli->query("SET CHARSET 'UTF8'");
    $mysqli->query("SET NAMES 'UTF8'");
    return $mysqli;
}

function getValue($id)
{
    $mysqli = setConnection();
    $query ="SELECT * FROM ref_count WHERE reference = '$id' ";
    $response = $mysqli->query($query);
    if (($response = $mysqli->query($query)) && ($response->num_rows != 0)){
        $row = $response->fetch_array(MYSQLI_NUM);
        //$result = $row[1];
        echo $row[1];
        $mysqli->close();
        return true;
    }else{
        echo 0;
        $mysqli->close();
        return false;
    }
}

if (isset($_POST['id']) && is_numeric($_POST['id'])){
    $id = $_POST['id'];
    $mysqli = setConnection();
    $query ="SELECT * FROM ref_count WHERE reference = '$id' ";
    if (($response = $mysqli->query($query)) && ($response->num_rows != 0)){
        $row = $response->fetch_array(MYSQLI_NUM);
        echo $row[1] + 1;
        $query = "UPDATE ref_count SET count = count + '1' WHERE reference = '$id'";
        if (!($mysqli->query($query))) die("shit");
    }else{
        $query = "INSERT INTO ref_count VALUES ('$id', '1')";
        echo 1;
        if (!($mysqli->query($query))) die("happens");
    }    
    $mysqli->close();
}
?>