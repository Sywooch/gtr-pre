<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
//use rmrevin\yii\fontawesome\AssetBundle;

/* @var $this yii\web\View */
$this->title = 'Fast Boat and Flight Transfers Bali to Gili Island / Lombok / Nusa Lembongan';

?>
 <div class="row"> 
<div class="col-md-9">
      <div class="panel-group material-tabs-group">
      <h4 class="panel-heading">Booking Form</h4>
        <ul class="nav nav-tabs material-tabs material-tabs_primary">
          <li class="active"><a href="#fastboats" class="material-tabs__tab-link" data-toggle="tab">Fastboats</a></li>
          <li><a href="#hotels" class="material-tabs__tab-link" data-toggle="tab">Hotels</a></li>
        </ul>
        <div class="tab-content materail-tabs-content">
          <div class="tab-pane book-form fade active in" id="fastboats">
            <div class="row"> 

            <?= $this->render('_form-fastboat.php',[
            'modelBookForm'=>$modelBookForm,
            'listDept'=>$listDept,
            'session'=>$session,
            'adultList'=>$adultList,
            'childList'=>$childList,
            'listCurrency'=>$listCurrency,
            ])?>
            </div>
          </div>
          <div class="tab-pane book-form fade" id="hotels">
           <div class="row"> 
            <?= $this->render('_form-hotels.php',[
            'modelHotel'=>$modelHotel,
            
            ])?>
            </div>
          </div>
        </div>
      </div>
</div>
<div class="col-md-3">
  <div class="panel panel-default material-panel material-panel_primary">
    <h5 class="panel-heading material-panel__heading">Contact Us</h5>
    <div class="panel-body material-panel__body">
      <div class="row">
          <p><span class="fa fa-phone"> </span> +62-813-5330-4990<br></p>
          <p><span class="fa fa-envelope"> </span> reservation@gilitransfers.com</p>
          <img id="payment-logo" alt="payment-logo" src="/img/paypal.png">
      </div>
    </div>
  </div>
