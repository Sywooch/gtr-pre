<?php
namespace common\components;

use yii\base\Component;
use common\models\TBooking;
use common\models\TCart;
use common\models\TContent;
use yii\helpers\Html;
use Yii;


class Gilitransfers extends Component{
	public $content;
	
	public function init(){
		parent::init();
		//$this->content= 'Hello Yii 2.0';
	}
	
	public function Valbook(){
		return count(TBooking::find()->joinWith('idPayment')->where(['t_payment.id_payment_method'=>2])->andWhere(['between','t_booking.id_status',2,3])->all());
	}

	public function Countcart(){
		 $session       = Yii::$app->session;
        return count(TCart::find()->where(['session_key'=>$session['session_key']])->all());

	}
	public function LatestPost(){
		$LatestPost = TContent::find()->orderBy(['updated_at'=>SORT_DESC])->limit(3)->all();
		foreach ($LatestPost as $key => $value) {
			echo "<li><a href=\"/view/".$value->slug."\">".$value->title."</a><br><span>".date('F d,Y',$value->updated_at)."</span></li>";
          
		}
	}
	public function trackFrontendVisitor(){
		
	}
	
}
?>