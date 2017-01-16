<?php

namespace derekisbusy\calendar\models\base;

use derekisbusy\calendar\models\Schedule;
use Yii;

/**
 * This is the base model class for table "{{%calendar_schedule_time_slot}}".
 *
 * @property string $id
 * @property string $schedule_id
 * @property string $start_at
 * @property string $end_at
 *
 * @property Schedule $schedule
 */
class TimeSlot extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule_id', 'start_at', 'end_at'], 'required'],
            [['schedule_id'], 'integer'],
            [['start_at', 'end_at'], 'safe']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%calendar_schedule_time_slot}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'schedule_id' => Yii::t('calendar', 'Schedule ID'),
            'start_at' => Yii::t('calendar', 'Start At'),
            'end_at' => Yii::t('calendar', 'End At'),
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSchedule()
    {
        return $this->hasOne(Schedule::className(), ['id' => 'schedule_id']);
    }
    
    /**
     * @inheritdoc
     * @return \derekisbusy\calendar\models\TimeSlotQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \derekisbusy\calendar\models\TimeSlotQuery(get_called_class());
    }
}
