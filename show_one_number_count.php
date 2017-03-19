<a href="index.php">回首頁</a><br>
<?php
include 'function.php';
$start = 1;
$end = 49;
for($i = $start;$i<=$end;$i++){
    echo "[".str_pad($i,2,"0",STR_PAD_LEFT)."]".search_one_number_count(str_pad($i,2,"0",STR_PAD_LEFT))."次<br>";
}
?>
<a href="index.php">回首頁</a>