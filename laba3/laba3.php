<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <br><br>
	    Directory: <input type="text" name="dir" size=20%/ value="<?php if (isset($_POST["dir"])) Echo $_POST["dir"]; ?>"><br><br>
	    <input type="submit" value="Вывести">
	</form>
</body>

<?php

const PICTURES = ['jpeg', 'png', 'bmp', 'jpg', 'gif', 'ico, 'tga'];

function picInDir($dir) //проверка объема изображений в директории
{
    $size = 0;
    if($dirHandle = opendir($dir))
    {
        if ($dir[iconv_strlen($dir) - 1] !== "/") {
        {
            $dir = $dir."/";
        }

        while ($dirElement = readdir($dirHandle)) {
        {
            if ($dirElement != "." && $dirElement != "..")
            {
                $file = $dir.$dirElement;
                if (filetype($file) != "dir")
                {
                    $buf = explode(".", $dirElement);
                    if (in_array(strtolower(array_pop($buf)), PICTURES))
                    {
                        $size += filesize($file);
                    }
                }
                else
                {
                    $size += picInDir($file);
                }
            }
        }
        closedir($dirHandle);
        return $size;
    }
    else
    {
        return 0;
    }
}


function dirSize($dir)   //проверка объема всех файлов директории
{
    $size = 0;
    if($dirHandle = opendir($dir))
    {
        if($dir[iconv_strlen($dir) - 1] != "/")
        {
            $dir = $dir."/";
        }

        while(($dirElement = readdir($dirHandle)) !== FALSE)
        {
            if ($dirElement != "." && $dirElement != "..")
            {
                $file = $dir.$dirElement;
                if (filetype($file) == "dir")
                {
                    $size += dirSize($file);
                }
                else
                {
                    $size += filesize($file);
                }
            }
        }
        closedir($dirHandle);
        return $size;
    }
    else
    {
        return 0;
    }
}

function process_dir($path):bool    //обработка директории в соответствии с заданием
{
    if($dirHandle = opendir($path))
    {
        if($path[iconv_strlen($path) - 1] != "/")
        {
            $path = $path."/";
        }
        echo "About ".round(picInDir($path)*100/dirSize($path), 3)." % of pictures.<br>";


        while(($dirElement = readdir($dirHandle)) !== FALSE)
        {
            if ($dirElement != "." && $dirElement != "..")
            {
                $file = $path.$dirElement;
               
                if (filetype($file) != "dir")  
                {
                    echo "<img src='file16.png' alt='file '>".$dirElement."<br>";
                    echo " Size: ".(round(filesize($file)/1024)). " kB<br>";
                    $buf = explode(".", $dirElement);          
                    if (strtolower(array_pop($buf)) == "txt")   //проверка типа файла
                    {
                        if ($handle = fopen($file, 'r'))
                        {
                            $i = 0;
                            while($i < 100)
                            {
                                if (($symb = fgetc($handle)) !== FALSE) echo $symb;
                                else break;
                                $i++;
                            }
                            fclose($handle);
                            if ($i != 0) echo "<br>";
                            echo "Read $i symbols<br>";
                        }
                        else echo "Cannot open text file<br>";
                    }
                }
                else 
                {
                    echo "<img src='dir16.png' alt='file'>".$dirElement."<br>";
                    echo " Size: ".(round(dirSize($file)/1024)). " kB<br>";
                }
                echo " Last inode modified: ".date("F d Y H:i:s.", filectime($file))."<br>";
                echo " Last modified: ".date("F d Y H:i:s.", filemtime($file))."<br>";
                echo " Last accsess: ".date("F d Y H:i:s.", fileatime($file))."<br>";
                echo "<br><br><br>";  
            }
        }
    }
    else
    {
        return FALSE;
    }
    closedir($dirHandle);
    return TRUE;
}


if (isset($_POST["dir"]))
{
    if(is_dir($_POST["dir"]))
    {
        if (!process_dir($_POST["dir"]))
        echo "Error, cannot open dir.";
    }
    else
    {
        echo "Wrong directory name";
    }
}
?>


</html>
