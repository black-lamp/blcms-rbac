<?php
namespace bl\rbac\models\form\user;

use bl\rbac\models\validators\RoleExists;
use Yii;
use yii\base\Model;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class RemoveRole extends Model
{
    public $userId;
    public $roleName;

    public function rules()
    {
        return [
            ['userId', 'required'],
            ['userId', 'exist',
                'targetClass' => '\common\models\User',
                'targetAttribute' => 'id',
                'message' => 'The user does not exist'],
            ['roleName', 'required'],
            ['roleName', RoleExists::className()]
        ];
    }

    public function remove() {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($this->roleName);

        return $auth->revoke($role, $this->userId);
    }
}