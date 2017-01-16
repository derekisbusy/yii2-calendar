<?php

namespace derekisbusy\calendar\backend\modules\calendar\controllers;

class DefaultController extends \yii\web\Controller
{
    
    public function behaviors()
    {
       return [
//           'access' => [
//               'class' => AccessControl::className(),
//           ],
       ];
    }
    
    public function actionIndex()
    {
        return $this->render('index');
    }
    
//    public function actionAppointment($ajax=false,$id=null)
//    {
//        if($id)
//            $appointment = \common\models\AppointmentForm::find()->where(['id'=>$id])->one();
//        else
//            $appointment = new \common\models\AppointmentForm;
//        if($ajax)
//            return $this->renderAjax('_form',['appointment'=>$appointment]);
//        else
//            return $this->render('update',['appointment'=>$appointment]);
//    }
    
    
    /**
     * ajax action that returns the calendar events between to dates
     * @param type $start
     * @param type $end
     * @return type
     */
    public function actionCalendarEvents($start,$end)
    {
        $result=[];
        foreach(\derekisbusy\calendar\models\Appointment::find()->between($start,$end)->each() as $appointment) {
            $patient=$appointment->patient;
            $result[]=['id'=>$appointment->id,'title'=>"{$patient->first_name} {$patient->last_name}",'allDay'=>false,
                    'start'=>date('c',strtotime($appointment->start_at)),'end'=>date('c',strtotime($appointment->end_at))];
            
        }
        return json_encode($result);
    }
    

}
