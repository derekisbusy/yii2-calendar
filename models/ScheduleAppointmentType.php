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
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common/models/appointment-type', 'ID'),
            'abbr' => Yii::t('common/models/appointment-type', 'Abbr'),
            'name' => Yii::t('common/models/appointment-type', 'Name'),
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
