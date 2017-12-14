<?php 
if ($type == '1') {
  $head   = 'Reservation';
  $body   = 'Our reservation system has received an order for your Fast Boat transfer. Please confirm our booking below:';
  $footer = "Best Regards : ".Yii::$app->user->identity->username;
}else{
  $head   = 'Cancellation';
  $body   = 'Please cancel this booking below ';
  $footer = "Thank you for your kind understanding.<br><br> Best Regards : ".Yii::$app->user->identity->username;
} 
?>

<html><head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,width=device-width,height=device-height,target-densitydpi=device-dpi,user-scalable=no">
        <title>
          Fastboat <?= $head ?> GiliTransfers
          </title>
</head>
<body style="padding:0; margin:0; background:#f2f2f2;">  
      

<table class="marginFix" width="100%" cellspacing="0" cellpadding="0" border="0">
  <!-- GRAY BACKGROUND -->
  <tbody><tr>
    <td class="mobMargin" style="font-size:0px;" bgcolor="#f2f2f2"> </td>
    <td class="mobContent" width="660" bgcolor="#ffffff" align="center">
      <!-- inner container / place all modules below --> 
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <!-- BEGIN MAIN CONTENT -->
          <tbody><tr><td width="600" valign="top" align="center">
              <table width="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody><tr class="no_mobile_phone">
                <td style="padding-top:10px;" bgcolor="#f2f2f2"></td>
              </tr>
              <tr>
                <td style="padding-top:10px;" bgcolor="#f2f2f2"></td>
              </tr>
              <tr>
                <td valign="top" bgcolor="#ffffff" align="center">
                  <!-- PLACE ALL MODS BELOW --> 
                  <!-- PayPal logo - start -->
                    <table style="margin-bottom:10px; margin-top:15px;" width="100%" contenteditable="false" cellspacing="0" cellpadding="0" border="0">
                        <tbody><tr valign="bottom">    
                            <td style="border-bottom:2px solid black;" width="20" valign="top" align="center"> </td>
                            <td style="border-bottom:2px solid black;" height="64" align="left">
                                <img alt="Logo" style="width:85%; height:85%;" src="https://gilitransfers.com/img/logo.png" border="0"><br><br>
                            </td>   
                            <td style="border-bottom:2px solid black;" width="40" valign="top" align="center"> </td>
                            <td style="border-bottom:2px solid black;" align="right">
                                    <span style="padding-top:15px; padding-bottom:10px; font:italic 12px; Calibri, Trebuchet, Arial, sans serif; color: #757575;line-height:15px;"> 
                                        <!-- EmailContentHeader : start -->


<span style="display:inline;">
<br>
Date : <strong> <?= date('d-m-Y H:i') ?></strong><br><br>
</span>

<!-- EmailContentHeader : end -->
                                    </span>
                            </td>
                            <td style="border-bottom:2px solid black;" width="20" valign="top" align="center"> </td>
                        </tr>
                    </tbody></table>
                 <!-- PayPal logo - start -->
                <!-- body - start -->
                    <table style="padding-bottom:10px; padding-top:10px;margin-bottom: 20px;" width="100%" contenteditable="false" cellspacing="0" cellpadding="0" border="0">
                        <tbody><tr valign="bottom">    
                            <td width="20" valign="top" align="center"> </td>
                            <td style="font-family:Calibri, Trebuchet, Arial, sans serif; font-size:15px; line-height:22px; color:#333333;" class="ppsans" valign="top">
                                    <p><!-- EmailGreeting : start -->
<!-- EmailGreeting : end --></p>
<div style="margin-top: 10px;color:#333 !important;font-family: arial,helvetica,sans-serif;font-size:12px;">
<center><span style="font-size:15 ; font-weight:bold;text-decoration:none;">Fastboat <?= $head ?> GiliTransfers</span>
</center>
<table contenteditable="false">
<tbody>
<tr>
<td valign="bottom" align="justify">Dear Reservation Team <?= $modelBooking->idTrip->idBoat->idCompany->name ?> <p><?= $body ?></p><span style="display:inline;">
  </span></td>

  </tr>
  </tbody>
  </table>

<!-- Buyer Info Start -->
<table style="color:#333 !important;font-family: arial,helvetica,sans-serif;font-size:12px; margin-bottom:20px;" width="100%" contenteditable="false" cellspacing="0" cellpadding="0" border="0">
<tbody><tr style="border-bottom:2px solid #ccc;">
<td style="padding-top:5px;" width="50%" valign="top">
<span style="color:#333333;font-weight:bold; font-size:15px;">Customer/Buyer Information</span><br>

