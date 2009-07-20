<?php

include_once("api.php");

mb_internal_encoding("UTF-8");

$strList	= isset($_REQUEST['list']) ? trim($_REQUEST['list']) : "";
$iPostage	= isset($_REQUEST['postage']) ? intval($_REQUEST['postage']) : 10;
$strNote	= isset($_REQUEST['note']) ? trim($_REQUEST['note']) : "(无)";
$strSender	= isset($_REQUEST['sender']) ? trim($_REQUEST['sender']) : "冰心抹茶";

$arrInfo	= parseInvoice($strList, $buyerId);
$iTotal		= $iPostage;
foreach ($arrInfo as $key => $value) {
	$iTotal	+= $value['price'] * $value['count'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>发货单</title>
<style type="text/css">
body { font-size:16px; }
</style>
<style type="text/css" media="print">
.noprint { display:none; }
</style>
</head>

<body>
<table border="0">
  <tr>
    <td colspan="5" align="center"> 购 物 清 单<?php print($buyerId); ?></td>
  </tr>
  <tr>
    <td height="8" colspan="5" align="center"></td>
  </tr>
  <tr>
    <td >货品名称</td>
    <td width="10">&nbsp;</td>	
    <td width="40">数量</td>
    <td width="60">单价</td>
    <td width="60">小节</td>
  </tr>
  <?php foreach ($arrInfo as $key => $value) { ?>
  <tr>
    <td><?php print(mb_strimwidth($value['name'], 0, 44, "..")); ?></td>
	<td>&nbsp;</td>	
    <td><?php print($value['count']); ?></td>
    <td><?php printf("%.2f", $value['price']); ?></td>
    <td><?php printf("%.2f", $value['count'] * $value['price']); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="5" colspan="5"></td>
  </tr>
  <tr>
    <td colspan="3"><?php if (false == empty($strNote)) print("备注: " . mb_strimwidth($strNote, 0, 40, "..")); ?></td>
    <td>邮费</td>
    <td><?php printf("%.2f", $iPostage); ?></td>
  </tr>
  <tr>
    <td><?php print($strSender); ?> 祝您购物愉快!</td>
	<td>&nbsp;</td>	
    <td>&nbsp;</td>
    <td>合计</td>
    <td><?php printf("%.2f", $iTotal); ?></td>
  </tr>
</table>
</body>
</html>