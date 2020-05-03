<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
<h4>
    Форматы записи телефонных номеров (x - код страны, y - код оператора, a - код города/области/штата z - номер абонента; коды содержат 1-3 цифры):
</h4>
<ul>
<li>+xxx yy zzz-zz-zz  - мобильный</li>
<li>+xxx yy zzzzzzz  - мобильный</li>
<li>+xxxyyzzzzzzz  - мобильный</li>
<li>(+xxx aaa)zzzzzzz</li>
<li>(+xxx aaa)zzz-zz-zz</li>
<li>zzzzzzz</li>
<li>zzz-zz-zz</li>
</ul>
<form method="POST">
        <br><br>
	    Text: <input type="text" name="user_text" size=80%/ value="<?php if (isset($_POST["user_text"])) Echo $_POST['user_text']; ?>"><br><br>
	    <input type="submit" value="Вывести">
	</form>
</body>

<?php

    function replace($str, $regExp, bool $mode):string
    {
        if ($mode)
        {
            $class = "'mobile'";
        }
        else
        {
            $class = "'landLine'";
        }
        $matches = array();
        if (preg_match_all($regExp, $str, $matches) != FALSE)
        {
            foreach($matches[0] as $value)
            {
                $str = str_replace($value, "<span class=$class>$value</span>", $str);
            }
            return $str;
        }
        else 
        {
            return $str;
        }
    }
                        //(+XXX)     ( ( (YY)   ( (ZZZ-ZZ-ZZ)   |   (ZZZZZZZ) ) ) | (YYZZZZZZZ)  )      
    $mobileRegExp = "/(\+[0-9]{3})((( \d{1,3} )((\d{3}\-\d{2}\-\d{2})|(\d{7})))|(\d{8,10}))(\b)/";
                        //(+XXX AAA)                 ((zzzzzzz) | (zzz-zz-zz))
    $landlineRegExp = "/((\(\+\d{1,3} \d{1,3}\))|(\b))((\d{7})|(\d{3}\-\d{2}\-\d{2}))(\b)/";

    if (isset($_POST["user_text"]))
    {
        $str = htmlentities($_POST["user_text"]);
        $newStr = replace(replace($str, $mobileRegExp, TRUE), $landlineRegExp, FALSE);
        echo "<br>";
        echo $newStr;    
    }


?>

</html>