<span style="display:inline;">Name 
<br>
</span>


<span style="display:inline;">Email
<br>
</span>
<span style="display:inline;">Phone Number
<br>
</span>
</td>
<td style="padding-top:5px;padding-left:10px;" width="50%" valign="top">
<span style="color:#333333;"></span>
  <br>
<span style="display: inline;">
: <?= $modelPayment->name ?>
</span><br>
  <span style="display: inline;">
: <?= $modelPayment->email ?>
</span><br>
  <span style="display: inline;">
: <?= $modelPayment->phone ?>
</span>
</td>
</tr>


</tbody>
</table>
<!-- Buyer Info End -->
<table style="color:#333 !important;font-family: arial,helvetica,sans-serif;font-size:12px; margin-bottom:20px;" width="100%" contenteditable="false" cellspacing="0" cellpadding="0" border="0">
<caption style="text-align: left; font-size: 15px; font-weight: bold;">Trip Detail</caption>
<tbody>
  <tr>
    <td>
      <?= $modelBooking->idTrip->idRoute->departureHarbor->name." -> ".$modelBooking->idTrip->idRoute->arrivalHarbor->name." (".date('H:i',strtotime($modelBooking->idTrip->dept_time)).")" ?> 
      <?= date('d, F Y',strtotime($modelBooking->idTrip->date)) ?>
    </td>
  </tr>
</tbody>
</table>

<!-- Shuttle Start -->
<?php if(isset($modelBooking->tShuttles)): ?>

<table  style="color:#333 !important;font-family: arial,helvetica,sans-serif;font-size:12px; margin-bottom:20px;" width="100%" contenteditable="false" cellspacing="0" cellpadding="0" border="0">
  <caption style="text-align: left; font-size: 15px; font-weight: bold;"><?php if($modelBooking->idTrip->idRoute->departureHarbor->id_island == '1'){ echo 'Pickup';}else{ echo 'Drop Off';} ?>  Detail</caption>
  <thead>
  <tr>
    <th style="text-align: left;">Area</th>
    <th style="text-align: left;">Location</th>
    <th style="text-align: left;">Address</th>
    <th style="text-align: left;">Phone</th>
  </tr>

  </thead>
  <tbody>
 <tr>
    <td><?= $modelBooking->tShuttles->idArea->area ?></td>
    <td><?= $modelBooking->tShuttles->location_name ?></td>
    <td><?= $modelBooking->tShuttles->address ?></td>
    <td><?= $modelBooking->tShuttles->phone ?></td>
  </tr>
</tbody>
</table>
<?php endif; ?>
<!-- Shuttle End -->

<!-- Passenger Table Start -->
<table style="color:#333 !important;font-family: arial,helvetica,sans-serif;font-size:12px; margin-bottom:20px;" width="100%" contenteditable="false" cellspacing="0" cellpadding="0" border="0" class="table table-striped ">
  <caption style="text-align: left; font-size: 15px; font-weight: bold;">Passengers Detail</caption>
  <thead>
  <tr>
    <th width="40">No.</th>
    <th style="text-align: left;">Name</th>
    <th style="text-align: left;" width="175">Nationality</th>
    <th style="text-align: left;" width="100">Type</th>
  </tr>

  </thead>
  <tbody>
<?php foreach($modelBooking->tPassengers as $indexAdult => $valAdult): ?>
  <tr>
    <th scope="row"><?= $indexAdult+1 ?></th>
    <td><?= $valAdult->name?></td>
    <td><?= $valAdult->idNationality->nationality ?></td>
    <td><?= $valAdult->idType->type ?></td>

  </tr>
<?php endforeach;?>
</tbody>
</table>
<!-- Passenger Table End -->


