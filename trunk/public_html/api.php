<?php

function parseAddress($strAddress)
{
	$arrInfo			= mb_explode("，", $strAddress);
	$arrItem			= array();
	$arrItem['name']	= isset($arrInfo[0]) ? trim($arrInfo[0]) : "";
	$arrItem['phone1']	= isset($arrInfo[1]) ? trim($arrInfo[1]) : "";
	$arrItem['phone2']	= isset($arrInfo[2]) ? trim($arrInfo[2]) : "";
	$arrItem['address']	= isset($arrInfo[3]) ? trim($arrInfo[3]) : "";
	$arrItem['postcode']= isset($arrInfo[4]) ? trim($arrInfo[4]) : "";
	return $arrItem;
}

function parseInvoice($strTable, &$buyerId)
{
	$arrFliter	= array("序号", "合计", "备注", "卖家姓名：");
	$arrInfo	= explode("\n", $strTable);
	$arrRet		= array();
	foreach ($arrInfo as $key => $value) {
		if (empty($value)) continue;
		$arrRow = explode(" ", trim($value));
		if (count($arrRow) < 4 || in_array($arrRow[0], $arrFliter)) continue;
		elseif ($arrRow[0] == "买家姓名：") {
			$buyerId = " - $arrRow[1]($arrRow[4])";
			continue;
		}
		elseif (is_numeric($arrRow[0])) array_shift($arrRow);
		$arrItem			= array();
		$arrItem['sum']		= array_pop($arrRow);
		$arrItem['price']	= array_pop($arrRow);
		$arrItem['count']	= array_pop($arrRow);
		$arrItem['name']	= array_shift($arrRow);
		$arrRet[]			= $arrItem;
	}
	return $arrRet;
}

function parseSell($content)
{
	$arrRet		= array();
	$arrInfo	= explode("\n", $content);
	$arrInfo	= array_map("trim", $arrInfo);
	foreach ($arrInfo as $key => $value) {
		if (ereg("[0-9]{4}/[0-9]{1,2}/[0-9]{1,2}", $value, $ret)) {
			$arrItem			= array();
			$arrItem['date']	= $ret[0];
			$arrItem['num']		= 1;
			
			$arrName			= explode(" ", $arrInfo[$key - 3]);
			$arrItem['byerName'] = $arrInfo[$key - 2];
			$pos				= count($arrName) - 1;
			$arrItem['byerId']	= $arrName[$pos];
			$arrItem['name']	= implode(" ", array_slice($arrName, 0, $pos));
			if (ereg("\(([0-9]*) 件\)", $arrItem['name'], $num)) {
				$arrItem['num']		= $num[1];
				$arrItem['name']	= trim(str_replace($num[0], "", $arrItem['name']));
			}
						
			$arrRet[] = $arrItem;
		}
	}
	//print_r($arrInfo);
	return $arrRet;
}

function parseDate($strDate, $strFormat = "y m d")
{
	return date($strFormat, strtotime($strDate));
}

function convert($str, $from = "UTF-8", $to = "GBK")
{
	return mb_convert_encoding($str, $to, $from);
}

function mb_explode($separator, $string)
{	
	$sepEnc = mb_detect_encoding($separator, "GBK, UTF-8");
	$strEnc = mb_detect_encoding($string, "GBK, UTF-8");

	if ($strEnc != $sepEnc) {
		$separator = convert($separator, $sepEnc, $strEnc);
	}
	return explode($separator, $string);
}

function dumpHEX($str)
{
	print("<br />");
	for ($i = 0; $i < strlen($str); $i++) {
		printf("0x%02x ", ord($str[$i]));
	}
	print("<br />");
}

class Point
{
	var $x;
	var $y;
	function Point($x, $y)
	{
		$this->x = $x;
		$this->y = $y;
	}
	function toArray()
	{
		return Array($this->x, $this->y);
	}
}

