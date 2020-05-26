<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
</head>
<body>

<form method="POST">
        <br><br>
	    Login: <input type="text" name="login" size=5%/ value="<?php if (isset($_POST["login"])) Echo $_POST['login']; ?>"><br><br>
	    Password: <input type="text" name="password" size=5%/ value="<?php if (isset($_POST["password"])) Echo $_POST['password']; ?>"><br><br>
	    Confirm password: <input type="text" name="password_conf" size=5%/ value="<?php if (isset($_POST["password_conf"])) Echo $_POST['password_conf']; ?>"><br><br>
	    <input type="submit" value="Вывести">
</form>
<br>
<br>

<?php


require_once 'connection.php';
$mysqli = new mysqli($host, $user, $password, $database);
if ($mysqli->connect_error){
    die("Не удалось подключить базу данных: " . $mysqli->connect_errno);
}
$mysqli->query("SET CHARSET 'UTF8'");
$mysqli->query("SET NAMES 'UTF8'");
if(isset($_POST['new_password']) && $_POST['new_password'] != ""){
    $new = sha1($_POST['new_password']);
    $query ="UPDATE users SET password='$new' WHERE login='".$_POST['login']."'";
    $mysqli->query($query);
}

if (!(isset($_POST['login']) && isset($_POST['password']) && isset($_POST['password_conf'])) 
|| ($_POST['password'] != $_POST['password_conf']) || ($_POST['password'] == "") || ($_POST['login'] == "")) die;
$login = $_POST['login'];
$hash_password = sha1($_POST['password']);
$query = "SELECT * FROM users";
$flag = false;
if ($result = $mysqli->query($query)){
    $rows = $result->num_rows;
    for($i = 0; $i < $rows; $i++){
        $row = $result->fetch_array(MYSQLI_NUM);
        if ($row[0] == $login){
            if($row[1] != $hash_password) 
            {
                echo $row[1];
                echo "<br>";
                echo $hash_password;
                die("Неверный пароль");
            }
            $flag = true;
            break;
        }
    }
    if(!$flag){
        $query = "INSERT INTO users VALUES ('$login', '$hash_password')";
        if ($mysqli->query($query)){
            echo "Новый пользователь зарегистрирован<br>";
        } else {
            die("Ошибка регистрации<br>");
        }
    }
}
else{
    die("Не удалось выполнить запрос<br>");
}



echo
"<form method='POST'>
<br><br>
<input type='hidden' name='login' value='$login' />
Новый пароль: <input type='text' name='new_password' size=5%/ value=''><br>
<input type='submit' value='Ввести'>
</form><br><br>";




function showTable($mysqli, $select_query):bool
{
    $result = $mysqli->query($select_query); 
    if ($result){
        $columns = $mysqli->field_count;
        $rows = $result->num_rows;
        for ($i = 0 ; $i < $rows ; ++$i){
                $row = $result->fetch_array(MYSQLI_NUM);
                echo "<tr>";
                    for ($j = 0 ; $j < $columns ; ++$j) echo "<td>$row[$j]</td>";
                echo "</tr>";
            }
        return true;
    }
    return false;
}
const ORDERS_COLUMNS = ['id','id_product','customer', 'address', 'order_date'];
const PRODUCTS_COLUMNS = ['id','name','short_description', 'cost', 'in_stock'];

if(!isset($_GET['key1']) or !in_array($_GET['key1'], ORDERS_COLUMNS)){
    $key1 = 'id';
}
else $key1 = $_GET['key1'];

if(!isset($_GET['key2']) or !in_array($_GET['key2'], PRODUCTS_COLUMNS)){
    $key2 = 'id';
}
else $key2 = $_GET['key2'];


echo "<table border = 1><tr>
<th><a href=\"laba5.php?key1=id&key2=$key2\">ID</th>
<th><a href=\"laba5.php?key1=id_product&key2=$key2\">ID товара</th>
<th><a href=\"laba5.php?key1=customer&key2=$key2\">Заказчик</th>
<th><a href=\"laba5.php?key1=address&key2=$key2\">Адрес</th>
<th><a href=\"laba5.php?key1=order_date&key2=$key2\">Время заказа</th></tr>";
$query = "SELECT * FROM orders ORDER BY $key1";
if (!showTable($mysqli, $query)){
    echo "</table>"; 
    echo "Ошибка запроса";
}
else echo "</table>"; 
echo "<br><br>";
echo "<table border = 1><tr>
<th><a href=\"laba5.php?key1=$key1&key2=id\">ID</th>
<th><a href=\"laba5.php?key1=$key1&key2=name\">Название набора</th>
<th><a href=\"laba5.php?key1=$key1&key2=short_description\">Описание</th>
<th><a href=\"laba5.php?key1=$key1&key2=cost\">Цена</th>
<th><a href=\"laba5.php?key1=$key1&key2=in_stock\">На складе</th></tr>";
$query = "SELECT * FROM products ORDER BY $key2";
if (!showTable($mysqli, $query)){
    echo "</table>"; 
    echo "Ошибка запроса";
}
else echo "</table>";

echo "<br><br>";

echo "<table border = 1><tr>
<th>Заказчик</th>
<th>Адрес</th>
<th>Комплект</th>
<th>Цена</th>";
$query = "SELECT orders.customer, orders.address, products.short_description, products.cost FROM orders
INNER JOIN products ON orders.id_product=products.id ORDER BY customer";
if (!showTable($mysqli, $query)){
    echo "</table>"; 
    echo "Ошибка запроса";
}
else echo "</table>";
$mysqli->close();

?>
</body>
</html>