<br>
Payment : Acc Gilitransfers<br>
<p>
<?= $footer ?>
</p>
<br>
Questions? Contact Us at <strong>reservation@Gilitransfers.com</strong><br><br>
 <li>Perum Permata Ariza Blok O/2 Mekarsari, Jimbaran. Bali - Indonesia.</li>
 <li>+62-813-5330-4990</li>
 <li><a id="button_text" style="text-decoration: none; font-size: 110%" class="applefix" href="Gilitransfers.com">https://Gilitransfers.com</a></li>
 <br></div><p></p>
                                <span style="font-weight:bold; color:#444;">
                                </span>
                                <span>
                                </span>
                            </td>
                            <td width="20" valign="top" align="center"> </td>
                        </tr>
                    </tbody></table>
                <!-- body - end -->
                  <!-- PLACE ALL MODS ABOVE -->
                </td>
              </tr>
            </tbody></table></td>
          <!-- END MAIN CONTENT -->           
       </tr></tbody></table>
      <!-- end inner container / place all modules above -->
      <!--  footer modules -->
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
          <!-- BEGIN FOOOTER CONTENT -->
          <tbody><tr><td width="600" valign="top" align="center">
              <table width="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody><tr>
                  <td style="padding-top:20px;" bgcolor="#f2f2f2"></td>
              </tr>
              <tr>
                <td valign="top" bgcolor="#f2f2f2" align="center">
                  <!-- PLACE ALL MODS BELOW --> 
                   <table width="100%" contenteditable="false" cellspacing="0" cellpadding="0" border="0">
                        <tbody><tr valign="bottom">   
                            <td>
                                <!--  footer links -->   
                                <table class="mobile_table_width_utility_nav" cellspacing="0" cellpadding="0" border="0" align="left">
                                   <tbody>
                                      <tr>
                                         <td class="ultility_nav_padding" style="font-family:Calibri, Trebuchet, Arial, sans serif; -webkit-font-smoothing: antialiased; font-size:13px; color:#666; font-weight:bold;">
                                            <span id="bottomLinks">
                                            </span>
                                         </td>
                                      </tr>
                                   </tbody>
                                </table>
                           </td>
                           <td width="20" valign="top" align="center"> </td>    
                        </tr>
                    </tbody></table>           
                     <table width="100%" contenteditable="false" cellspacing="0" cellpadding="0" border="0">
                        <tbody><tr valign="bottom">   
                            <td width="20" valign="top" align="center"> </td>
                            <td>
                                <span style="font-family:Calibri, Trebuchet, Arial, sans serif; font-size:13px; !important color:#8c8c8c;">  
                                    <!--  tracking -->
                                    <table id="emailFooter" style="padding-top:20px;font:12px Arial, Verdana, Helvetica, sans-serif;color:#292929;" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td>
                                    <p>Copyright © 2017 Gilitransfers.com. All rights reserved.</p>
                                   </td></tr></tbody></table>

                                </span>
                           </td>
                           <td width="20" valign="top" align="center"> </td>    
                        </tr>
                    </tbody></table>    
                  <!-- PLACE ALL MODS ABOVE -->
                </td>
              </tr>
            </tbody></table></td>
          <!-- END MAIN CONTENT -->           
       </tr></tbody></table>
    </td>
    <td class="mobMargin" style="font-size:0px;" bgcolor="#f2f2f2"> </td>
  </tr>
  <!-- END GRAY BACKGROUND -->
</tbody></table>
<!-- END CONTAINER -->

<style type="text/css"> 
/* PP Sans Font Import */

/* PP Sans Class */
.ppsans {
    font-family: 'pp-sans-big-light', 'Noto Sans', Calibri, Trebuchet, Arial, sans serif !important;
}
.ppsansbold {
    font-family: 'pp-sans-big-bold', 'Noto Sans', Calibri, Trebuchet, Arial, sans serif !important;
}
/* prevent iOS font upsizing */
* {
    -webkit-text-size-adjust: none;
}
/* force Outlook.com to honor line-height */
/*
.ExternalClass * {
    line-height: 100%;
}
td {
    mso-line-height-rule: exactly;
}
*/
/* prevent iOS auto-linking */

/* Android margin fix */
body {
    margin: 0 !important;
}
div[style*="margin: 16px 0"] {
    margin: 0 !important;
}
/** Prevent Outlook Purple Links **/
.greyLink a:link {
    color: #949595;
}
/* prevent iOS auto-linking */
.applefix a { /* use on a span around the text */
    color: inherit;
    text-decoration: none;
}
.partner_image {
 max-width: 250px !important;
 max-height: 90px !important;
 display: block;
}
.mpi_image {
  width: 98% !important;
  display: block;
  margin-left: auto;
  margin-right: auto;
}

