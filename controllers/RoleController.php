<?php
namespace bl\rbac\controllers;

use bl\rbac\models\form\role\AddPermission;
use bl\rbac\models\form\role\CreateRole;
use bl\rbac\models\form\role\RemovePermission;
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
class RoleController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'create',
                    'add-permission',
                    'remove-permission'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createRole']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add-permission'],
                        'roles' => ['createPermissionRole']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['remove-permission'],
                        'roles' => ['removePermissionRole']
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new CreateRole();
        if ($model->load(Yii::$app->request->post())) {
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if($model->validate()) {
                if ($model->create()) {
                    Yii::$app->flashNotifications->success('Role "' . $model->name . '" successfully created.');
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

    public function actionAddPermission()
    {
        $model = new AddPermission();
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()) {
                if($model->add()) {
                    Yii::$app->flashNotifications->success('Permission successfully added to role.');
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

    public function actionRemovePermission()
    {
        $model = new RemovePermission();
        if($model->load(Yii::$app->request->get(), '')) {
            if ($model->validate()) {
                if($model->remove()) {
                    Yii::$app->flashNotifications->success('Permission successfully removed from role.');
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