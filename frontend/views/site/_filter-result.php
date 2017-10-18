<?php
use yii\helpers\Html;
?>
<div class="row">
  <div class="<?= $col ?>">
    <div class="dropdown material-dropdown material-dropdown_warning main-container__column">
      <button class="dropdown-toggle material-dropdown__btn" data-toggle="dropdown">
        <span id="btn-prices<?= $parent ?>">Sort Prices</span>
        <span class="caret material-dropdown__caret "></span>
      </button>
      <ul class="dropdown-menu material-dropdown-menu material-dropdown-menu_warning">
        <li class="dropdown-header material-dropdown__header">Sort Prices</li>
        <li><?= Html::a('Low Prices',null, [
              'class' => 'material-dropdown-menu__link',
              'onclick'=>'
                $("#btn-prices'.$parent.'").text($(this).text());
                var mylist = $("#'.$parent.'");
                var listitems = mylist.children("div").get();
                listitems.sort(function(a, b) {
                var compA = $(a).attr("id").toUpperCase();
                var compB = $(b).attr("id").toUpperCase();
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
                var mylist = $("#'.$parent.'");
                var listitems = mylist.children("div").get();
                listitems.sort(function(a, b) {
                var compA = $(a).attr("id").toUpperCase();
                var compB = $(b).attr("id").toUpperCase();
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
                var mylist = $("#'.$parent.'");
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
                var mylist = $("#'.$parent.'");
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
        <span id="btn-durations<?= $parent ?>">Duration</span>
        <span class="caret material-dropdown__caret "></span>
      </button>
      <ul class="dropdown-menu material-dropdown-menu material-dropdown-menu_warning">
        <li class="dropdown-header material-dropdown__header">Duration</li>
        <li><?= Html::a('Fastest',null, [
              'class' => 'material-dropdown-menu__link',
              'onclick'=>'
                $("#btn-durations'.$parent.'").text($(this).text());
                var mylist = $("#'.$parent.'");
                var listitems = mylist.children("div").get();
                listitems.sort(function(a, b) {
                var durA = $(a).attr("duration").toUpperCase();
                var durB = $(b).attr("duration").toUpperCase();
                return (durA < durB) ? -1 : (durA > durB) ? 1 : 0;
                })
                $.each(listitems, function(idx, itm) {
                mylist.append(itm);
                });
                '
              ]); ?></li>
            <li><?= Html::a('Longest',null, [
              'class' => 'material-dropdown-menu__link',
              'onclick'=>'
                $("#btn-durations'.$parent.'").text($(this).text());
                var mylist = $("#'.$parent.'");
                var listitems = mylist.children("div").get();
                listitems.sort(function(a, b) {
                var durA = $(a).attr("duration").toUpperCase();
                var durB = $(b).attr("duration").toUpperCase();
                return (durA > durB) ? +1 : (durA < durB) ? 1 : 0;
                })
                $.each(listitems, function(idx, itm) {
                mylist.append(itm);
                });
                '
              ]); ?></li>
      </ul>
    </div>
  </div>

</div>
<br>