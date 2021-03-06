<?php
namespace bl\rbac\models\form\user;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class CreateUser extends Model
{
    public $username;
    public $email;
    public $password;
    public $roleName;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['roleName', 'required'],
        ];
    }

    /**
     * Creates user
     * @return User|null the saved model or null if saving fails
     */
    public function create()
    {
        if ($this->validate()) {

            $auth = Yii::$app->authManager;
            $role = $auth->getRole($this->roleName);
            if(!$role) {
                return null;
            }

            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                $auth->assign($role, $user->getId());
                return $user;
            }
        }
        return null;
    }
}