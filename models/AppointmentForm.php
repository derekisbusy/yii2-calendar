<?php

namespace derekisbusy\calendar\models;

use derekisbusy\calendar\backend\modules\calendar\Module;
use derekisbusy\calendar\models\AppointmentStatus;
use derekisbusy\calendar\models\AppointmentType;
use Yii;

/**
 * This is the model class for table "{{%schedule_appointment}}".
 *
 * @property integer $id
 * @property string $user_id
 * @property integer $type_id
 * @property string $start_at
 * @property string $end_at
 * @property integer $status_id
 * @property string $assigned_to
 * @property string $created_by
 * @property string $updated_by
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 * @property User $createdBy
 * @property User $updatedBy
 * @property AppointmentType $type
 * @property AppointmentStatus $status
 * @property User $assignedTo
 */
class AppointmentForm extends Appointment
{
    public $date;
    public $start_time;
    public $end_time;
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type_id', 'date','start_time','end_time', 'start_at', 'end_at', 'status_id'], 'required'],
            [['user_id', 'type_id', 'status_id', 'assigned_to'], 'integer'],
            [['start_at', 'end_at', 'created_at', 'updated_at'], 'safe'],
//            [['date', 'start_time', 'end_time'], 'trim'],
//            [['date'], 'match', 'pattern'=>'/[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{2,4}/'],
            [['date'], 'match', 'pattern'=>'/[0-9]{4}-[0-9]{2}-[0-9]{2}/'],
//            [['start_time', 'end_time'], 'match', 'pattern'=>'/[0-9]{2}:[0-9]{2}:[0-9]{2}/i'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::getUserClassname(), 'targetAttribute' => Module::getUserModelIdName()],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppointmentType::className(), 'targetAttribute' => 'id'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppointmentStatus::className(), 'targetAttribute' => 'id'],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => Module::getUserClassname(), 'targetAttribute' => Module::getUserModelIdName()],
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
            'type_id' => Yii::t('common', 'Type'),
            'start_at' => Yii::t('calendar', 'Start At'),
            'end_at' => Yii::t('calendar', 'End At'),
            'status_id' => Yii::t('common', 'Status'),
            'assigned_to' => Yii::t('calendar', 'Assigned To'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
        ];
    }
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->start_at = $this->date.' '.$this->start_time;
            $this->end_at = $this->date.' '.$this->end_time;
            return true;
        } else {
            return false;
        }
    }

}
