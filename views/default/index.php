<?php
/* @var $this \yii\web\View */
/* @var $userList \common\models\User[] */
/* @var $createUserFormModel bl\rbac\models\form\user\CreateUser */
/* @var $addRoleToUserFormModel bl\rbac\models\form\user\AddRole */
/* @var $roleList \yii\rbac\Role[] */
/* @var $createRoleFormModel bl\rbac\models\form\role\CreateRole */
/* @var $addPermissionToRoleFormModel bl\rbac\models\form\role\AddPermission */
/* @var $permissionList \yii\rbac\Permission[] */
/* @var $createPermissionFormModel bl\rbac\models\form\permission\CreatePermission */

use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Пользователи";
?>

<div class="row">

    <!-- Users -->
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>
                    <i class="glyphicon glyphicon-user"></i>
                    Список пользователей
                </h5>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Имя пользователя</th>
                            <th>Адрес электронной почты</th>
                            <th>
                                Роли
                                <a href="" class="btn btn-xs btn-success pull-right" data-toggle="modal"
                                   data-target="#addRoleToUserFormModel">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    Добавить связь
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($userList as $user): ?>
                            <? $userRoles = Yii::$app->authManager->getRolesByUser($user->id) ?>
                            <tr>
                                <td><?= $user->username ?></td>
                                <td><?= $user->email ?></td>
                                <td>
                                    <? foreach ($userRoles as $role): ?>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-info">
                                                <?= $role->description ?>
                                            </button>
                                            <a href="<?= Url::to(['user/remove-role', 'userId' => $user->id, 'roleName' => $role->name]) ?>"
                                               type="button" class="btn btn-xs btn-info">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </a>
                                        </div>
                                    <? endforeach ?>
                                </td>
                            </tr>
                        <? endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <a class="btn btn-primary pull-right" data-toggle="modal" data-target="#createUserFormModel">
                    <i class="glyphicon glyphicon-pencil"></i> Добавить
                </a>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<!-- Roles -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>
                    <i class="glyphicon glyphicon-user"></i>
                    Список ролей
                </h5>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>
                                Разрешения
                                <a href="" class="btn btn-xs btn-success pull-right" data-toggle="modal"
                                   data-target="#addPermissionToRoleFormModel">
                                    <i class="glyphicon glyphicon-plus"></i>
                                    Добавить связь
                                </a>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <? foreach ($roleList as $role): ?>
                            <tr>
                                <td><?= $role->name ?></td>
                                <td><?= $role->description ?></td>
                                <td>
                                    <? foreach (Yii::$app->authManager->getPermissionsByRole($role->name) as $permission): ?>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-xs btn-info">
                                                <?= $permission->name ?>
                                            </button>
                                            <a href="<?= Url::to(['role/remove-permission', 'roleName' => $role->name, 'permissionName' => $permission->name]) ?>"
                                               type="button" class="btn btn-xs btn-info">
                                                <i class="glyphicon glyphicon-remove"></i>
                                            </a>
                                        </div>
                                    <? endforeach ?>
                                </td>
                            </tr>
                        <? endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <a class="btn btn-primary pull-right" data-toggle="modal" data-target="#createRoleFormModel">
                    <i class="glyphicon glyphicon-plus"></i> Добавить
                </a>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<!-- Permissions -->
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h5>
                    <i class="glyphicon glyphicon-retweet"></i>
                    Список разрешений
                </h5>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Название</th>
                            <th>Описание</th>
                        </tr>
                        </thead>
                        <tbody>

                        <? foreach ($permissionList as $permission): ?>
                            <tr>
                                <td><?= $permission->name ?></td>
                                <td><?= $permission->description ?></td>
                            </tr>
                        <? endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <a class="btn btn-primary pull-right" data-toggle="modal" data-target="#createPermissionFormModel">
                    <i class="glyphicon glyphicon-plus"></i> Добавить
                </a>

                <div class="clearfix"></div>
            </div>
        </div>

    </div>
</div>

