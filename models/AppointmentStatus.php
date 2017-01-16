<?php

namespace derekisbusy\calendar\models;

use Yii;

/**
 * This is the model class for table "{{%calendar_appointment_status}}".
 *
 * @property integer $id
 * @property string $abbr
 * @property string $name
 *
 * @property Appointment[] $appointments
 */
class AppointmentStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%calendar_appointment_status}}';
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
            'id' => Yii::t('common', 'ID'),
            'abbr' => Yii::t('common', 'Abbr'),
            'name' => Yii::t('common', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppointments()
    {
        return $this->hasMany(Appointment::className(), ['status_id' => 'id']);
    }
    
    public static function getStatuses()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');
    }
}
