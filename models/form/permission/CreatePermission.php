<?php
namespace bl\rbac\models\form\permission;

use bl\rbac\models\validators\PermissionUnique;
use Yii;
use yii\base\Model;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class CreatePermission extends Model
{
    public $name;
    public $description;

    public function rules()
    {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required', 'message' => 'Поле названия разрешения обязательно для заполнения.'],
            ['name', 'string', 'min' => 2, 'message' => 'Поле названия разрешения должно состоять не менее чем из 2-х символов.'],
            ['name', 'string', 'max' => 64, 'message' => 'Поле названия разрешения должно состоять не более чем из 64-х символов.'],
            ['name', PermissionUnique::className()],

            ['description', 'filter', 'filter' => 'trim']
        ];
    }

    public function create() {
        $auth = Yii::$app->authManager;
        if(!$permission = $auth->createPermission($this->name)) {
            return false;
        }
        $permission->description = $this->description;
        return $auth->add($permission);
    }
}