<?php
namespace bl\rbac\models\form\role;

use bl\rbac\models\validators\PermissionExists;
use bl\rbac\models\validators\RoleExists;
use Yii;
use yii\base\Model;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class AddPermission extends Model
{
    public $roleName;
    public $permissionName;

    public function rules()
    {
        return [
            ['roleName', 'required'],
            ['roleName', RoleExists::className()],
            ['permissionName', 'required'],
            ['permissionName', PermissionExists::className()],
            ['permissionName', function($attribute, $params) {
                $auth = Yii::$app->authManager;
                $role = $auth->getRole($this->roleName);
                $permission = $auth->getPermission($this->permissionName);
                if($auth->hasChild($role, $permission))
                    $this->addError($attribute, 'This role already contains this permission');
            }]
        ];
    }

    public function add() {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->roleName);
        $permission = $auth->getPermission($this->permissionName);
        $auth->addChild($role, $permission);

        return true;
    }
}