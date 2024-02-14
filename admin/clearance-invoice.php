<?php

include "function.php";

$time_created = time();

if(isset($_GET['user_id']) && isset($_GET['scheme_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['user_id']);
    $scheme_id = mysqli_real_escape_string($conn, $_GET['scheme_id']);
} else {
    header('location: users.php');
}

$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id='$id'");
if(mysqli_num_rows($user_query) > 0) {
    $user_result = mysqli_fetch_assoc($user_query);
	$meta_query = mysqli_query($conn, "SELECT meta_key, meta_value FROM user_meta WHERE user_id='$id'");
	if(mysqli_num_rows($meta_query) > 0) {
		while($meta_result = mysqli_fetch_assoc($meta_query)) {
			$meta[$meta_result['meta_key']] = $meta_result['meta_value'];
		}
	}
} else {
    header('location: users.php');
}

$query = mysqli_query($conn, "SELECT * FROM clearance WHERE user_id='$id' && scheme_id='$scheme_id'");
if(mysqli_num_rows($query) > 0) {
    $result = mysqli_fetch_assoc($query);
} else {
    header('location: users.php');
}

?>
<!DOCTYPE html>
<html>
    <head>
        <?php include "head.php"; ?>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Noto+Nastaliq+Urdu:wght@400;700&display=swap" rel="stylesheet">
        <style>
            body {
                font-family: 'Noto Nastaliq Urdu', serif;
            }
        </style>
    </head>
    <body>
        <?php
        
        if($result['clearance_type'] == 1 && $result['payment_type'] == 1) {
        
        ?>
        <div class="m-5 px-5">
            <h2 class='text-center'>کلیئر نس سر ٹیفیکیٹ دانش ایزی انسٹالمنٹ موٹر سائیکل سکیم</h2>
            <h4 class='text-center mt-4'>
                <strong><?php echo $meta['user_shipno']; ?></strong>
                <span>:ممبر شپ نمبر </span>
            </h4>
            <p style="direction: rtl; line-height: 35px;" class='text-right mt-4'>
                میں مسمی 
                <span><?php echo $meta['user_name']; ?></span>
                ولد 
                <span><?php echo $meta['user_father_name']; ?></span>
                 ساکنہ 
                <span><?php echo $meta['user_address']; ?></span> 
                تحصیل و ضلع ہری پور
            </p>
            <p style="direction: rtl; line-height: 35px;" class='text-right'>
                دانش ایزی انسٹالمنٹ موٹر سائیکل سکیم کا 27 مئی 2022 کو اختتام ھو چکا ھے اور  میں نے دانش ایزی انسٹالمنٹ موٹر سائیکل سکیم میں کمیٹی کے متعلق اپنا تمام  حساب مبلغ
                <strong style='font-family: sans-serif;'>-/Rs: <?php echo $result['total_paid_amount'].'&nbsp;&nbsp;'; ?></strong>
                 نقد وصول کر لیے ہیں۔ آج کے بعد میرا کوئی لین دین باقی نہیں ھے رسید لکھ دی ھے تاکہ سند رھے اور بوقت ضرورت کام آ سکے۔
            </p>
            <div class='row'>
                <div class='col-6'>
                    <p style='font-family: sans-serif;'>Receiver Signature:________________________________</p>
                    <p style='font-family: sans-serif;'>Phone Number: <?php echo $result['user_phone']; ?></p>
                </div>
                <div class='col-6'>
                    <p style='font-family: sans-serif;'>CNIC: <?php echo $result['user_cnic']; ?></p>
                    <p style='font-family: sans-serif;'>Date: <?php echo date('d-F-Y', $result['time_created']); ?></p>
                </div>
            </div>
        </div>
        <?php
        
        } else if($result['clearance_type'] == 1 && $result['payment_type'] == 2) {
        ?>
        <div class="m-5 px-5">
            <h2 class='text-center'>کلیئر نس سر ٹیفیکیٹ دانش ایزی انسٹالمنٹ موٹر سائیکل سکیم</h2>
            <h4 class='text-center mt-4'>
                <strong><?php echo $meta['user_shipno']; ?></strong>
                <span>:ممبر شپ نمبر </span>
            </h4>
            <p style="direction: rtl; line-height: 35px;" class='text-right mt-4'>
                میں مسمی 
                <span><?php echo $meta['user_name']; ?></span>
                ولد 
                <span><?php echo $meta['user_father_name']; ?></span>
                 ساکنہ 
                <span><?php echo $meta['user_address']; ?></span> 
                تحصیل و ضلع ہری پور
            </p>
            <p style="direction: rtl; line-height: 35px;" class='text-right'>
                دانش ایزی انسٹالمنٹ موٹر سائیکل سکیم کا 27 مئی 2022 کو اختتام ھو چکا ھے اور  میں نے دانش ایزی انسٹالمنٹ موٹر سائیکل سکیم میں کمیٹی کے متعلق اپنا تمام  حساب مبلغ
                <strong style='font-family: sans-serif;'>-/Rs: <?php echo $result['total_paid_amount'].'&nbsp;&nbsp;'; ?></strong>
                 چیک نمبر:
                <strong style='font-family: sans-serif;'><?php echo $result['cheque_number'].'&nbsp;&nbsp;'; ?></strong>
                 تاریخ چیک:
                <strong style='font-family: sans-serif;'><?php echo $result['cheque_for_date'].'&nbsp;&nbsp;'; ?></strong>
                 نام بینک:
                <strong style='font-family: sans-serif;'><?php echo $result['bank_name'].'&nbsp;&nbsp;'; ?></strong>
                 وصول کر لیے ہیں۔ لہذا آج کے بعد میرا کوئی لین دین باقی نہیں ھے رسید لکھ دی ھے تاکہ سند رھے اور بوقت ضرورت کام آ سکے۔
            </p>
            <div class='row'>
                <div class='col-6'>
                    <p style='font-family: sans-serif;'>Receiver Signature:________________________________</p>
                    <p style='font-family: sans-serif;'>Phone Number: <?php echo $result['user_phone']; ?></p>
                </div>
                <div class='col-6'>
                    <p style='font-family: sans-serif;'>CNIC: <?php echo $result['user_cnic']; ?></p>
                    <p style='font-family: sans-serif;'>Date: <?php echo date('d-F-Y', $result['time_created']); ?></p>
                </div>
            </div>
        </div>
        <?php
        } else if($result['clearance_type'] == 2) {
        ?>
        <div class="m-5 px-5">
            <h2 class='text-center'>کلیئر نس سر ٹیفیکیٹ دانش ایزی انسٹالمنٹ موٹر سائیکل سکیم</h2>
            <h4 class='text-center mt-4'>
                <strong><?php echo $meta['user_shipno']; ?></strong>
                <span>:ممبر شپ نمبر </span>
            </h4>
            <p style="direction: rtl; line-height: 35px;" class='text-right mt-4'>
                میں مسمی 
                <span><?php echo $meta['user_name']; ?></span>
                ولد 
                <span><?php echo $meta['user_father_name']; ?></span>
                 ساکنہ 
                <span><?php echo $meta['user_address']; ?></span> 
                تحصیل و ضلع ہری پور
            </p>
            <p style="direction: rtl; line-height: 35px;" class='text-right'>
                دانش ایزی انسٹالمنٹ موٹر سائیکل سکیم کا 27 مئی 2022 کو اختتام ھو چکا ھے اور  میں نے دانش ایزی انسٹالمنٹ موٹر سائیکل سکیم میں کمیٹی کے متعلق اپنا تمام  حساب مبلغ
                <strong style='font-family: sans-serif;'>-/Rs: <?php echo $result['total_paid_amount'].'&nbsp;&nbsp;'; ?></strong>
                 کلیئر کر کے ماڈل نمبر 2022 موٹر سائیکل وصول کر لیا ہے۔
                 جس کا 
                 <strong style='font-family: sans-serif;'>Engine Number: <?php echo $result['engine_number']; ?></strong>
                 اور 
                 <strong style='font-family: sans-serif;'>Chassis Number: <?php echo $result['chassis_number']; ?></strong>
                ہے۔ لہذا آج کے بعد میرا کوئی لین دین باقی نہیں ھے رسید لکھ دی ھے تاکہ سند رھے اور بوقت ضرورت کام آ سکے۔
            </p>
            <div class='row'>
                <div class='col-6'>
                    <p style='font-family: sans-serif;'>Receiver Signature:________________________________</p>
                    <p style='font-family: sans-serif;'>Phone Number: <?php echo $result['user_phone']; ?></p>
                </div>
                <div class='col-6'>
                    <p style='font-family: sans-serif;'>CNIC: <?php echo $result['user_cnic']; ?></p>
                    <p style='font-family: sans-serif;'>Date: <?php echo date('d-F-Y', $result['time_created']); ?></p>
                </div>
            </div>
        </div>
        <?php
        }
        
        ?>
        <?php include "js.php"; ?>
    </body>
</html>































