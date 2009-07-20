<?php

include_once("api.php");
header("Content-Type: text/html; charset=UTF-8");

$str1 = "日本直送Daiso大创脂吸止系15天量 更有效的分解多余脂肪  xxxxxx 
某某
旺旺离线 20.00
 2008/06/03 17:54:21  交易成功 
详情 
 快递 

  投诉  对方已评 
评价     
     日本直送Daiso大创烧化系1 (2 件)  xxxxxx 
某某
旺旺离线 30.00
 2008/06/03 17:07:20  交易成功 
详情 
 快递 

  投诉  对方已评 
评价     
     日本直送Daiso大创烧化系1 (2 件)  xxxxxx 
某某
旺旺离线 30.00
 2008/06/03 17:54:19  交易关闭 
详情 
 快递 
-  投诉  -     
     日本直送Daiso大创脂吸止系 (2 件)  xxxxxx 
某某
旺旺离线 35.00
 2008/04/17 15:37:01  交易成功 
详情 
 快递 

  投诉  双方 

";
print_r(parseSell($str1));

/*
$addr = "姓名：某某 运送方式：快递 手机：12345678901收货地址：某某省 某某市 某某区 某某地址 电话：0000-11111111 邮       编：000000 ";
$arrInfo = parseAddress($addr);
print_r($arrInfo);
*/

/*
$date = "2008-04-21";
$arrInfo = parseDate($date);
print_r($arrInfo);
*/

/*
$str = "发货单信息1 

 您的购物清单 
买家姓名： 买家  旺旺ID： 旺旺ID  发货日期： 2008-03-10 
序号 货品名称 数量 单价 金额 
1 日本直送Daiso大创口服透明质酸20天量 无添加 锁住6000倍水份! 8 15.00 130.00 
合计   8   130.00 
备注  
卖家姓名： 卖家  旺旺ID: 冰心抹茶  联系电话： 13555555555  
祝您购物愉快！
淘宝店铺地址：http://shop33809206.taobao.com/
http://icetea.go.8866.org/   

";

$arrInfo = parseInvoice($str, $buyer);
print_r($arrInfo);
print($buyer);
*/


/*
foreach($arrPosition as $key => $arrPos) {
	print("arrPos[$key]:\n");
	array_walk($arrPos, "onEach");
	print("\n\n");
}

$height = 0;
function onEach($obj, $key) {
	global $height;
	if (is_object($obj)) {
		print($key . "\n");
		if ($key == "size") {
			printf("X:%d Y:%d\n", mmToPoint($obj->y), mmToPoint($obj->x));
			$height = $obj->x;
		}
		elseif (strstr($key, "Addr")) {
			print("NULL\n");		
		}
		else printf("X:%d Y:%d\n", mmToPoint($obj->x), mmToPoint($height - $obj->y));
		//print_r($obj);
	}
	else if ($obj == NULL) {
		print("{$key}\nNULL\n");
	}
}

function mmToPoint($number) {
	return round($number / 10 / 2.54 * 72);
}
*/

?>