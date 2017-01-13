<?php

namespace derekisbusy\calendar\models;

use Yii;

/**
 * This is the model class for table "{{%schedule_appointment_rule}}".
 *
 * @property integer $id
 * @property integer $schedule_id
 * @property integer $type
 * @property string $day_of_week
 * @property integer $day_of_year
 * @property integer $week_number
 * @property integer $holiday
 * @property string $start_date
 * @property string $end_date
 * @property string $start_at
 * @property string $end_at
 * @property integer $availability
 * @property integer $weight
 * @property string $label
 *
 * @property Schedule $schedule
 */
class ScheduleRule extends \yii\db\ActiveRecord
{
    
    const TYPE_DATE_RANGE = 1;
    const TYPE_WEEKLY = 2;
    const TYPE_MONTHLY = 3;
    const TYPE_HOLIDAY = 4;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schedule_rule}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule_id', 'type', 'start_at', 'end_at', 'availability', 'weight'], 'required'],
            [['schedule_id', 'type', 'day_of_year', 'week_number', 'holiday', 'availability', 'weight'], 'integer'],
            [['day_of_week'], 'string'],
            [['start_date', 'end_date', 'start_at', 'end_at'], 'safe'],
            [['label'], 'string', 'max' => 20],
            [['schedule_id'], 'exist', 'skipOnError' => true, 'targetClass' => Schedule::className(), 'targetAttribute' => ['id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'schedule_id' => Yii::t('calendar', 'Schedule ID'),
            'type' => Yii::t('common', 'Type'),
            'day_of_week' => Yii::t('calendar', 'Day Of Week'),
            'day_of_year' => Yii::t('calendar', 'Day Of Year'),
            'week_number' => Yii::t('calendar', 'Week Number'),
            'holiday' => Yii::t('calendar', 'Holiday'),
            'start_date' => Yii::t('calendar', 'Start Date'),
            'end_date' => Yii::t('calendar', 'End Date'),
            'start_at' => Yii::t('calendar', 'Start At'),
            'end_at' => Yii::t('calendar', 'End At'),
            'availability' => Yii::t('calendar', 'Availability'),
            'weight' => Yii::t('calendar', 'Weight'),
            'label' => Yii::t('calendar', 'Label'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(Schedule::className(), ['id' => 'schedule_id']);
    }
    
    public static function getTypeOptions()
    {
        return [
            self::TYPE_DATE_RANGE=>Yii::t('calendar','Date Range'),
            self::TYPE_WEEKLY=>Yii::t('calendar','Weekly'),
            self::TYPE_MONTHLY=>Yii::t('calendar','Monthly'),
            self::TYPE_HOLIDAY=>Yii::t('calendar','Holiday'),
        ];
    }
}