</div>
</div>
  <div class="panel-group material-tabs-group">
        <ul class="nav nav-tabs material-tabs material-tabs_primary">
          <li class="active bar"><a href="#fastboat" class="material-tabs__tab-link" data-toggle="tab">FastBoat</a></li>
          <li class="bar"><a href="#destinations" class="material-tabs__tab-link" data-toggle="tab">Dest</a></li>
          <li class="bar"><a href="#article" class="material-tabs__tab-link" data-toggle="tab">Article</a></li>
          <li class="bar"><a href="#ports" class="material-tabs__tab-link" data-toggle="tab">Ports</a></li>
        </ul>   
        <div class="tab-content materail-tabs-content">
          
            <div class="tab-pane art-tab fade active in" id="fastboat">
            <div class="row"> 
            <?php if(!empty($listBoats)): ?>
          <?php foreach ($listBoats as $keyAr => $valBoat): ?>
            <div class="col-md-6">
              <div class="list-fastboat panel panel-default material-panel">
                <div class="panel-body material-panel__body">
                  <div class="media material-media">
                          <div id="div-<?= $valBoat['slug'] ?>" class="media-left material-media__column material-media__column_vertical-middle">
                              <?=  Html::a(Html::img('/loading.svg', [
                                    'class' => 'media-object material-media__object material-media__object_lg',
                                    'alt'=>'thumbnail'.$valBoat['slug'],
                                    'id'=>$valBoat['slug'],
                                    
                                    ]), '/fast-boats/'.$valBoat['slug'].''); ?>
                              <?php 
                              $this->registerJs('
                                $.ajax({
                                  url: "'.Url::to(["/content/ajax-thumbnail"]).'",
                                  type: "GET",
                                  data : {slug: "'.$valBoat["slug"].'"},
                                  success: function(data){
                                    $("#div-'.$valBoat['slug'].'").html(data);
                                  }
                                });

                              ', \yii\web\View::POS_READY); ?>
                          </div>
                          <div class="media-body">
                          <h4 class="media-heading"><?= $valBoat['title'] ?></h4>
                          <p><?= substr($valBoat['description'],0,100) ?></p>
                          <div class="clearfix"></div>
                          <div class="btn-group" role="group" id="BegeniButonlari">
                               <?= Html::a(' Read  More ', '/fast-boats/'.$valBoat["slug"].'', ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_md glyphicon glyphicon-arrow-right']); ?>
                              
                          </div>                 
                         </div>
                      </div>
                  </div>
              </div>
           </div>
          <?php endforeach; ?>
           <?php else: ?>
            <h3>Fastboat is Unavaible</h3>
  
          <?php endif; ?>
          </div>
        </div>
         
          <div class="tab-pane art-tab fade" id="destinations">
            <div class="row">
            <?php
            if(!empty($listDestinations)):
            foreach ($listDestinations as $keyAr => $valDestination): ?>
            <div class="col-md-6">
              <div class="list-fastboat panel panel-default material-panel">
                <div class="panel-body material-panel__body">
                  <div class="media material-media">
                          <div id="div-<?= $valDestination['slug'] ?>" class="media-left material-media__column material-media__column_vertical-middle">
                              <?=  Html::a(Html::img('/loading.svg', [
                                    'class' => 'media-object material-media__object material-media__object_lg',
                                    'alt'=>'thumbnail'.$valDestination['slug'],
                                    'id'=>$valDestination['slug'],
                                    
                                    ]), '/fast-boats/'.$valDestination['slug'].''); ?>
                              <?php 
                              $this->registerJs('
                                $.ajax({
                                  url: "'.Url::to(["/content/ajax-thumbnail"]).'",
                                  type: "GET",
                                  data : {slug: "'.$valDestination["slug"].'"},
                                  success: function(data){
                                    $("#div-'.$valDestination['slug'].'").html(data);
                                  }
                                });

                              ', \yii\web\View::POS_READY); ?>
                          </div>
                          <div class="media-body">
                          <h4 class="media-heading"><?= $valDestination['title'] ?></h4>
                          <p><?= substr($valDestination['description'],0,100) ?></p>
                          <div class="clearfix"></div>
                          <div class="btn-group" role="group" id="BegeniButonlari">
                               <?= Html::a(' Read  More ', '/destinations/'.$valDestination['slug'].'', ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_md glyphicon glyphicon-arrow-right']); ?> 
                              
                          </div>                 
                         </div>
                      </div>
                  </div>
              </div>
     </div>
          <?php endforeach; ?>
          <?php else: ?>
            <h3>Content For this section is Unavaible</h3>
  
          <?php endif; ?>
          </div>
          </div>

           <div class="tab-pane art-tab fade" id="article">
            <div class="row">
            <?php
            if(!empty($listArticle)):
            foreach ($listArticle as $keyAr => $valArticle): ?>
            <div class="col-md-6">
              <div class="list-fastboat panel panel-default material-panel">
                <div class="panel-body material-panel__body">
                  <div class="media material-media">
                          <div id="div-<?= $valArticle['slug'] ?>" class="media-left material-media__column material-media__column_vertical-middle">
                              <?=  Html::a(Html::img('/loading.svg', [
                                    'class' => 'media-object material-media__object material-media__object_lg',
                                    'alt'=>'thumbnail'.$valArticle['slug'],
                                    'id'=>$valArticle['slug'],
                                    
                                    ]), '/fast-boats/'.$valArticle['slug'].''); ?>
                              <?php 
                              $this->registerJs('
                                $.ajax({
                                  url: "'.Url::to(["/content/ajax-thumbnail"]).'",
                                  type: "GET",
                                  data : {slug: "'.$valArticle["slug"].'"},
                                  success: function(data){
                                    $("#div-'.$valArticle['slug'].'").html(data);
                                  }
                                });

                              ', \yii\web\View::POS_READY); ?>
                          </div>
                          <div class="media-body">
                          <h4 class="media-heading"><?= $valArticle['title'] ?></h4>
                          <p><?= substr($valArticle['description'],0,100) ?></p>
                          <div class="clearfix"></div>
                          <div class="btn-group" role="group" id="BegeniButonlari">
                               <?= Html::a(' Read  More ', '/articles/'.$valArticle['slug'], ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_md glyphicon glyphicon-arrow-right']); ?> 
                              
                          </div>                 
                         </div>
                      </div>
                  </div>
              </div>
     </div>
          <?php endforeach; ?>
          <?php else: ?>
            <h3>Article is Unavaible</h3>
  
          <?php endif; ?>
          </div>
          </div>

          <div class="tab-pane art-tab fade" id="ports">
            <div class="row">
            <?php
            if(!empty($listPorts)):
            foreach ($listPorts as $keyAr => $valPorts): ?>
            <div class="col-md-6">
              <div class="list-fastboat panel panel-default material-panel">
                <div class="panel-body material-panel__body">
                  <div class="media material-media">
                         <div id="div-<?= $valPorts['slug'] ?>" class="media-left material-media__column material-media__column_vertical-middle">
                              <?=  Html::a(Html::img('/loading.svg', [
                                    'class' => 'media-object material-media__object material-media__object_lg',
                                    'alt'=>'thumbnail'.$valPorts['slug'],
                                    'id'=>$valPorts['slug'],
                                    ]), '/fast-boats/'.$valPorts['slug'].''); ?>
                              <?php 
                              $this->registerJs('
                                $.ajax({
                                  url: "'.Url::to(["/content/ajax-thumbnail"]).'",
                                  type: "GET",
                                  data : {slug: "'.$valPorts["slug"].'"},
                                  success: function(data){
                                    $("#div-'.$valPorts['slug'].'").html(data);
                                  }
                                });

                              ', \yii\web\View::POS_READY); ?>
                          </div>
                          <div class="media-body">
                          <h4 class="media-heading"><?= $valPorts['title'] ?></h4>
                          <p><?= substr($valPorts['description'],0,100) ?></p>
                          <div class="clearfix"></div>
                          <div class="btn-group" role="group" id="BegeniButonlari">
                               <?= Html::a(' Read  More ', '/ports/'.$valPorts['slug'], ['class' => 'btn material-btn material-btn_warning main-container__column material-btn_md glyphicon glyphicon-arrow-right']); ?> 
                              
                          </div>                 
                         </div>
                      </div>
                  </div>
              </div>
     </div>
          <?php endforeach; ?>
          <?php else: ?>
            <h3>Article is Unavaible</h3>
  
          <?php endif; ?>
          </div>
          </div>

        </div>
        <?php if(!empty($keywordPuller)): ?>
       <div class="panel panel-default material-panel material-panel_primary">
      <h5 class="panel-heading material-panel__heading"><?= $keywordPuller['title'] ?></h5>
      <div class="panel-body material-panel__body">
        <?= $keywordPuller['content'] ?>
      </div>
      </div>
      <?php 
      $this->registerMetaTag([
          'name' => 'description',
          'content' => $keywordPuller['description'],
      ]);
      $this->registerMetaTag([
          'name' => 'keywords',
          'content' => $keywordPuller['keywords'],
      ]);
       ?>
    <?php else: 
      $this->registerMetaTag([
          'name' => 'description',
          'content' => 'Transfer from Bali to Gili Trawangan, Gili Air, Gili Meno, and Lombok by Fast Boat or Flight. Easy online booking. Pay in your currency and save money.',
      ]);
      $this->registerMetaTag([
          'name' => 'keywords',
          'content' => 'from bali to lombok, from bali to gili, travel to lombok, boat to gili, from bali to gili islands, fly to lombok, bali to gili trawangan, ferry from bali to lombok, flight from bali to lombok, fast boat to gili, gili fast boat, from bali to nusa lembongan',
      ]);
    ?>
    <?php endif; ?>
      </div>

        
<?php 
$customCss = <<< SCRIPT
#payment-logo{
  height: 90px;
  width: 250px;
}
h4, .panel-heading{
  text-align: center;
}
p{
  text-align: justify;
}
.bar{
  width : 150px;
}
#list-fastboat{
  min-height: 175px;
  max-height: 175px;
}
.art-tab{
  min-height: 390px;
}
.book-form{
  min-height: 205px;
}
#btn-scroll {
    position:fixed;
    right:10px;
    bottom:100px;
    cursor:pointer;
    width:50px;
    height:50px;
    background-color:#3498db;
    text-indent:-9999px;
    display:none;
    -webkit-border-radius:60px;
    -moz-border-radius:60px;
    border-radius:60px
}
#btn-scroll span {
    position:absolute;
    top:50%;
    left:50%;
    margin-left:-8px;
    margin-top:-12px;
    height:0;
    width:0;
    border:8px solid transparent;
    border-bottom-color:#ffffff;
}
#btn-scroll:hover {
    background-color:#e74c3c;
    opacity:1;filter:"alpha(opacity=100)";
    -ms-filter:"alpha(opacity=100)";
}
SCRIPT;
$this->registerCss($customCss);

?>