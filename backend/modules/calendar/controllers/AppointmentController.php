<?php

namespace derekisbusy\calendar\backend\modules\calendar\controllers;

use derekisbusy\calendar\models\Appointment;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * AppointmentController implements the CRUD actions for Appointment model.
 */
class AppointmentController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
//           'access' => [
//               'class' => AccessControl::className(),
//            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Appointment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \derekisbusy\calendar\models\AppointmentSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Appointment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $appointment = $this->findModel($id);

        if ($appointment->load(Yii::$app->request->post()) && $appointment->save()) {
        return $this->redirect(['view', 'id' => $appointment->id]);
        } else {
        return $this->render('view', ['appointment' => $appointment]);
}
    }

    /**
     * Creates a new Appointment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $appointment = new \derekisbusy\calendar\models\AppointmentForm(['scenario'=>  Appointment::SCENARIO_CREATE]);

        if ($appointment->load(Yii::$app->request->post()) && $appointment->save()) {
            return $this->redirect(['view', 'id' => $appointment->id]);
        } else {
            return $this->render('create', [
                'appointment' => $appointment,
            ]);
        }
    }

    /**
     * Updates an existing Appointment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$ajax=false)
    {
        $appointment = $this->findModel($id);
        $appointment->scenario = Appointment::SCENARIO_UPDATE;
        
        if ($appointment->load(Yii::$app->request->post()) && $appointment->save()) {
            if ($ajax) {
                echo kartik\widgets\Growl::widget([
                    'type' => Growl::TYPE_SUCCESS,
                    'title' => 'Appointment has been updated!',
                    'icon' => 'glyphicon glyphicon-ok-sign',
                    'body' => 'You successfully read this important alert message.',
                    'showSeparator' => true,
                    'delay' => 0,
                    'pluginOptions' => [
                        'showProgressbar' => true,
                        'placement' => [
                            'from' => 'top',
                            'align' => 'right',
                        ]
                    ]
                ]);
            } else {
                return $this->redirect(['view', 'id' => $appointment->id]);
            }
        } else {
            if ($ajax) {
                return $this->renderAjax('_form', ['appointment' => $appointment]);
            } else {
                return $this->render('update', ['appointment' => $appointment]);
            }
        }
    }

    /**
     * Deletes an existing Appointment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Appointment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Appointment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($appointment = \derekisbusy\calendar\models\AppointmentForm::findOne($id)) !== null) {
            return $appointment;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
