<?php

namespace derekisbusy\calendar\backend\modules\calendar\controllers;

use derekisbusy\calendar\backend\modules\calendar\Module;
use Yii;
use yii\web\Response;


class AjaxController extends \yii\web\Controller
{
    public function actionUserSchedule($q = null, $id = null,$s=null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new \yii\db\Query;
            $query->select(['`'.Module::getUserModelIdName()."` AS id",'`'.Module::getUserModelUsernameColumnName()."` AS text"])
                ->from(Module::getUserTableName())
                ->where('`'.Module::getUserModelUsernameColumnName()."` LIKE '%" . $q ."%'")
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => Module::getUser($id)->{Module::getUserModelUsernameColumnName()}];
        }
        return $out;
    }

}
