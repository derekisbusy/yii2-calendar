<?php

namespace derekisbusy\calendar\models\base;

use Yii;

/**
 * This is the base model class for table "{{%calendar_schedule_appointment_type}}".
 *
 * @property string $schedule_id
 * @property string $appointment_type_id
 */
class ScheduleAppointmentType extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schedule_id', 'appointment_type_id'], 'required'],
            [['schedule_id', 'appointment_type_id'], 'integer']
        ];
    }
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%calendar_schedule_appointment_type}}';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'schedule_id' => Yii::t('calendar', 'Schedule ID'),
            'appointment_type_id' => Yii::t('calendar', 'Appointment Type ID'),
        ];
    }
}
