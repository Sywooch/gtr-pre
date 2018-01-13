<?php 
use yii\helpers\Html;

?>
<!--footer start from here-->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-sm-6 footer-col">
        <div class="logofooter"><?=Html::a(Html::img('/img/logo.png', ['style'=>'height: 40px; width: auto;','alt' => 'footer-logo']), Yii::$app->homeUrl, ['option' => 'value']); ?>
</div>
        <p>Online booking for fast boat transfers among Bali – Lombok – Gili Air – Gili Meno – Gili Trawangan – Nusa Lembongan – Nusa Penida Island in Indonesia.</p>
        <p><i class="glyphicon glyphicon-map-marker"></i> Office: Perum Bukit Pratama, Jl. Gong Suling 2 No.10 Jimbaran, Kab. Badung, Kuta Selatan, Bali. Indonesia. .</p>
        <p><a class="hyperlink-footer" href="tel:+62-813-5330-4990" target="_top"><i class="glyphicon glyphicon-earphone"></i> +62-813-5330-4990</p></a>
        <p><a class="hyperlink-footer" href="mailto:reservation@gilitransfers.com" target="_top"><i class="glyphicon glyphicon-envelope"></i> reservation@gilitransfers.com</p></a>
        
      </div>
      <div class="col-md-3 col-sm-6 footer-col">
        <h6 class="heading7">Related Links</h6>
        <ul class="footer-ul">
          <li><?= Html::a('About Us', ['/about-us']); ?></li>
          <li><?= Html::a('How To Book', ['/site/how-to-book']); ?></li>
          <li><?= Html::a('Departing and Arriving', '#depart'); ?></li>
          <li><?= Html::a('Terms & Conditions', ['/content/terms-conditions']); ?></li>
          <li><?= Html::a('Privacy Policy', ['/content/privacy-policy']); ?></li>
          <li><?= Html::a('FAQ', ['/site/faq']); ?></li>
          <li><?= Html::a('Sitemap', '#'); ?></li>
          <li><?= Html::a('Website Feedback', '#feedback'); ?></li>
          
          
          
        </ul>
      </div>
      <div class="col-md-3 col-sm-6 footer-col">
        <h6 class="heading7">Places</h6>
        <div class="post footer-ul">
          <ul class="footer-ul">
          <li><?= Html::a('Bali', '#places'); ?></li>
          <li><?= Html::a('Lombok', '#places'); ?></li>
          <li><?= Html::a('Gili Air', '#places'); ?></li>
          <li><?= Html::a('Gili Meno', '#places'); ?></li>
          <li><?= Html::a('Gili Trawangan', '#places'); ?></li>
          <li><?= Html::a('Nusa Lembongan', '#places'); ?></li>
          <li><?= Html::a('Nusa Penida', '#places'); ?></li>
        </ul>
         
        </div>
      </div>
     <!--  <div class="col-md-3 col-sm-6 footer-col">
        <h6 class="heading7">Follow Us</h6>
        <ul class="footer-social">
          <li><a target="_blank" href="https://www.facebook.com/Gilitransferscom/"><i class="fa fa-facebook social-icon facebook" aria-hidden="true"></i></a></li>
          <li><a target="_blank" href="https://www.youtube.com/channel/UC_NtnHWVkbECkOqAB-2tWcA"><i class="fa fa-youtube social-icon youtube" aria-hidden="true"></i></a></li>
          <li><a target="_blank" href="https://plus.google.com/114019474249953149637"><i class="fa fa-google-plus social-icon google" aria-hidden="true"></i></a></li>
        </ul>
      </div> -->
       <div class="col-md-3 col-sm-6 footer-col">
        <h6 class="heading7">Payment Channel</h6>
        <ul class="footer-social">
          <li class="col-md-12 col-xs-12"><img id="paypal-logo" alt="payment-footer" class="img-footer img-responsive" src="/img/paypal.png"></li>
          <!-- <li class="col-md-12 col-xs-4"><img alt="payment-footer" class="img-footer img-responsive" src="/img/bank-mandiri.png"></li>
          <li class="col-md-12 col-xs-4"><img alt="payment-footer" class="img-footer img-responsive" src="/img/bank-bca.png"></li>
          <li class="col-md-12 col-xs-4"><img alt="payment-footer" class="img-footer img-responsive" src="/img/bank-permata.png"></li>
          <li class="col-md-12 col-xs-4"><img alt="payment-footer" class="img-footer img-responsive" src="/img/atm-bersama.png"></li> -->
        </ul>
      </div>
    </div>
  </div>
</footer>
<!--footer start from here-->

<div class="copyright">
  <div class="container">
    <div class="col-md-6">
      <p>© <?= date('Y') ?> Gilitransfers - All Rights Reserved</p>
    </div>
    <!--
    <div class="col-md-6">
      <ul class="bottom_ul">
        <li><a href="#">prabuuideveloper.com</a></li>
        <li><a href="#">About us</a></li>
        <li><a href="#">Blog</a></li>
        <li><a href="#">Faq's</a></li>
        <li><a href="#">Contact us</a></li>
        <li><a href="#">Site Map</a></li>
      </ul>
    </div>-->
  </div>
</div>


<?php 
$customCss = <<< SCRIPT
.hyperlink-footer{
  color: #FAFAFA;
}
.img-footer{
 
  padding-bottom: 10px;
}
#paypal-logo{
  min-width: 200px;
}
@import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700,300);
ul,li{
    padding:0;
    margin:0;
}
li{
    list-style-type:none;
}



footer { background-color:#0c1a1e; min-height:350px; font-family: 'Open Sans', sans-serif; }
.footer-col { margin-top:50px; }
.logofooter { margin-bottom:10px; font-size:25px; color:#fff; font-weight:700;}

.footer-col p { color:#fff; font-size:12px; font-family: 'Open Sans', sans-serif; margin-bottom:15px;}
.footer-col p i { width:20px; color:#999;}

.footer-ul { list-style-type:none;  padding-left:0; margin-left:2px;}
.footer-ul li { line-height:29px; font-size:12px;}
.footer-ul li a { color:#a0a3a4; transition: color 0.2s linear 0s, background 0.2s linear 0s; }
.footer-ul i { margin-right:10px;}
.footer-ul li a:hover {transition: color 0.2s linear 0s, background 0.2s linear 0s; color:#ff670f; }

 .copyright { min-height:40px; background-color:#000000;}
 .copyright p { text-align:left; color:#FFF; padding:10px 0; margin-bottom:0;}
 .heading7 { font-size:21px; font-weight:700; color:#d9d6d6; margin-bottom:22px;}
 .post p { font-size:12px; color:#FFF; line-height:20px;}
 .post p span { display:block; color:#8f8f8f;}
 .bottom_ul { list-style-type:none; float:right; margin-bottom:0;}
 .bottom_ul li { float:left; line-height:40px;}
 .bottom_ul li:after { content:"/"; color:#FFF; margin-right:8px; margin-left:8px;}
 .bottom_ul li a { color:#FFF;  font-size:12px;}
.social-icon {
    width: 30px;
    height: 30px;
    font-size: 15px;
    background-color: blue;
    color: #fff;
    text-align: center;
    margin-right: 10px;
    padding-top: 7px;
    border-radius: 50%;
}

 .linked-in{
     background-color:#007bb6;
 }
 .facebook{
     background-color:#3b5998;
 }
 .twitter{
     background-color:#1da1f2;
 }
 .google{
     background-color:#f63e28;
 }
SCRIPT;
$this->registerCss($customCss);
?>