<?php
use yii\helpers\Html;
?>
<div class="row">
  <div class="<?= $col ?>">
    <div class="dropdown material-dropdown material-dropdown_warning main-container__column">
      <button class="dropdown-toggle material-dropdown__btn" data-toggle="dropdown">
        <span id="btn-prices<?= $parent ?>">Low Prices</span>
        <span class="caret material-dropdown__caret "></span>
      </button>
      <ul class="dropdown-menu material-dropdown-menu material-dropdown-menu_warning">
        <li class="dropdown-header material-dropdown__header">Sort Prices</li>
        <li><?= Html::a('Low Prices',null, [
              'class' => 'material-dropdown-menu__link',
              'onclick'=>'
                $("#btn-prices'.$parent.'").text($(this).text());
                var mylist = $("#result-'.$parent.'");
                var listitems = mylist.children("div").get();
                listitems.sort(function(a, b) {
                  var compA = $(a).attr("price");
                  var compB = $(b).attr("price");
                  return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
                })
                $.each(listitems, function(idx, itm) {
                  mylist.append(itm);
                });
                '
              ]); ?></li>
            <li><?= Html::a('High Prices',null, [
              'class' => 'material-dropdown-menu__link',
              'onclick'=>'
                $("#btn-prices'.$parent.'").text($(this).text());
                var mylist = $("#result-'.$parent.'");
                var listitems = mylist.children("div").get();
                listitems.sort(function(a, b) {
                var compA = $(a).attr("price");
                var compB = $(b).attr("price");
                return (compA > compB) ? +1 : (compA < compB) ? 1 : 0;
                })
                $.each(listitems, function(idx, itm) {
                mylist.append(itm);
                });
                '
              ]); ?></li>
      </ul>
    </div>
  </div>
  <div class="<?= $col ?>">
    <div class="dropdown material-dropdown material-dropdown_warning main-container__column">
      <button class="dropdown-toggle material-dropdown__btn" data-toggle="dropdown">
        <span id="btn-times<?= $parent ?>">Dept Times</span>
        <span class="caret material-dropdown__caret "></span>
      </button>
      <ul class="dropdown-menu material-dropdown-menu material-dropdown-menu_warning">
        <li class="dropdown-header material-dropdown__header">Dept Times</li>
        <li><?= Html::a('Early Time',null, [
              'class' => 'material-dropdown-menu__link',
              'onclick'=>'
                $("#btn-times'.$parent.'").text($(this).text());
                var mylist = $("#result-'.$parent.'");
                var listitems = mylist.children("div").get();
                listitems.sort(function(a, b) {
                var compA = $(a).attr("times").toUpperCase();
                var compB = $(b).attr("times").toUpperCase();
                return (compA < compB) ? -1 : (compA > compB) ? 1 : 0;
                })
                $.each(listitems, function(idx, itm) {
                mylist.append(itm);
                });
                '
              ]); ?></li>
            <li><?= Html::a('End Time',null, [
              'class' => 'material-dropdown-menu__link',
              'onclick'=>'
                $("#btn-times'.$parent.'").text($(this).text());
                var mylist = $("#result-'.$parent.'");
                var listitems = mylist.children("div").get();
                listitems.sort(function(a, b) {
                var compA = $(a).attr("times").toUpperCase();
                var compB = $(b).attr("times").toUpperCase();
                return (compA > compB) ? +1 : (compA < compB) ? 1 : 0;
                })
                $.each(listitems, function(idx, itm) {
                mylist.append(itm);
                });
                '
              ]); ?></li>
      </ul>
    </div>
  </div>

    <div class="<?= $col ?>">
    <div class="dropdown material-dropdown material-dropdown_warning main-container__column">
      <button class="dropdown-toggle material-dropdown__btn" data-toggle="dropdown">
        <span id="filter-<?= $parent ?>">All <?= $parent ?> Port</span>
        <span class="caret material-dropdown__caret "></span>
      </button>
      <ul class="dropdown-menu material-dropdown-menu material-dropdown-menu_warning">
        <li class="dropdown-header material-dropdown__header"><?= $parent ?> Port</li>
          <li>
            <?= Html::a("All Ports",null, [
              'class' => 'material-dropdown-menu__link drop-item-'.$parent,
              'value' => '',
              'text'  => 'All Ports',
            ]); ?> 
          </li>
          <?php foreach($listRoute as $Route): ?>
          <li>
            <?= Html::a($Route['departureHarbor']['name'],null, [
              'class' => 'material-dropdown-menu__link drop-item-'.$parent,
              'value' => $Route['departure'],
              'text'  => $Route['departureHarbor']['name'],
            ]); ?> 
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>

</div>
<br>
<?php

$this->registerJs('
$(".drop-item-'.$parent.'").click(function() {
  var selectedPort'.$parent.' = $(this).attr("value");
  $("#filter-'.$parent.'").text($(this).attr("text"));
  var list'.$parent.' = $(".list-'.$parent.'").addClass("is-hidden");
  $("#loading-'.$parent.'").html("<img  class=\'img-loading img-responsive\' src=\'/loading.svg\'>");
  for (let word of [
    selectedPort'.$parent.'
  ]) {
    if (word) {
      console.warn(word);
      list'.$parent.' = list'.$parent.'.filter(function(i, el) {
        return $(el)
          .attr("'.$parent.'")
          .match(new RegExp(word,"i"));
      });
    }
  }
  list'.$parent.'.removeClass("is-hidden");
  $("#loading-'.$parent.'").html(" ");
});
  ', \yii\web\View::POS_READY);
?>