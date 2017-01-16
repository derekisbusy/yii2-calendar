<?php

namespace derekisbusy\calendar\models;

use DateTime;
use derekisbusy\calendar\backend\modules\calendar\Module;
use derekisbusy\calendar\models\base\ScheduleAppointmentType;
use derekisbusy\calendar\models\ScheduleRule;
use derekisbusy\calendar\models\base\TimeSlot;
use Yii;

/**
 * This is the model class for table "{{%schedule}}".
 *
 * @property integer $id
 * @property string $user_id
 * @property integer $status
 * @property string $min_advance_schedule
 * @property string $max_advance_schedule
 * @property integer $max_daily_appointments
 * @property integer $max_weekly_appointments
 * @property integer $require_confirmation
 *
 * @property User $user
 * @property ScheduleRule[] $scheduleRules
 */
class Schedule extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    
    const CONFIRM_NONE = 0;
    const CONFIRM_EMAIL = 1;
    const CONFIRM_PHONE = 2;
    
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%calendar_schedule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'min_advance_schedule', 'max_advance_schedule', 'max_daily_appointments', 'max_weekly_appointments', 'require_confirmation'], 'required'],
            [['user_id', 'status', 'min_advance_schedule', 'max_advance_schedule', 'max_daily_appointments', 'max_weekly_appointments', 'require_confirmation'], 'integer'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::getUserClassname(), 'targetAttribute' => Module::getUserModelIdName()],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'user_id' => Yii::t('common', 'User ID'),
            'status' => Yii::t('common', 'Status'),
            'min_advance_schedule' => Yii::t('calendar', 'Min Advance Schedule'),
            'max_advance_schedule' => Yii::t('calendar', 'Max Advance Schedule'),
            'max_daily_appointments' => Yii::t('calendar', 'Max Daily Appointments'),
            'max_weekly_appointments' => Yii::t('calendar', 'Max Weekly Appointments'),
            'require_confirmation' => Yii::t('calendar', 'Require Confirmation'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Module::getUserClassname(), [Module::getUserModelIdName() => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getScheduleRules()
    {
        return $this->hasMany(ScheduleRule::className(), ['schedule_id' => 'id']);
    }
    
    /**
     * @return array
     */
    public static function getStatusOptions()
    {
        return [self::STATUS_ACTIVE=>Yii::t('common','Active'),self::STATUS_INACTIVE=>Yii::t('common','Inactive')];
    }
    
    /**
     * @return array
     */
    public static function getConfirmationOptions()
    {
        return [self::CONFIRM_NONE=>Yii::t('common','No confirmation'),
            self::CONFIRM_EMAIL=>Yii::t('common','Email Confirmation'),
            self::CONFIRM_PHONE=>Yii::t('common','Phone Confirmation')];
    }
    
    public function getAppointmentTypes()
    {
        return $this->hasMany(AppointmentType::className(), ['id' => 'appointment_type_id'])
            ->viaTable(ScheduleAppointmentType::tableName(),['schedule_id' => 'id']);
    }
    
    public function generateTimeSlots()
    {
        // first pupolate the timeslots with unavailable times
        
        // then add available times as long as they don't intersect with unavailable times.
        
        // finally remove the unavailable time slots since we only to check for available time slots in the frontend.
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
            
            // add time slot for unavailable time
            if ($rule->availability == ScheduleRule::UNAVAILABLE) {
                $slot = new TimeSlot();
                $slot->start_at = date("Y-m-d H:i:s", $start->getTimestamp());
                $slot->end_at = date("Y-m-d H:i:s", $typeEndAt);
                $slot->availability = false;
            }
            
            // get rule types
            foreach ($rule->schedule->getTypes() as $type)
            {
                $typeStart = clone $start;
                while($typeStart->getTimestamp() < $end->getTimestamp())
                {
                    $typeEndAt = strtotime("+{$type->timespan} seconds", $typeStart->getTimestamp());
                    $typeEnd = new DateTime(date("Y-m-d H:i:s", $typeEndAt));
                    // see if enough time for appointment type
                    if ($end->getTimestamp() >= $typeEndAt) {
                        
                        // check if time slot unavailable
                        $query = TimeSlot::find()->where([
                            ['between','start_at', $typeStart->format("Y-m-d H:i:s"), $typeEnd->format("Y-m-d H:i:s")],
                        ])->orWhere([
                            ['between', 'end_at', $typeStart->format("Y-m-d H:i:s"), $typeEnd->format("Y-m-d H:i:s")]
                        ]);
                        if ($query->count) {
                            // time span unavailable
                            continue;
                        }
                        
                        $slot = new TimeSlot();
                        $slot->start_at = date("Y-m-d H:i:s", $start->getTimestamp());
                        $slot->end_at = date("Y-m-d H:i:s", $typeEndAt);
                        $slot->availability = true;
                        $slot->save();
                    }
                }
            }
            
        } while($days <= $rule->schedule->max_advance_schedule);
    }
}
