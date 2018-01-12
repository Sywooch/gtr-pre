<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

?>
<div class="notify successbox">
  <h1>Thank You</h1>
  <span class="alerticon"><img src="/thanks.png" alt="checkmark" /></span>
  <p><b>Your Booking Successful...!</b><br>Please check your email for further instructions, email may be in the spam folder, if you do not receive emails, please contact us via the following link,. Thank you for choosing gilitransfers, if any criticism and suggestions can you convey through the following link</p>
  <div class="row">
            <blockquote>
              <h4>ATTENTION !!!</h4>
              <small>
                Mohon selesaikan pembayaran sebelum <?= date('d-m-Y H:i:s',strtotime($modelPayment['exp'])) ?> WITA ( GMT +8 ). Apabila melewati batas waktu, pesanan Anda akan otomatis dibatalkan.
              </small>
            </blockquote>
          </div>
  <?= Html::a('Contact Us', ['/site/contact'], ['class' => 'btn material-btn material-btn_success main-container__column material-btn_lg']); ?>
  <?= Html::a('Go Home', ['/'], ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_lg']); ?>
   <?= Html::button('instructions', [
    'class'       => 'btn material-btn material-btn_primary main-container__column material-btn_lg',
    'data-toggle' => "modal",
    'data-target' => "#modal-instructions",
    'data-title'  => "Detail Data",
   ]); ?>
  </p> 
  <p>
    <small>copies of instructions also we send via email</small>
  </p>
</div>
<!--modal Start -->
<div class="modal material-modal material-modal_primary fade" id="modal-instructions">
  <div class="modal-dialog modal-lg">
    <div class="modal-content material-modal__content">
      <div class="modal-header material-modal__header">
        <button class="close material-modal__close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title material-modal__title"> INSTRUCTIONS </h4>
      </div>
      <div class="modal-body material-modal__body">
        <div class="row">
        <div class="col-md-12">
    
        <div class="row">
          
          <div class="col-md-12">
            <h3>Cara pembayaran via ATM BCA</h3>
            <ul class="list-group">
              <li class="list-group-item">
                Pada menu utama, pilih <b>Transaksi Lainnya</b>
              </li>
              <li class="list-group-item">
                Pilih <b>Transfer</b>
              </li>
              <li class="list-group-item">
                Pilih ke Rek <b>BCA Virtual Account</b>
              </li>
              <li class="list-group-item">
                Masukkan nomor <b><?= $modelPayment['bankTransfer']['va_number'] ?></b> lalu tekan <b>Benar</b>
              </li>
              <li class="list-group-item">
                Pada halaman konfirmasi transfer akan muncul detail pembayaran Anda. Jika informasi telah sesuai tekan <b>Ya</b>
              </li>
            </ul>
          </div>
          <div class="col-md-12">
            <h3>Cara pembayaran via Klik BCA</h3>
            <ul class="list-group">
              <li class="list-group-item">
                Pilih menu <b>Transfer Dana</b>
              </li>
              <li class="list-group-item">
                Pilih <b>Transfer ke BCA Virtual Account</b>
              </li>
              <li class="list-group-item">
                Masukkan nomor BCA Virtual Account <b><?= $modelPayment['bankTransfer']['va_number'] ?></b>
              </li>
              <li class="list-group-item">
                Jumlah yang akan ditransfer, nomor rekening dan nama merchant akan muncul di halaman konfirmasi pembayaran, jika informasi benar klik <b>Lanjutkan</b>
              </li>
              <li class="list-group-item">
                Masukkan respon KEYBCA APPLI 1 yang muncul pada Token BCA Anda, lalu klik tombol <b>Kirim</b>
              </li>
              <li class="list-group-item">
                Transaksi Anda selesai
              </li>
            </ul>
          </div>
          <div class="col-md-12">
            <h3>Cara pembayaran via m-BCA</h3>
            <ul class="list-group">
              <li class="list-group-item">
                Pilih <b>m-Transfer</b>
              </li>
              <li class="list-group-item">
                Pilih <b>Transfer</b>
              </li>
              <li class="list-group-item">
                Pilih <b>BCA Virtual Account</b>
              </li>
              <li class="list-group-item">
                Pilih nomor rekening yang akan digunakan untuk pembayaran
              </li>
              <li class="list-group-item">
                Masukkan nomor BCA Virtual Account <b><?= $modelPayment['bankTransfer']['va_number'] ?></b>, lalu pilih OK
              </li>
              <li class="list-group-item">
                Nomor BCA Virtual Account dan nomor Rekening Anda akan terlihat di halaman konfirmasi rekening
              </li>
              <li class="list-group-item">
                Pilih <b>OK</b> pada halaman konfirmasi pembayaran
              </li>
              <li class="list-group-item">
                Masukkan PIN BCA untuk mengotorisasi pembayaran
              </li>
              <li class="list-group-item">
                Transaksi Anda selesai
              </li>
            </ul>
          </div>
        
          </div>
        </div>
        </div>
      <div class="modal-footer material-modal__footer">
        <button id="btn-close-modal" type="button" class="btn material-btn material-btn_danger main-container__column material-btn_lg" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
</div>
<!--modal End -->

<?php

$customCss = <<< SCRIPT

::selection { background: #a4dcec; }
::-moz-selection { background: #a4dcec; }
::-webkit-selection { background: #a4dcec; }

::-webkit-input-placeholder { /* WebKit browsers */
  color: #ccc;
  font-style: italic;
}
:-moz-placeholder { /* Mozilla Firefox 4 to 18 */
  color: #ccc;
  font-style: italic;
}
::-moz-placeholder { /* Mozilla Firefox 19+ */
  color: #ccc;
  font-style: italic;
}
:-ms-input-placeholder { /* Internet Explorer 10+ */
  color: #ccc !important;
  font-style: italic;  
}

br { display: block; line-height: 2.2em; } 

article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section { display: block; }
ol, ul { list-style: none; }

input, textarea { 
  -webkit-font-smoothing: antialiased;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  outline: none; 
}

blockquote, q { quotes: none; }
blockquote:before, blockquote:after, q:before, q:after { content: ''; content: none; }
strong { font-weight: bold; } 

table { border-collapse: collapse; border-spacing: 0; }
img { border: 0; max-width: 100%; }

#topbar {
  background: #4f4a41;
  padding: 10px 0 10px 0;
  text-align: center;
}

#topbar a {
  color: #fff;
  font-size:1.3em;
  line-height: 1.25em;
  text-decoration: none;
  opacity: 0.5;
  font-weight: bold;
}

#topbar a:hover {
  opacity: 1;
}

/** typography **/
h1 {
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  font-size: 2.5em;
  line-height: 1.5em;
  letter-spacing: -0.05em;
  margin-bottom: 20px;
  padding: .1em 0;
  color: #444;
    position: relative;
	overflow: hidden;
	white-space: nowrap;
	text-align: center;
}
h1:before,
h1:after {
  content: "";
  position: relative;
  display: inline-block;
  width: 50%;
  height: 1px;
  vertical-align: middle;
  background: #f0f0f0;
}
h1:before {    
  left: -.5em;
  margin: 0 0 0 -50%;
}
h1:after {    
  left: .5em;
  margin: 0 -50% 0 0;
}
h1 > span {
  display: inline-block;
  vertical-align: middle;
  white-space: normal;
}

p {
  display: block;
  font-size: 1em;
  line-height: 1.5em;
  margin-bottom: 22px;
  text-align: justify;
}


/** page structure **/
#w {
  display: block;
  width: 750px;
  margin: 0 auto;
  padding-top: 30px;
}

