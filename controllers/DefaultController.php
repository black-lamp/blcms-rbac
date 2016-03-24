<?php

namespace bl\rbac\controllers;

use common\models\User;
use bl\rbac\models\form\permission\CreatePermission;
use bl\rbac\models\form\role\AddPermission;
use bl\rbac\models\form\role\CreateRole;
use bl\rbac\models\form\user\AddRole;
use bl\rbac\models\form\user\CreateUser;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class DefaultController extends Controller
{

    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [
                    'index'
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['manageRbac']
                    ]
                ]
            ]
        ];
    }*/

    public function actionIndex()
    {
        return $this->render('index', [
            'userList' => User::find()->all(),
            'createUserFormModel' => new CreateUser(),
            'roleList' => Yii::$app->authManager->getRoles(),
            'createRoleFormModel' => new CreateRole(),
            'permissionList' => Yii::$app->authManager->getPermissions(),
            'createPermissionFormModel' => new CreatePermission(),
            'addPermissionToRoleFormModel' => new AddPermission(),
            'addRoleToUserFormModel' => new AddRole(),
        ]);
    }
}