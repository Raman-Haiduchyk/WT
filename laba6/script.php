
<?php

session_start();

function getHistory()
{
    $historyArray = isset($_SESSION['history'])?$_SESSION['history']:[];
    $isFound = false;
    $index = 0;
    while($index < count($historyArray)){
        if($historyArray[$index][0] == basename($_SERVER['PHP_SELF'])){
            $isFound = true;
            break;
        }
        $index++;
    }
    if($isFound){
        $historyArray[$index][1]++;
    }else{
        $index = isset($_SESSION['lastIndex'])?$_SESSION['lastIndex']:-1;
        $index++;
        $historyArray[$index][0] = basename($_SERVER['PHP_SELF']);
        $historyArray[$index][1] = isset($historyArray[$index][1])?$historyArray[$index][1]:0;
        $historyArray[$index][1]++;
        $_SESSION['lastIndex'] = $index;
    }
    $_SESSION['history'] = $historyArray;
    echo "Вы посетили следующие страницы:<br>";
    foreach($historyArray as $record){
        echo "  ".$record[0]."; количество посещений ".$record[1]."<br>";
    }

}


?>
