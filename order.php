 
	<?php
  $billId = date("Ymd-His");
  $data = array(
        'amount' => array(
            'value' => $price,
            'currency' => 'RUB',
        ),
        'confirmation' => array(
            'type' => 'redirect',
            'return_url' => 'https://exemple.ru/success.php',
        ),
        'capture' => true,
        'description' => 'Название услуги',
        'metadata' => array(
            'order_id' => $idorder
        ),
        'receipt' => array(
            'customer' => array(
                'email' => $email,
            ),
            'items' => array(
                array(
                    'description' => 'Название услуги для чека',
                    'quantity' => '1.00',
                    'amount' => array(
                        'value' => $price,
                        'currency' => 'RUB'
                    ),
                    'vat_code' => '1',
                    'payment_mode' => 'full_payment',
                    'payment_subject' => 'service',
                )
            )
        )
    );
 
$data = json_encode($data, JSON_UNESCAPED_UNICODE);
$ch = curl_init('https://api.yookassa.ru/v3/payments');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_USERPWD, 'id:key');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Idempotence-Key:'.$billId));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 	
$res = curl_exec($ch);
curl_close($ch);	
$res2 = json_decode($res, true);
$link = $res2['confirmation']['confirmation_url'];  


?>