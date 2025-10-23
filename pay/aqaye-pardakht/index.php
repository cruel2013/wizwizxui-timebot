<?php

$pin = "F69B649E9707E1955D0A"; // کد پین درگاه شما


ob_start();
echo '
<!DOCTYPE html>
<html lang="fa">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="images/logo.png" />
		<title>پرداخت آنلاین</title>
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

$url = $_SERVER[ 'REQUEST_URI' ]; // آدرس سایت شما را برمی گرداند
$parts = explode( '/', $url );
$callback = $_SERVER[ 'SERVER_NAME' ];
for ( $i = 0; $i < count( $parts ) - 1; $i++ ) {
  $callback .= $parts[ $i ] . "/";
}
$callback .= "verify.php";

if ( !Empty( $_POST ) ) {
  $url = 'https://panel.aqayepardakht.ir/api/create/';
  $description = "";
  if ( !Empty( $_POST[ "name" ] ) ) {
    $description .= "نام و نام خانوادگی : " . $_POST[ "name" ] . "\n";
  }
  if ( !Empty( $_POST[ "email" ] ) ) {
    $description .= "ادرس ایمیل : " . $_POST[ "email" ] . "\n";
  }
  if ( !Empty( $_POST[ "phone" ] ) ) {
    $description .= "شماره موبایل : " . $_POST[ "phone" ] . "\n";
  }
  if ( !Empty( $_POST[ "details" ] ) ) {
    $description .= "توضیحات کاربر : " . $_POST[ "details" ] . "\n";
  }
  if ( Empty( $_POST[ "amount" ] )or $_POST[ "amount" ] < 100 ) {
    $_POST[ "amount" ] = '100';
  }

  $callback .= "?amount=" . $_POST[ "amount" ];
  $fields = array(
    'amount' => urlencode( $_POST[ "amount" ] ),
    'pin' => urlencode( $pin ),
    'description' => urlencode( $description ),
    'callback' => urlencode( $callback ),
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


  if ( is_numeric( $result ) ) {
    echo '
    <p class="text-center" style="color:red">خطا : ' . $result . '</p>';
  } else {
    echo $result;
    header( 'Location: https://panel.aqayepardakht.ir/startpay/' . $result );
  }
}

echo '    
									<form class="form-horizontal" method="post">
																			<div class="form-group">
											<label class="col-sm-4 col-xs-12 col-md-4 control-label hidden-sm hidden-xs" for="formGroupInputLarge">مبلغ به تومان</label>
											<input type="text" class="form-control numericMask" id="formGroupInputLarge" placeholder="لطفا مبلغ به تومان را وارد کنید..." name="amount">
										</div>
										<div class="form-group">
											<label class="col-sm-4 col-xs-12 col-md-4 control-label hidden-sm hidden-xs" for="formGroupInputLarge">نام و نام خانوادگی</label>
											<input type="text" class="form-control" id="formGroupInputLarge" placeholder="لطفا نام و نام خانوادگی خودتان را وارد کنید..." name="name">
										</div>
										<div class="form-group">
											<label class="col-sm-4 col-xs-12 col-md-4 control-label hidden-sm hidden-xs" for="formGroupInputLarge">ایمیل</label>
											<input type="text" class="form-control" id="formGroupInputLarge" placeholder="لطفا ایمیل خودتان را وارد کنید..." name="email">
										</div>
										<div class="form-group">
											<label class="col-sm-4 col-xs-12 col-md-4 control-label hidden-sm hidden-xs" for="formGroupInputLarge">تلفن همراه</label>
											<input type="text" class="form-control" id="formGroupInputLarge" placeholder="لطفا تلفن همراه خودتان را وارد کنید..." name="phone">
										</div>
										<div class="form-group">
										<label class="col-sm-4 col-xs-12 col-md-4 control-label hidden-sm hidden-xs" for="formGroupInputLarge">توضیحات</label>
											<textarea class="form-control" rows="3" placeholder="لطفا در صورت  نیاز به توضیح اینجا متن توضیحات را بنویسید..." name="details"></textarea>
										</div>
										<div class="form-group text-center">	
											<button type="submit" class="btn btn-success col-sm-6 col-xs-12 col-sm-offset-3">پرداخت</button>		
										</div>
									</form>
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
ob_end_flush();