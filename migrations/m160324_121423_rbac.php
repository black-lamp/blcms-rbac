<?php

use yii\db\Migration;

class m160324_121423_rbac extends Migration
{
    public function up()
    {
        $auth = \Yii::$app->authManager;

        $createUser = $auth->createPermission('createUser');
        $createUser->description = 'Разрешает добавлять новый пользователей';
        $auth->add($createUser);

        $createPermissionRole = $auth->createPermission('createPermissionRole');
        $createPermissionRole->description = 'Разрешает добавлять привязанные разрешения';
        $auth->add($createPermissionRole);

        $createRoleUser = $auth->createPermission('createRoleUser');
        $createRoleUser->description = 'Разрешает добавлять роли к пользователю';
        $auth->add($createRoleUser);

        $removePermissionRole = $auth->createPermission('removePermissionRole');
        $removePermissionRole->description = 'Разрешает удалять привязанные разрешения';
        $auth->add($removePermissionRole);

        $removeRoleUser = $auth->createPermission('removeRoleUser');
        $removeRoleUser->description = 'Разрешает удалять привязанные роли';
        $auth->add($removeRoleUser);

        $admin = $auth->createRole('superadmin');
        $auth->add($admin);

        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $createPermissionRole);
        $auth->addChild($admin, $createRoleUser);
        $auth->addChild($admin, $removePermissionRole);
        $auth->addChild($admin, $removeRoleUser);

        $createPermission = $auth->createPermission('createPermission');
        $createPermission->description = 'Разрешает добавлять новые разрешения';
        $auth->add($createPermission);

        $createRole = $auth->createPermission('createRole');
        $createRole->description = 'Разрешает создавать роли пользователей';
        $auth->add($createRole);

        $auth->addChild($admin, $createPermission);
        $auth->addChild($admin, $createRole);

        return true;
    }

    public function down()
    {
        $auth = \Yii::$app->authManager;

        $createUser = $auth->getPermission('createUser');
        $auth->remove($createUser);

        $createPermissionRole = $auth->getPermission('createPermissionRole');
        $auth->remove($createPermissionRole);

        $createRoleUser = $auth->getPermission('createRoleUser');
        $auth->remove($createRoleUser);

        $removePermissionRole = $auth->getPermission('removePermissionRole');
        $auth->remove($removePermissionRole);

        $removeRoleUser = $auth->getPermission('removeRoleUser');
        $auth->remove($removeRoleUser);

        $admin = $auth->getRole('superadmin');
        $auth->remove($admin);

        $auth->removeChild($admin, $createUser);
        $auth->removeChild($admin, $createPermissionRole);
        $auth->removeChild($admin, $createRoleUser);
        $auth->removeChild($admin, $removePermissionRole);
        $auth->removeChild($admin, $removeRoleUser);

        $createPermission = $auth->getPermission('createPermission');
        $auth->remove($createPermission);

        $createRole = $auth->getPermission('createRole');
        $auth->remove($createRole);

        $auth->removeChild($admin, $createPermission);
        $auth->removeChild($admin, $createRole);

        return true;
    }
}
