<?php 
//ver 1.32 st 
include 'config.php';

$stmtto = $connpdo->prepare("SELECT * FROM orders WHERE `user` = ? ORDER BY idorder DESC LIMIT 1");
$roworder = $stmtto->fetch(PDO::FETCH_LAZY);
$order_id = $roworder["date"];
 
$ch = curl_init('https://api.yookassa.ru/v3/payments/' . $order_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERPWD, 'id:key');
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Idempotence-Key: ' . date("Ymd-His")));
	$res = curl_exec($ch);
curl_close($ch);
$res = json_decode($res, true);
if ($res['status']=='succeeded'){
	$sthtt = $connpdo->prepare("UPDATE `orders` SET `pay`=1 WHERE `date` = :id");
	$sthtt->execute(array('id' => $order_id));
}
 
?>