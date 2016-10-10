<?php
namespace bl\rbac\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

use bl\rbac\models\form\user\CreateUser;
use bl\rbac\models\form\user\AddRole;
use bl\rbac\models\form\user\RemoveRole;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'create',
                    'add-role',
                    'remove-role'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['create'],
                        'roles' => ['createUser']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['add-role'],
                        'roles' => ['createRoleUser']
                    ],
                    [
                        'allow' => true,
                        'actions' => ['remove-role'],
                        'roles' => ['removeRoleUser']
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new CreateUser();
        if ($model->load(Yii::$app->request->post())) {
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($model->validate()) {
                if ($user = $model->create()) {
                    Yii::$app->flashNotifications->success('User "' . $user->username . '" successfully created.');
                }
                else {
                    Yii::$app->flashNotifications->error('Internal server error. Try again later.');
                }
            }
            else {
                Yii::$app->flashNotifications->addModelErrors($model);
            }
            return $this->redirect(Url::to(['/rbac/default/index']));
        }
        else {
            throw new BadRequestHttpException();
        }
    }

    public function actionAddRole()
    {
        $model = new AddRole();
        if ($model->load(Yii::$app->request->post())) {
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if($model->validate()) {
                if($model->add()) {
                    Yii::$app->flashNotifications->success('Role successfully assigned.');
                }
                else {
                    Yii::$app->flashNotifications->error('Internal server error.');
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

    public function actionRemoveRole()
    {
        $model = new RemoveRole();
        if($model->load(Yii::$app->request->get(), '')) {
            if ($model->validate()) {
                if($model->remove()) {
                    Yii::$app->flashNotifications->success('Role successfully removed from user.');
                }
                else {
                    Yii::$app->flashNotifications->error('Internal server error.');
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