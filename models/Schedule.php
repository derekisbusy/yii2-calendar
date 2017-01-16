<?php

namespace derekisbusy\calendar\models;

use derekisbusy\calendar\models\ScheduleRule;
use derekisbusy\calendar\backend\modules\calendar\Module;
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
 * @property ScheduleRule[] $scheduleAppointmentRules
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
        return '{{%schedule}}';
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
    public function getScheduleAppointmentRules()
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
    
    public function getTypes()
    {
        return 
    }
}
