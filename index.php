<html>
<head>
    <title></title>
</head>
<body>
<a href="show_one_number_count.php">每個號碼出現的次算數</a><br>
<a href="show_special_count.php">每個特別號碼出現的次數</a><br>
<a href="show_same_lato.php">史上出現相同的6個號碼</a><br>
<a href="show_two_number_count.php">二個號碼同時出現的機率</a>
<div>
    <form action="index.php" method="post" name="searchlato">
        查詢<input name="inputnumber" type="text" value="<?php if(isset($_POST['inputnumber']))echo $_POST['inputnumber']?>">
        <input name="sumbit" type="submit">
    </form>
</div>
</body>
</html><?php
include 'function.php';

if(isset($_POST['inputnumber']))
    search_number($_POST['inputnumber']);