/*** Responsive CSS ***/
@media only screen and (max-width: 414px) {
/*** Layout ***/
body {
    width: 100%;
    min-width: 100%;
    position: relative;
    top: 0;
    left: 0;
    right: 0;
    margin: 0;
    padding: 0;
}
.marginFix {
    position: relative;
    top: 0;
    left: 0;
    right: 0;
}
.mobContent {
    width: 100% !important;
    min-width: 100% !important;
    padding: 0px 0px 0px 0px !important;
}
/*.mobMargin { width: 10% !important; }*/
.hide {
    width: 0px !important;
    height: 0px !important;
    display: none !important;
}
.full-width {
    width: 100% !important;
    min-width: 100% !important;
}
.stackTbl {
    width: 100% !important;
    display: table !important;
}
.stackTblMarginTop {
    width: 100% !important;
    display: table !important;
    margin-top: 20px !important;
}
.center {
    margin: 0px auto !important;
}
.floatLeft {
    float: left !important;
    width: 35% !important;
}
.floatRight {
    float: right !important;
    width: 60% !important;
}
.autoHeight {
    height: auto !important;
}
.autoWidth {
    width: auto !important;
}
/*** Padding Styles ***/
.mobilePadding {
    padding: 20px 20px 20px 20px !important;
}
.mobilePadding1 {
    padding: 40px 20px 40px 20px !important;
    height: auto !important;
}
.mobilePadding2 {
    padding: 0px 20px 40px 20px !important;
}
.mobilePadding3 {
    padding: 20px 20px 0px 20px !important;
}
.mobilePadding4 {
    padding: 0px 0px 30px 0px !important;
}
.mobilePadding5 {
    padding: 0px 20px 30px 20px !important;
}
.mobilePadding6 {
    padding: 30px 20px 30px 20px !important;
}
.mobilePadding7 {
    padding: 0px 20px 0px 20px !important;
}
.mobilePadding8 {
    padding: 50px 0px 50px 0px !important;
}
.mobilePadding9 {
    padding: 10px 0px 15px 0px !important;
}
.mobilePadding10 {
    padding: 0px 20px 0px 20px !important;
}
.mobilePadding11 {
    padding: 40px 0px 40px 0px !important;
}
.mobilePadding12 {
    padding: 40px 0px 0px 0px !important;
}
.mobilePadding13 {
    padding: 0px 0px 40px 0px !important;
}
.mobilePadding14 {
    padding: 40px 30px 10px 30px !important;
}
.mobilePadding15 {
    padding: 0px 30px 0px 30px !important;
}
.mobilePadding16 {
    padding: 0px 0px 10px 0px !important;
}
.padding0 {
    padding: 0px !important;
}
.topPadding0 {
    padding-top: 0px !important;
}
.topPadding10 {
    padding-top: 10px !important;
}
.topPadding20 {
    padding-top: 20px !important;
}
.topPadding30 {
    padding-top: 30px !important;
}
.topPadding40 {
    padding-top: 40px !important;
}
.bottomPadding0 {
    padding-bottom: 0px !important;
}
.bottomPadding10 {
    padding-bottom: 10px !important;
}
.bottomPadding20 {
    padding-bottom: 20px !important;
}
.bottomPadding30 {
    padding-bottom: 30px !important;
}
.bottomPadding40 {
    padding-bottom: 40px !important;
}
/* use to make image scale to 100 percent */
.fullWidthImg {
    width: auto !important;
    height: auto !important;
}
.fullWidthImg img {
    width: auto !important;
    height: auto !important;
}
.mobile_hero_width {
    width: auto !important;
    height: auto !important;
}

/*** Border Styles ***/
.borderBottomDot {
    border-bottom: 1px dotted #999999 !important;
}
/*** Text Align Styles ***/
.textAlignLeft {
    text-align: left !important;
}
.textAlignRight {
    text-align: right !important;
}
.textAlignCenter {
    text-align: center !important;
}
/*** Misc Styles ***/
.mobileStrong {
    font-weight: bold !important;
}
/*** Width Styles ***/
.td150px {
    width: 150px !important;
}
.td130px {
    width: 130px !important;
}
.td120px {
    width: 120px !important;
}
.td100px {
    width: 100px !important;
}
/*** Image Width Styles ***/
.imgWidth10px {
    width: 10px !important;
}

.no_mobile_phone {
    display: none !important;
}
/*** END Responsive CSS ***/
}

#button_text a {
    text-decoration: none;
    color: #fff;
}

