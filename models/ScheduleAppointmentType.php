<?php

namespace derekisbusy\calendar\models;

use Yii;

/**
 * This is the model class for table "{{%appointment_type}}".
 *
 * @property integer $id
 * @property string $abbr
 * @property string $name
 *
 * @property ScheduleAppointment[] $appointments
 */
class ScheduleAppointmentType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%schedule_appointment_type}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['abbr', 'name'], 'required'],
            [['abbr'], 'string', 'max' => 12],
            [['name'], 'string', 'max' => 100],
            [['description'],'safe'],
            [['timespan'],'integer', 'min' => 60 * 5] // 5 min
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'abbr' => Yii::t('common', 'Abbr'),
            'name' => Yii::t('common', 'Name'),
            'description' => Yii::t('common', 'Description'),
            'timespan' => Yii::t('calendar', 'Timespan'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppointments()
    {
        return $this->hasMany(ScheduleAppointment::className(), ['type_id' => 'id']);
    }
    
    public static function getTypes()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');
    }
}
