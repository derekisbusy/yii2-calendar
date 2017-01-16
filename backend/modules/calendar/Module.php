<?php

namespace derekisbusy\calendar\backend\modules\calendar;

/**
 * calendar module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'derekisbusy\calendar\backend\modules\calendar\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    
    public static function getUserClassname()
    {
        return 'dektrium\user\models\User';
    }
    
    public static function getUserModelIdName()
    {
        return 'id';
    }
    
    public static function getUserModelUsernameColumnName()
    {
        return 'username';
    }
    
    public static function getUserTableName()
    {
        return call_user_func(self::getUserClassname().'::tableName');
    }
    
    public static function getUser($id = null)
    {
        return call_user_func(self::getUserClassname().'::find');
    }
    
    public static function hasRole($roleName,$userId=null)
    {
        $auth = \Yii::$app->authManager;
        if($userId==null) {
            if (\Yii::$app->user->isGuest) {
                return false;
            }
            $userId = \Yii::$app->user->identity->id;
        }
        $roles = $auth->getRolesByUser($userId);
        foreach($roles as $role) {
            if ($role->name == $roleName) {
                return true;
            }
        }
        return false;
    }
    
    
}
