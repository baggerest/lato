<html>
<head>
    <title></title>
</head>
<body>
<div>
    <form action="index.php" method="post" name="searchlato">
        <input name="inputnumber" type="text" value="<?php if(isset($_POST['inputnumber']))echo $_POST['inputnumber']?>">
        <input name="sumbit" type="submit">
    </form>
</div>
</body>
</html><?php
include 'function.php';

if(isset($_POST['inputnumber']))
    search_number($_POST['inputnumber']);