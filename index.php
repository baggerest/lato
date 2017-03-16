<?php
/**
 * Created by PhpStorm.
 * User: Zachary
 * Date: 2017/3/16
 * Time: 下午 02:52
 */

// <table class="auto-style1"> - 開始讀取
// <ins class="clickforceads" style="display:inline-block;width:728px;height:90px" data-ad-zone="942"></ins> - 讀取結束
//共61頁
// http://www.pilio.idv.tw/ltobig/list.asp?indexpage=1 - 網址
function get_url_list(){
    $start = '<table class="auto-style1">';
    $end = '<ins class="clickforceads" style="display:inline-block;width:728px;height:90px" data-ad-zone="942"></ins>';
    $start_page = 1;
    $end_page = 61;
    $f_w = fopen("ht.txt",'a');

    for($i=$start_page;$i<=$end_page;$i++){
        $f = file("http://www.pilio.idv.tw/ltobig/list.asp?indexpage={$i}",FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
        $read = false;
        foreach ($f as $value){
            $value = trim($value);
            if($read===false){
                if($value===$start){
                    $read = true;
                }
            }else{
                if($value===$end){
                    $read = false;
                    break;
                }
            }
            if($read===true)fwrite($f_w,"{$value}\r\n");
        }
    }
    fclose($f_w);
}

function get_number_list(){

}