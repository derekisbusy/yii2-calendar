<?php
namespace derekisbusy\calendar\widgets\fullcalendar;

use yii\base\Widget;
use yii\helpers\Html;
use yii\web\JsExpression;

class FullCalendarWidget extends Widget{
	public $pluginOptions=[];
	public $defaultPluginOptions=[];
	
	public function init(){
		parent::init();
        \derekisbusy\calendar\widgets\fullcalendar\FullCalendarAsset::register($this->view);
        \derekisbusy\calendar\widgets\fullcalendar\FullCalendarPrintAsset::register($this->view);
        $this->defaultPluginOptions=[
			'header' => [
				'left' => 'prev,next today',
				'center' => 'title',
				'right' => 'month,agendaWeek,agendaDay'
			],
			'editable' => true,
			'eventLimit' => true, // allow "more" link when too many events
            'snapDuration' => new JsExpression("moment.duration(1, 'minutes')"),
            'slotDuration' => new JsExpression("moment.duration(15, 'minutes')"),
            'minTime' => new JsExpression("moment.duration('09:00:00')"),
            'maxTime' => new JsExpression("moment.duration('22:00:00')"),
			'events' => [
				[
					'title' => 'All Day Event',
					'start' => '2015-02-01'
				],
				[
					'title' => 'Long Event',
					'start' => '2015-02-07',
					'end' => '2015-02-10'
				],
				[
					'id' => 999,
					'title' => 'Repeating Event',
					'start' => '2015-02-09T16:00:00'
				],
				[
					'id' => 999,
					'title' => 'Repeating Event',
					'start' => '2015-02-16T16:00:00'
				],
				[
					'title' => 'Conference',
					'start' => '2015-02-11',
					'end' => '2015-02-13'
				],
				[
					'title' => 'Click for Google',
					'url' => 'http://google.com/',
					'start' => '2015-02-28'
				],
                [
                    'title' => 'Meeting',
                    'start' => '2015-02-12T10:30:00',
                    'end' => '2015-02-12T12:32:00'
                ],
                [
                    'title' => 'Lunch',
                    'start' => '2015-02-12T12:00:00'
                ],
                [
                    'title' => 'Meeting',
                    'start' => '2015-02-12T14:30:00'
                ],
                [
                    'title' => 'Happy Hour',
                    'start' => '2015-02-12T17:30:00'
                ],
                [
                    'title' => 'Dinner',
                    'start' => '2015-02-12T20:00:00'
                ],
                [
                    'title' => 'Birthday Party',
                    'start' => '2015-02-13T07:00:00'
                ],
			]
		];
        $this->view->registerJs("jQuery('#".$this->getId()."').fullCalendar(".\yii\helpers\Json::encode(array_merge($this->defaultPluginOptions,$this->pluginOptions), JSON_UNESCAPED_SLASHES).");",
                \yii\web\View::POS_READY, 'calendar');
	}
	
	public function run(){
		return Html::tag('div','',['id'=>$this->getId()]);
	}
    
}
?>
