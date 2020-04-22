<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laba_2</title>
    <style type = "text/css">
        .menu
        {   
            width: 100%;
            padding: 0;
            margin: 0 auto;
            display: flex;
            flex-direction: row;
            justify-content: center;
            list-style: none;
        }
        a
        {
            padding: 20px;
            margin: 0;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 22px;
            color: black;
        }   
        .currentElement
        {
            background-color: gray;
        }
    </style>
    <?php
        $navigation = array('Main', "Books", "Series", "Contacts");
        if(isset($_GET["index"]))
            $index = $_GET["index"];
        else
            $index = 0;
    ?>
</head>
<body>
    <header>
        <ul class="menu">
            <?php 
            foreach($navigation as $key => $value) {
                ?>
                <li>
                    <?php
                    if ($index == $key) {
                        ?>
                        <a class = "currentElement" href="#"><?php echo $value ?></a>
                        <?php
                    } else {
                        ?>
                        <a href="laba2-1.php?index=<?=$key?>"><?php echo $value ?></a>
                        <?php
                    }
                    ?>
                </li>
                <?php
            }
            ?>
        </ul>
    </header>
    <form method="POST">
        <br><br>
	    lvl 0: <input type="text" name="lvl0" size=3%/ value="<?php if (isset($_POST["lvl0"])) Echo $_POST['lvl0']; ?>"><br><br>
	    lvl 1: <input type="text" name="lvl1" size=3%/ value="<?php if (isset($_POST["lvl1"])) Echo $_POST['lvl1']; ?>"><br><br>
	    lvl 2: <input type="text" name="lvl2" size=3%/ value="<?php if (isset($_POST["lvl2"])) Echo $_POST['lvl2']; ?>"><br><br>
	    lvl 3: <input type="text" name="lvl3" size=3%/ value="<?php if (isset($_POST["lvl3"])) Echo $_POST['lvl3']; ?>"><br><br>
        lvl 4: <input type="text" name="lvl4" size=3%/ value="<?php if (isset($_POST["lvl4"])) Echo $_POST['lvl4']; ?>"><br><br>
        Elements: <input type="text" name="elements" size=80%/ value="<?php if (isset($_POST["elements"])) Echo $_POST['elements']; ?>"><br><br>
	    <input type="submit" value="Вывести">
	</form>
</body>


<?php
function isValidArray(&$array):bool//функция проверки правильно введенных данных
{
    if (count($array)==6){
        for ($j=0;$j<5;$j++){
            if (!(ctype_digit($array[$j]) || $array[$j] <= 0))
            {
                return false;
            } 
        }
        $count = $array[0]*$array[1]*$array[2]*$array[3]*$array[4];
        if (is_array($array[5]) && count($array[5]) == $count && $count >= 20)
        { 
            return true;
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}


function processArray(&$array)//функция обработки из задания
{
    for ($i = 0; $i < count($array); $i++)
        {
            for($j = 0; $j < count($array[$i]); $j++)
            {
                for($k = 0; $k < count($array[$i][$j]); $k++)
                {
                    for($l = 0; $l < count($array[$i][$j][$k]); $l++)
                    {
                        if(sort($array[$i][$j][$k][$l], SORT_STRING))
                        {
                            foreach($array[$i][$j][$k][$l] as $key => $element)
                            {
                                if (is_numeric($element))
                                {
                                    if (ctype_digit($element))
                                    {
                                        unset($array[$i][$j][$k][$l][$key]);
                                    }
                                    else
                                    {
                                        $array[$i][$j][$k][$l][$key] = round((float)$element, 2);
                                    }
                                }
                                else
                                {
                                    $array[$i][$j][$k][$l][$key] = strtoupper($element);
                                }
                            }
                        }
                        
                    }
                }
            }
        }
}

if(isset($_POST["lvl0"]) && isset($_POST["lvl1"]) && isset($_POST["lvl2"]) && isset($_POST["lvl3"]) && isset($_POST["lvl4"]) && isset($_POST["elements"]))
{
    $lvl0 = $_POST["lvl0"];
    $lvl1 = $_POST["lvl1"];
    $lvl2 = $_POST["lvl2"];
    $lvl3 = $_POST["lvl3"];
    $lvl4 = $_POST["lvl4"];
    $elements = explode(",",str_replace(' ', '', $_POST["elements"]));
    $initArray = array($lvl0, $lvl1, $lvl2, $lvl3, $lvl4, $elements);
    $array = array();
    $shift = 0;
    if (isValidArray($initArray))
    {
        for ($i = 0; $i < $lvl0; $i++)
        {
            for($j = 0; $j < $lvl1; $j++)
            {
                for($k = 0; $k < $lvl2; $k++)
                {
                    for($l = 0; $l < $lvl3; $l++)
                    {
                        for($m = 0; $m < $lvl4; $m++)
                        {
                            $array[$i][$j][$k][$l][$m] = $elements[$m + $shift];
                        }
                        $shift += $lvl4;
                    }
                }
            }
        }

        echo "<pre>";
        echo "Befor processing\n\n";
        print_r($array);
        echo "</pre>";

        processArray($array); //функция обработки из задания

        echo "<pre>";
        echo "After processing\n\n";
        print_r($array);
        echo "</pre>";
    }
    else
    {
        echo "Input error";
    }
}
?>

</html>