<?php

namespace derekisbusy\calendar\backend\modules\calendar;

/**
 * calendar module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'derekisbusy\calendar\backend\modules\calendar\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    
    public static function getUserClassname()
    {
        return 'dektrium\user\models\User';
    }
    
    public static function getUserModelIdName()
    {
        return 'id';
    }
    
    public static function getUserModelUsernameColumnName()
    {
        return 'username';
    }
    
    public static function getUserTableName()
    {
        return call_user_func(self::getUserClassname().'::tableName');
    }
    
    public static function getUser($id = null)
    {
        return call_user_func(self::getUserClassname().'::find');
    }
    
    public static function hasRole($roleName,$userId=null)
    {
        $auth = \Yii::$app->authManager;
        if($userId==null) {
            if (\Yii::$app->user->isGuest) {
                return false;
            }
            $userId = \Yii::$app->user->identity->id;
        }
        $roles = $auth->getRolesByUser($userId);
        foreach($roles as $role) {
            if ($role->name == $roleName) {
                return true;
            }
        }
        return false;
    }
    
    public function weekly($rule)
    {
        $day = $rule->schedule->min_advance_schedule;
        do {
            //Y-m-d H:i:s
//            $t = strtotime(;
            
            $date = new DateTime("+{$day} days");
            
            if (!$rule->isDayOfWeek($date)) {
                continue;
            }
            
            $start = clone $date;
            $end = clone $date;
            
            
            $start->setTime($rule->getStartHour(), $rule->getStartMinute());
            // make sure start time is rounded to nearst 15 minute.
//            $start->setTime($date->format("G"), $start->format("i") % 15);
            
            while($start->getTimestamp() < $end->getTimestamp())
            {
                foreach ($rule->schedule->getTypes() as $type) {
                    
                }
                $slot = new ScheduleTimeSlot();
                $slot->start_at = date("Y-m-d H:i:s", $start->getTimestamp());
                $slot->end_at = date("Y-m-d H:i:s", $end->getTimestamp());
            }
            
        } while($days <= $rule->schedule->max_advance_schedule);
    }
    
}