#content {
  display: block;
  width: 100%;
  background: #fff;
  padding: 25px 20px;
  padding-bottom: 35px;
  -webkit-box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
  -moz-box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
  box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
}


.flatbtn {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  display: inline-block;
  outline: 0;
  border: 0;
  color: #f9f8ed;
  text-decoration: none;
  background-color: #b6a742;
  border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
  font-size: 1.2em;
  font-weight: bold;
  padding: 12px 22px 12px 22px;
  line-height: normal;
  text-align: center;
  vertical-align: middle;
  cursor: pointer;
  text-transform: uppercase;
  text-shadow: 0 1px 0 rgba(0,0,0,0.3);
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  -webkit-box-shadow: 0 1px 0 rgba(15, 15, 15, 0.3);
  -moz-box-shadow: 0 1px 0 rgba(15, 15, 15, 0.3);
  box-shadow: 0 1px 0 rgba(15, 15, 15, 0.3);
}
.flatbtn:hover {
  color: #fff;
  background-color: #c4b237;
}
.flatbtn:active {
  -webkit-box-shadow: inset 0 1px 5px rgba(0, 0, 0, 0.1);
  -moz-box-shadow:inset 0 1px 5px rgba(0, 0, 0, 0.1);
  box-shadow:inset 0 1px 5px rgba(0, 0, 0, 0.1);
}

/** notifications **/
.notify {
  display: block;
  background: #fff;
  padding: 12px 18px;
  max-width: 400px;
  margin: 0 auto;
  cursor: pointer;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;
  margin-bottom: 20px;
  box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 2px 0px;
}

.notify h1 { margin-bottom: 6px; }

.successbox h1 { color: #678361; }
.errorbox h1 { color: #6f423b; }

.successbox h1:before, .successbox h1:after { background: #cad8a9; }
.errorbox h1:before, .errorbox h1:after { background: #d6b8b7; }

.notify .alerticon { 
  display: block;
  text-align: center;
  margin-bottom: 10px;
}
SCRIPT;
$this->registerCss($customCss);
?>