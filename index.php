<?php
/**
 * Created by PhpStorm.
 * User: Zachary
 * Date: 2017/3/16
 * Time: 下午 02:52
 */

// <td style="background-color: #B02D00; color: #FFFFFF; font-size: 32px; font-weight: bold;text-align:center">特別號</td> - 開始讀取
// <ins class="clickforceads" style="display:inline-block;width:728px;height:90px" data-ad-zone="942"></ins> - 讀取結束
//共61頁
// http://www.pilio.idv.tw/ltobig/list.asp?indexpage=1 - 網址
function get_url_list(){
    $start = '<td style="background-color: #B02D00; color: #FFFFFF; font-size: 32px; font-weight: bold;text-align:center">特別號</td>';
    $end = '<ins class="clickforceads" style="display:inline-block;width:728px;height:90px" data-ad-zone="942"></ins>';
    $start_page = 1;
    $end_page = 61;
    $code_list = array();
    $f_w = fopen("ht.txt",'w');
    for($i=$start_page;$i<=$end_page;$i++){
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
                $code_list[] = $value;
                fwrite($f_w,"{$value}\r\n");
            }
        }
    }
    fclose($f_w);
    return $code_list;
}


$f = file('ht.txt',FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
$list = array();
foreach ($f as $value){
    $list[] = $value;
}

function get_number_list($input_get_url_list = array()){
    $replace_list_to_null = array(
        '<td style="font-size: 32px; font-weight: bold; color: #000000;border-bottom-style: dotted; border-bottom-color: #CCCCCC">',
        '<td style="font-size: 48px; font-weight: bold; color: #000000;border-bottom-style: dotted; border-bottom-color: #CCCCCC">',
        '\r\n',
    );

    $replace_list_to_doin = array(
        '&nbsp;&nbsp;',
        '<td style="font-size: 48px; font-weight: bold; color: #000000;border-bottom-style: dotted; border-bottom-color: #CCCCCC; word-break: break-all">',
        ',&nbsp;',
        '</td>',
    );

    $replace_list_to_brackets_end = array(
        '&nbsp;&nbsp;</td>',
    );

    $replace_list_to_br = array(
        '<br />',
    );

    $list_lato = array();
    $marge = null;
    $f_w = fopen('numberlist.txt','w');
    foreach ($input_get_url_list as $value) {
        $value = str_replace($replace_list_to_brackets_end, '!', $value);
        $value = str_replace($replace_list_to_br, '/', $value);
        $value = str_replace($replace_list_to_null, '', $value);
        $value = str_replace($replace_list_to_doin, ',', $value);
        if ($value === null) continue;
        $marge .= $value;
        if (strpos($value, '!') !== false) {
            fwrite($f_w,"{$marge}\r\n");
            $list_lato[] = explode(',',$marge);
            $marge = null;
        }
    }
    fclose($f_w);
    return array_reverse($list_lato);
}

//
//math_lato(get_number_list($list));
//
//function math_lato($input_list = array()){
//    error_reporting(0);
//    $lato_number = array();
//    foreach ($input_list as $value){
//        foreach ($value as $key => $number){
//            if($key===0)continue;
//            $lato_number[$number]++;
//        }
//    }
//    for ($i=1;$i<=49;$i++){
//        if($i<10){
//            echo "[".str_pad($i,2,"0",STR_PAD_LEFT)."]".$lato_number[str_pad($i,2,"0",STR_PAD_LEFT)].'<br>';
//        }else{
//            echo "[".$i."]".$lato_number[$i].'<br>';
//        }
//    }
//    for ($i=1;$i<=49;$i++){
//        if($i<10){
//            echo "[".str_pad($i,2,"0",STR_PAD_LEFT)."!]".$lato_number[str_pad($i,2,"0",STR_PAD_LEFT)."!"].'<br>';
//        }else{
//            echo "[".$i."!]".$lato_number[$i."!"].'<br>';
//        }
//    }
//}