<!-- Create User Modal Dialog -->
<div class="modal fade" id="createUserFormModel" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <? $createUserForm = ActiveForm::begin([
                'action' => Url::to(['user/create']),
                'enableAjaxValidation' => true
            ]) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><i class="glyphicon glyphicon-user"></i> Добавить пользователя</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?= $createUserForm->field($createUserFormModel, 'username', [
                        'inputOptions' => [
                            'placeholder' => "Имя пользователя",
                            'class' => 'form-control'
                        ]
                    ])->label('Имя пользователя')
                    ?>
                </div>
                <div class="form-group">
                    <?= $createUserForm->field($createUserFormModel, 'email', [
                        'inputOptions' => [
                            'placeholder' => "Адрес электронной почты",
                            'class' => 'form-control'
                        ]
                    ])->label('Адрес электронной почты')
                    ?>
                </div>
                <div class="form-group">
                    <?= $createUserForm->field($createUserFormModel, 'password', [
                        'inputOptions' => [
                            'placeholder' => "Пароль",
                            'class' => 'form-control',
                            'type' => 'password'
                        ]
                    ])->label('Пароль')
                    ?>
                </div>
                <div class="form-group">
                    <?= Html::activeDropDownList($createUserFormModel, 'roleName',
                        ArrayHelper::map($roleList, 'name', 'description'), [
                            'class' => 'form-control'
                        ]);
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary pull-right" value="Добавить">
            </div>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- Create Role Modal Dialog -->
<div class="modal fade" id="createRoleFormModel" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <? $createRoleForm = ActiveForm::begin([
                'action' => Url::to(['role/create']),
                'enableAjaxValidation' => true
            ]) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Добавить роль</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?= $createRoleForm->field($createRoleFormModel, 'name', [
                        'inputOptions' => [
                            'placeholder' => "Название",
                            'class' => 'form-control'
                        ]
                    ])->label('Название')
                    ?>
                </div>
                <div class="form-group">
                    <?= $createRoleForm->field($createRoleFormModel, 'description', [
                        'inputOptions' => [
                            'placeholder' => "Описание",
                            'class' => 'form-control'
                        ]
                    ])->label('Описание')
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary pull-right" value="Добавить">
            </div>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- Create Permission Modal Dialog -->
<div class="modal fade" id="createPermissionFormModel" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <? $createPermissionForm = ActiveForm::begin([
                'action' => Url::to(['permission/create']),
                'enableAjaxValidation' => true
            ]) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Добавить разрешение</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?= $createPermissionForm->field($createPermissionFormModel, 'name', [
                        'inputOptions' => [
                            'placeholder' => "Название",
                            'class' => 'form-control'
                        ]
                    ])->label('Название')
                    ?>
                </div>
                <div class="form-group">
                    <?= $createPermissionForm->field($createPermissionFormModel, 'description', [
                        'inputOptions' => [
                            'placeholder' => "Описание",
                            'class' => 'form-control'
                        ]
                    ])->label('Описание')
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary pull-right" value="Добавить">
            </div>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- Add Permission to Role Modal Dialog -->
<div class="modal fade" id="addPermissionToRoleFormModel" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <? ActiveForm::begin([
                'action' => Url::to(['role/add-permission']),
                'enableAjaxValidation' => true
            ]) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Добавить разрешение к роли</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?= Html::activeDropDownList($addPermissionToRoleFormModel, 'roleName',
                        ArrayHelper::map($roleList, 'name', 'description'), [
                            'class' => 'form-control'
                        ]);
                    ?>
                </div>
                <div class="form-group">
                    <?= Html::activeDropDownList($addPermissionToRoleFormModel, 'permissionName',
                        ArrayHelper::map($permissionList, 'name', 'name'), [
                            'class' => 'form-control'
                        ])
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary pull-right" value="Добавить">
            </div>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>

<!-- Add Role to User Modal Dialog -->
<div class="modal fade" id="addRoleToUserFormModel" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <? ActiveForm::begin([
                'action' => Url::to(['user/add-role']),
                'enableAjaxValidation' => true
            ]) ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Добавить роль к пользователю</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?= Html::activeDropDownList($addRoleToUserFormModel, 'userId',
                        ArrayHelper::map(\common\models\User::find()->all(), 'id', 'username'), [
                            'class' => 'form-control'
                        ])
                    ?>
                </div>
                <div class="form-group">
                    <?= Html::activeDropDownList($addRoleToUserFormModel, 'roleName',
                        ArrayHelper::map($roleList, 'name', 'description'), [
                            'class' => 'form-control'
                        ])
                    ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary pull-right" value="Добавить">
            </div>
            <? ActiveForm::end(); ?>
        </div>
    </div>
</div>