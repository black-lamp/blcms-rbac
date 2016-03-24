<?php
namespace bl\rbac\controllers;

use bl\rbac\models\form\permission\CreatePermission;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class PermissionController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'create'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createPermission']
                    ]
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new CreatePermission();
        if ($model->load(Yii::$app->request->post())) {
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if($model->validate()) {
                if ($model->create()) {
                    Yii::$app->flashNotifications->success('Permission "' . $model->name . '" successfully created.');
                }
                else {
                    Yii::$app->flashNotifications->error('Internal server error. Try again later.');
                }
            }
            else {
                Yii::$app->flashNotifications->addModelErrors($model);
            }
            return $this->redirect(Url::to(['default/index']));
        }
        else {
            throw new BadRequestHttpException();
        }
    }
}