$arrPosition = array(
	// 韵达
	0	=> array(
		"dateFormat"	=> "y   m   d",
		"size"			=> new Point(127, 232),
		"sendDate"		=> new Point(37, 34),
		"srcPhone"		=> new Point(30, 72),
		"srcPCode"		=> new Point(90, 72),
		"dstPhone1"		=> new Point(125, 72),
		"dstPhone2"		=> new Point(125, 68),
		"dstPCode"		=> new Point(180, 72),
		"srcAddr"		=> new Point(20, 45),
		"srcAddrArea"	=> new Point(80, 6),
		"srcAddrSize"	=> NULL,		
		"srcName"		=> new Point(80, 42),
		"dstAddr"		=> new Point(115, 45),
		"dstAddrArea"	=> new Point(82, 6),
		"dstAddrSize"	=> NULL,
		"dstName"		=> new Point(164, 42),
	),

	// 申通
	1	=> array(
		"dateFormat"	=> "y m d",
		"size"			=> new Point(127, 232),
		"sendDate"		=> new Point(125, 83),
		"srcPhone"		=> new Point(36, 72),
		"srcPCode"		=> new Point(72, 72),
		"dstPhone1"		=> new Point(116, 72),
		"dstPhone2"		=> new Point(116, 76),
		"dstPCode"		=> new Point(152, 72),
		"srcAddr"		=> new Point(35, 36),
		"srcAddrArea"	=> new Point(60, 6),
		"srcAddrSize"	=> NULL,		
		"srcName"		=> new Point(75, 64),
		"dstAddr"		=> new Point(115, 36),
		"dstAddrArea"	=> new Point(60, 6),
		"dstAddrSize"	=> NULL,		
		"dstName"		=> new Point(150, 64),
	),

	// 圆通
	2	=> array(
		"dateFormat"	=> "y   m   d",
		"size"			=> new Point(127, 232),
		"sendDate"		=> new Point(66, 104),
		"srcPhone"		=> new Point(26, 81),
		"srcPCode"		=> NULL,
		"dstPhone1"		=> new Point(98, 95),
		"dstPhone2"		=> new Point(136, 95),
		"dstPCode"		=> NULL,
		"srcAddr"		=> new Point(20, 51),
		"srcAddrArea"	=> new Point(72, 6),
		"srcAddrSize"	=> NULL,		
		"srcName"		=> new Point(28, 34),
		"dstAddr"		=> new Point(91, 63),
		"dstAddrArea"	=> new Point(73, 6),
		"dstAddrSize"	=> NULL,		
		"dstName"		=> new Point(102, 46),
	),
	
	// 中通
	3	=> array(
		"dateFormat"	=> "m   d",
		"size"			=> new Point(127, 232),
		"sendDate"		=> new Point(48, 104),
		"srcPhone"		=> new Point(42, 71),
		"srcPCode"		=> new Point(85, 71),
		"dstPhone1"		=> new Point(132, 71),
		"dstPhone2"		=> new Point(132, 66),
		"dstPCode"		=> new Point(175, 71),
		"srcAddr"		=> new Point(43, 40),
		"srcAddrArea"	=> new Point(65, 6),
		"srcAddrSize"	=> NULL,		
		"srcName"		=> new Point(43, 36),
		"dstAddr"		=> new Point(133, 40),
		"dstAddrArea"	=> new Point(65, 6),
		"dstAddrSize"	=> NULL,		
		"dstName"		=> new Point(133, 36),
	),
	
	// 天天
	4	=> array(
		"dateFormat"	=> "Y-m-d",
		"size"			=> new Point(127, 232),
		"sendDate"		=> new Point(33, 37),
		"srcPhone"		=> new Point(31, 50),
		"srcPCode"		=> new Point(81, 73),
		"dstPhone1"		=> new Point(126, 50),
		"dstPhone2"		=> new Point(160, 50),
		"dstPCode"		=> new Point(176, 73),
		"srcAddr"		=> new Point(21, 56),
		"srcAddrArea"	=> new Point(90, 4),
		"srcAddrSize"	=> 9,
		"srcName"		=> new Point(50, 73),
		"dstAddr"		=> new Point(116, 56),
		"dstAddrArea"	=> new Point(86, 6),
		"dstAddrSize"	=> NULL,
		"dstName"		=> new Point(132, 73),
	),	

	// 顺丰
	5	=> array(
		"dateFormat"	=> "m    d",
		"size"			=> new Point(140, 217),
		"sendDate"		=> new Point(121, 120),
		"srcPhone"		=> new Point(84, 73),
		"srcPCode"		=> NULL,
		"dstPhone1"		=> new Point(176, 73),
		"dstPhone2"		=> new Point(176, 69),
		"dstPCode"		=> NULL,
		"srcAddr"		=> new Point(41, 50),
		"srcAddrArea"	=> new Point(78, 6),
		"srcAddrSize"	=> NULL,
		"srcName"		=> new Point(98, 41),
		"dstAddr"		=> new Point(135, 50),
		"dstAddrArea"	=> new Point(80, 6),
		"dstAddrSize"	=> NULL,
		"dstName"		=> new Point(195, 41),
	),
	
); 

# vim:set shiftwidth=4 tabstop=4:
?>
