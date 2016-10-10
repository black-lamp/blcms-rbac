<?php
namespace bl\rbac\models\form\user;

use bl\rbac\models\validators\RoleExists;
use Yii;
use yii\base\Model;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class AddRole extends Model
{
    public $userId;
    public $roleName;

    public function rules()
    {
        return [
            ['userId', 'required'],
            ['roleName', 'required'],
            ['roleName', function($attribute, $params) {
                if(Yii::$app->authManager->getAssignment($this->roleName, $this->userId))
                    $this->addError($attribute, 'This user already has this role');
            }],
            ['roleName', RoleExists::className()]
        ];
    }

    public function add() {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->roleName);
        $auth->assign($role, $this->userId);

        return true;
    }
}