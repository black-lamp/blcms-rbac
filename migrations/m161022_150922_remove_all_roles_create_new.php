<?php

use yii\db\Migration;

class m161022_150922_remove_all_roles_create_new extends Migration
{
    public function up()
    {
        $auth = \Yii::$app->authManager;

        $createUser = $auth->getPermission('createUser');
        $createPermissionRole = $auth->getPermission('createPermissionRole');
        $createRoleUser = $auth->getPermission('createRoleUser');
        $removePermissionRole = $auth->getPermission('removePermissionRole');
        $removeRoleUser = $auth->getPermission('removeRoleUser');
        $createPermission = $auth->getPermission('createPermission');
        $createRole = $auth->getPermission('createRole');

        $admin = $auth->getRole('superadmin');

        $auth->removeChild($admin, $createUser);
        $auth->removeChild($admin, $createPermissionRole);
        $auth->removeChild($admin, $createRoleUser);
        $auth->removeChild($admin, $removePermissionRole);
        $auth->removeChild($admin, $removeRoleUser);
        $auth->removeChild($admin, $createPermission);
        $auth->removeChild($admin, $createRole);

        $auth->remove($admin);


        $rbacManager = $auth->createRole('rbacManager');
        $rbacManager->description = 'RBAC manager';
        $auth->add($rbacManager);

        $auth->addChild($rbacManager, $createUser);
        $auth->addChild($rbacManager, $createPermissionRole);
        $auth->addChild($rbacManager, $createRoleUser);
        $auth->addChild($rbacManager, $removePermissionRole);
        $auth->addChild($rbacManager, $removeRoleUser);
        $auth->addChild($rbacManager, $createPermission);
        $auth->addChild($rbacManager, $createRole);




    }

    public function down()
    {
        $auth = \Yii::$app->authManager;

        $createUser = $auth->getPermission('createUser');
        $createPermissionRole = $auth->getPermission('createPermissionRole');
        $createRoleUser = $auth->getPermission('createRoleUser');
        $removePermissionRole = $auth->getPermission('removePermissionRole');
        $removeRoleUser = $auth->getPermission('removeRoleUser');
        $createPermission = $auth->getPermission('createPermission');
        $createRole = $auth->getPermission('createRole');

        $admin = $auth->createRole('superadmin');
        $auth->add($admin);

        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $createPermissionRole);
        $auth->addChild($admin, $createRoleUser);
        $auth->addChild($admin, $removePermissionRole);
        $auth->addChild($admin, $removeRoleUser);
        $auth->addChild($admin, $createPermission);
        $auth->addChild($admin, $createRole);

        $rbacManager = $auth->getRole('rbacManager');

        $auth->removeChild($rbacManager, $createUser);
        $auth->removeChild($rbacManager, $createPermissionRole);
        $auth->removeChild($rbacManager, $createRoleUser);
        $auth->removeChild($rbacManager, $removePermissionRole);
        $auth->removeChild($rbacManager, $removeRoleUser);
        $auth->removeChild($rbacManager, $createPermission);
        $auth->removeChild($rbacManager, $createRole);
    }
}