.button_blue{
    background: #0079c1;
        font-family:HelveticaNeueLight,HelveticaNeue-Light,Helvetica Neue Light,HelveticaNeue,Helvetica,Arial,sans-serif;
        font-weight:300;
        font-stretch:normal;
        text-align:center;
        color:#fff;
        font-size:15px;
        /*button styles*/
        border-radius:7px !important;
        -webkit-border-radius: 7px !important;
        -moz-border-radius: 7px !important;
        -o-border-radius: 7px !important;
        -ms-border-radius: 7px !important;
        /*styles from button.jsp */ line-height: 1.45em; padding: 7px 15px 8px; font-size: 1em;
         padding-bottom: 7px; margin: 0 auto 16px;
}
.button_orange{
    background: #FF3421;
        /*font styles*/font-family:HelveticaNeueLight,HelveticaNeue-Light,Helvetica Neue Light,HelveticaNeue,Helvetica,Arial,sans-serif;
        font-weight:300;
        font-stretch:normal;
        text-align:center;
        color:#fff;
        font-size:15px;
        /*button styles*/
        border-radius:7px !important;
        -webkit-border-radius: 7px !important;
        -moz-border-radius: 7px !important;
        -o-border-radius: 7px !important;
        -ms-border-radius: 7px !important;
        /*styles from button.jsp */ line-height: 1.45em; padding: 7px 15px 8px; font-size: 1em;
         padding-bottom: 7px; margin: 0 auto 16px;
}

.button_grey{
    background: #E0E0E0;
        /*font styles*/font-family:HelveticaNeueLight,HelveticaNeue-Light,Helvetica Neue Light,HelveticaNeue,Helvetica,Arial,sans-serif;
        font-weight:300;
        font-stretch:normal;
        text-align:center;
        color:#fff;
        font-size:15px;
        /*button styles*/
        border-radius:7px !important;
        -webkit-border-radius: 7px !important;
        -moz-border-radius: 7px !important;
        -o-border-radius: 7px !important;
        -ms-border-radius: 7px !important;
        /*styles from button.jsp */ line-height: 1.45em; padding: 7px 15px 8px; font-size: 1em;
         padding-bottom: 7px; margin: 0 auto 16px;
}

*[class=button_style] {
    border-radius: 7px !important;
    -webkit-border-radius: 7px !important;
    -moz-border-radius: 7px !important;
    -o-border-radius: 7px !important;
    -ms-border-radius: 7px !important;
}
*[class=button_style]:active {
    background: #008bdb !important;
}
*[class=button_style]:hover {
    background: #008bdb !important;
}

/* A basic table styling */
.aloha-ephemera-attr 
{
  width: 100%;
  cellspacing: 0px;
  cellpadding: 0px;
  border-top: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
  -moz-hyphens : auto;
  -ms-word-break: break-all;
  word-break: break-all;
  word-break: break-word; 
  -webkit-hyphens: auto;
  -moz-hyphens: auto;
  hyphens: auto;
}

.aloha-ephemera-attr th
{
  background-color: #EEE;  
  border-bottom: 1px solid #ddd;
  border-right: 1px solid #ddd;
  border-left: 1px solid #ddd;
  border-collapse: collapse;
}

.aloha-ephemera-attr td
{

}


        
   body, td { font-family:Calibri, Trebuchet, Arial, sans serif; font-size:16px; line-height:22px; color:#333333; font-weight:normal;}     
   td.ultility_nav_padding a {
   color: #009cde;
   font-weight: normal;
   text-decoration: none;
   font-family: Calibri, Trebuchet, Arial, sans serif;
   font-size: 17px;
   } 
   td.column_split_preheader a {
   color: #009cde;
   font-weight: normal;
   text-decoration: underline;
   font-family: Calibri, Trebuchet, Arial, sans serif;
   font-size: 17px;
   }
   a {
   color:#009cde;
   font-weight: 300;
   text-decoration: none;
   font-family: Calibri, Trebuchet, Arial, sans serif;
   font-size: 17px;
   }
   .headline{color: #0079c1; font-family: Helvetica Neue Light,Helvetica;font-size: 30px; font-weight: 300 !important;}
   .text_lightblue_header { font-family:Calibri, Trebuchet, Arial, sans serif; font-size:36px; line-height:44px; color:#0079c1; -webkit-font-smoothing: antialiased; }
</style>  
</body></html>