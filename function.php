<?php
function get_url_list(){
    $start = '<td style="background-color: #B02D00; color: #FFFFFF; font-size: 32px; font-weight: bold;text-align:center">特別號</td>';
    $end = '<ins class="clickforceads" style="display:inline-block;width:728px;height:90px" data-ad-zone="942"></ins>';
    $start_page = 1;
    $end_page = 0;
    $f = file("http://www.pilio.idv.tw/ltobig/list.asp?indexpage={$start_page}",FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
    foreach ($f as $item){
        $get_page = str_replace('</option>','^',$item);
        if(strpos($get_page,'^')!==false){
            $end_page++;
        }
    }
    $code_list = array();
    $f_w = fopen("numberlist.txt",'w');
    $marge = null;
    for($i=$start_page;$i<$end_page;$i++){
        $f = file("http://www.pilio.idv.tw/ltobig/list.asp?indexpage={$i}",FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
        $read = false;
        foreach ($f as $value){
            $value = trim($value);
            if($read===false){
                if($value===$start){
                    $read = true;
                    continue;
                }
            }else{
                if($value===$end){
                    $read = false;
                    break;
                }
            }
            if($read===true){
                if($value==='</td>')continue;
                if($value==='</tr>')continue;
                if($value==='<td style="font-size: 48px; font-weight: bold; color: #000000;border-bottom-style: dotted; border-bottom-color: #CCCCCC; word-break: break-all">')continue;
                if($value==='<tr style="text-align:center; background-color: #FFDBCE;">')continue;
                if($value==='<tr style="text-align:center; ">')continue;
                if($value==='</table>')continue;
                $value = str_replace('&nbsp;&nbsp;</td>', '!', $value);
                $value = str_replace('<br />', '/', $value);
                $replace_list_to_null = array(
                    '<td style="font-size: 32px; font-weight: bold; color: #000000;border-bottom-style: dotted; border-bottom-color: #CCCCCC">',
                    '<td style="font-size: 48px; font-weight: bold; color: #000000;border-bottom-style: dotted; border-bottom-color: #CCCCCC">',
                    '\r\n',
                );
                $value = str_replace($replace_list_to_null, '', $value);
                $replace_list_to_doin = array(
                    '&nbsp;&nbsp;',
                    '<td style="font-size: 48px; font-weight: bold; color: #000000;border-bottom-style: dotted; border-bottom-color: #CCCCCC; word-break: break-all">',
                    ',&nbsp;',
                    '</td>',
                );
                $value = str_replace($replace_list_to_doin, ',', $value);
                if ($value === null) continue;
                $marge .= $value;
                if (strpos($value, '!') !== false) {
                    fwrite($f_w,"{$marge}\r\n");
                    $code_list[] = explode(',',$marge);
                    $marge = null;
                }
            }
        }
    }
    fclose($f_w);
    return array_reverse($code_list);
}

function search_number($number = 'number_word,number_word,...'){
    $f = file('numberlist.txt');
    $number_ = explode(',',$number);
    $k = 0;
    foreach ($f as $value) {
        $value = str_replace("\r\n","",$value);
        $lato_list = explode(',', $value);
        $class = 0;
        foreach ($number_ as $item) {
            foreach ($lato_list as $key => $latonumber) {
                if ($item === $latonumber) {
                    $lato_list[$key] = '<span style="background-color:#FFff00">'.$latonumber.'</span>';
                    $class++;
                }
            }
        }
        if ($class === count($number_)) {
            $k++;
            echo "(" . ($k < 10 ? str_pad($k, 2, "0", STR_PAD_LEFT) : $k) . ") ";
            foreach ($lato_list as $show)echo "[{$show}]";
            echo '<br>';
        }
        $lato_list = null;
    }
}

function search_one_number_count($number = 'number_word'){
    $f = file('numberlist.txt');
    $number_ = explode(',',$number);
    $k = 0;
    $count = 0;
    foreach ($f as $value) {
        $value = str_replace("\r\n","",$value);
        $lato_list = explode(',', $value);
        $class = 0;
        foreach ($number_ as $item) {
            foreach ($lato_list as $latonumber) {
                if ($item === $latonumber) {
                    $class++;
                }
            }
        }
        if ($class === count($number_)) {
            $count++;
            $k++;
        }
        $lato_list = null;
    }
    return $count;
}

function search_special_count($number = 'number_word'){
    $f = file('numberlist.txt');
    $number_ = explode(',',$number);
    $k = 0;
    $count = 0;
    foreach ($f as $value) {
        $value = str_replace("\r\n","",$value);
        $lato_list = explode(',', $value);
        $class = 0;
        foreach ($number_ as $item) {
            foreach ($lato_list as $key => $latonumber) {
                if ($item === $latonumber) {
                    $class++;
                }
            }
        }
        if ($class === count($number_)) {
            $count++;
            $k++;
        }
        $lato_list = null;
    }
    return $count;
}

function show_same_lato(){
    $f = file('numberlist.txt');
    foreach ($f as $value) {
        $value = str_replace("\r\n","",$value);
        $list[] = substr($value,11,17);
    }
    foreach ($list as $value){
        $check = 0;
        foreach ($list as $item){
            if($value===$item){
                $check++;
            }
        }
        if($check>=2){
            echo $value."<br>";
        }
    }
}

function show_two_number_count(){
    $f = file('numberlist.txt');
    $start = 0;
    $end = 49;
    foreach ($f as $value){
        $value = str_replace("\r\n","",$value);
        $list[] = explode(",",substr($value,11,17));
    }
    echo "<table border='1' style='text-align:center;'>";
    for ($i=$start;$i<=$end;$i++){
        echo "<tr>";
        for ($j=$start;$j<=$end;$j++){
            $noi = str_pad($i,2,"0",STR_PAD_LEFT);
            $noj = str_pad($j,2,"0",STR_PAD_LEFT);
            switch ($i){
                case 0:
                    echo ($j===0)?"<td></td>":"<th>".$noj."</th>";
                    break;
                default:
                    $count = search_two_number_count($noi.",".$noj,$list);
                    $count = $count>=100?"<span style='background-color: blueviolet'>$count</span>":$count;
                    echo ($j===0)?"<th>".$noi."</th>":"<td>".$count."</td>";
                    break;
            }
        }
        echo "</tr>";
    }
    echo "</table>";
}

function search_two_number_count($number = '',$lato_list = array()){
    $number_ = explode(',',$number);
    $k = 0;
    foreach ($lato_list as $value) {
        $class = 0;
        foreach ($number_ as $item) {
            foreach ($value as $latonumber) {
                if ($item === $latonumber) {
                    $class++;
                }
            }
        }
        if ($class === count($number_)) {
            $k++;
        }
    }
    return $k;
}