<?php

namespace derekisbusy\calendar\models;

use derekisbusy\calendar\models\AppointmentQuery;
use derekisbusy\calendar\models\AppointmentStatus;
use derekisbusy\calendar\models\AppointmentType;
use derekisbusy\calendar\backend\modules\calendar\Module;
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
 * @property Patient $patient
 * @property User $createdBy
 * @property User $updatedBy
 * @property AppointmentType $type
 * @property AppointmentStatus $status
 * @property User $assignedTo
 */
class Appointment extends \yii\db\ActiveRecord
{
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_SEARCH = 'search';
    
    public $appointment_type;
    public $appointment_status;
    public $patient_name;
    public $assigned_to_username;
    public $created_by_username;
    public $updated_by_username;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%calendar_appointment}}';
    }
    
    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new AppointmentQuery(get_called_class());
    }
    
    /**
     * @inheritdoc
     */
	public function scenarios()
    {
		$scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['user_id','assigned_to','type_id','start_at','end_at','status_id','created_at','created_by','updated_by','updated_at'];
        $scenarios[self::SCENARIO_UPDATE] = ['user_id','assigned_to','type_id','start_at','end_at','status_id','updated_by','updated_at'];
        $scenarios[self::SCENARIO_SEARCH] = ['schedule_type','user_id','assigned_to','type_id','start_at','end_at','status_id','created_at','created_by','updated_by','updated_at'];
        return $scenarios;
    }
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['user_id','type_id','start_at','end_at','status_id','created_at'],
                'required', 'on'=>[self::SCENARIO_CREATE,self::SCENARIO_UPDATE]],
            [['user_id', 'type_id', 'status_id', 'assigned_to', 'created_by', 'updated_by'], 'integer'],
            [['start_at', 'end_at', 'created_at', 'updated_at'], 'safe'],
            [['user_id_id'], 'exist', 'skipOnError' => true, 'targetClass' => Module::getUserClassname(), 'targetAttribute' => Module::getUserModelIdName()],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => Module::getUserClassname(), 'targetAttribute' => Module::getUserModelIdName()],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => Module::getUserClassname(), 'targetAttribute' => Module::getUserModelIdName()],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppointmentType::className(), 'targetAttribute' => ['id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => AppointmentStatus::className(), 'targetAttribute' => ['id']],
            [['assigned_to'], 'exist', 'skipOnError' => true, 'targetClass' => Module::getUserClassname(), 'targetAttribute' => Module::getUserModelIdName()],
        ];
    }
    
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new \yii\db\Expression('NOW()'),
            ],
            'blameable' => [
                'class' => \yii\behaviors\BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
                ],
             
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
            'type_id' => Yii::t('common', 'Type ID'),
            'start_at' => Yii::t('calendar', 'Start At'),
            'end_at' => Yii::t('calendar', 'End At'),
            'status_id' => Yii::t('common', 'Status ID'),
            'assigned_to' => Yii::t('common', 'Assigned To'),
            'created_by' => Yii::t('common', 'Created By'),
            'updated_by' => Yii::t('common', 'Updated By'),
            'created_at' => Yii::t('common', 'Created At'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_by_username' => Yii::t('common', 'Created By'),
            'updated_by_username' => Yii::t('common', 'Updated By'),
            'appointemnt_type' => Yii::t('common', 'Type'),
            'appointemnt_status' => Yii::t('common', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Module::getUserClassname(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(Module::getUserClassname(), [Module::getUserModelIdName() => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(Module::getUserClassname(), [Module::getUserModelIdName() => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(AppointmentType::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(AppointmentStatus::className(), ['id' => 'status_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignedTo()
    {
        return $this->hasOne(Module::getUserClassname(), [Module::getUserModelIdName() => 'assigned_to']);
    }
    
    
}
