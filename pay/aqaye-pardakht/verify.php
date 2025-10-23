<?php

$pin = "F69B649E9707E1955D0A"; // کد پین درگاه شما

$url = 'https://panel.aqayepardakht.ir/api/verify/';
$fields = array(
  'amount' => urlencode( $_GET[ "amount" ] ),
  'pin' => urlencode( $pin ),
  'transid' => urlencode( $_POST[ "transid" ] ),
);
$fields_string = "";
foreach ( $fields as $key => $value ) {
  $fields_string .= $key . '=' . $value . '&';
}
rtrim( $fields_string, '&' );
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url );
curl_setopt( $ch, CURLOPT_POST, count( $fields ) );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields_string );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
$result = curl_exec( $ch );
curl_close( $ch );

echo '<!DOCTYPE html>
<html lang="fa">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>پرداخت آنلاین</title>
	<link rel="shortcut icon" href="images/logo.png" />
    <link href="css/rtl.bootstrap.css" rel="stylesheet">
    <link href="css/reset.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-xs-1 col-sm-1"></div>
        <div class="col-xs-10 col-sm-10">
          <div class="main clearfix">
            <div class="col-xs-12">
              <img src="images/bankLogos.png" class="BankLogos img-responsive">
              <h2 class="titleService">پرداخت آنلاین</h2>
            </div>
            <div class="col-xs-12">
              <div class="rightBox clearfix">
                <div class="payForm col-xs-12">

';
if ( $result === "1" ) {
  echo '<p class="text-center" style="color:green">پرداخت شما با موفقیت انجام شد !</p></br><p class="text-center">کد پیگیری تراکنش : ' . $_POST[ "transid" ] . '</p>';
} else if ( $result === "0" ) {
  echo '<p class="text-center" style="color:red">متاسفیم! پرداخت شما موفقیت آمیز نبود.</p></br><p class="text-center">کد پیگیری تراکنش : ' . $_POST[ "transid" ] . '</p><hr><p class="text-center" style="color:orange">درصورت کسر شدن موجودی از حسابتان ،‌مبلغ کسر شده طی ۱۵ دقیقه الی ۷۲ ساعت کاری آینده از سمت بانک برگشت داده میشود. </p>';
} else {
  echo '<p class="text-center" style="color:red">کد خطا : ' . $result . '</p>';
}
echo '
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xs-1 col-sm-1"></div>
      </div>
    </div>
    <script src="js/jquery.min.js"></script> 
    <script src="js/rtl.bootstrap.js"></script>
  </body>
</html>';