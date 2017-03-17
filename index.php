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
                fwrite($f_w,"{$value}\r\n");
            }
        }
    }
    fclose($f_w);
}
get_number_list();
function get_number_list(){
    $replace_list_to_null = array(
        '</tr>',
        '<tr style="text-align:center; background-color: #FFDBCE;">',
        '<td style="font-size: 32px; font-weight: bold; color: #000000;border-bottom-style: dotted; border-bottom-color: #CCCCCC">',
        '<td style="font-size: 48px; font-weight: bold; color: #000000;border-bottom-style: dotted; border-bottom-color: #CCCCCC">',
        '<tr style="text-align:center; ">',
        '</table>',
        '</td>',
        '\r\n',
    );

    $replace_list_to_doin = array(
        '&nbsp;&nbsp;',
        '<td style="font-size: 48px; font-weight: bold; color: #000000;border-bottom-style: dotted; border-bottom-color: #CCCCCC; word-break: break-all">',
        ',&nbsp;',
    );

    $replace_list_to_brackets_end = array(
        '&nbsp;&nbsp;</td>',
    );

    $replace_list_to_br = array(
        '<br />',
    );

    $f = file("ht.txt",FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
    $f_w = fopen("numberlist.txt",'w');
    foreach ($f as $value){
        $value = str_replace($replace_list_to_brackets_end,';',$value);
        $value = str_replace($replace_list_to_br,'/',$value);
        $value = str_replace($replace_list_to_null,'',$value);
        $value = str_replace($replace_list_to_doin,',',$value);
        if($value===null)continue;
        $s = strpos($value,';');
        if(strpos($value,';')!==false){
            fwrite($f_w,"{$value}\r\n");
        }else{
            fwrite($f_w,$value);
        }
    }
    fclose($f_w);
}