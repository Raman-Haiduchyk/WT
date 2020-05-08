<?php 
    require_once('count_stat.php');
?>

<a href="1.html" id="1" target="_blank" onclick="handler(event)">Ссылка нажата: <?php getValue(1) ?></a>



<script>

function handler(event){
    var request = new XMLHttpRequest();
    request.open('POST', 'count_stat.php');
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('readystatechange', function() {
        if (this.readyState == 4 && this.status == 200){
            event.target.innerText = 'Ссылка нажата: '+this.responseText; 
        }
    });
    request.send('id='+event.target.id);
 }

</script>