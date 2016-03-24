<?php
namespace bl\rbac\models\form\role;

use bl\rbac\models\validators\RoleUnique;
use Yii;
use yii\base\Model;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class CreateRole extends Model {

    public $name;
    public $description;

    public function rules() {
        return [
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'required', 'message' => 'Поле названия роли обязательно для заполнения.'],
            ['name', 'string', 'min' => 2, 'message' => 'Поле названия роли должно состоять не менее чем из 2-х символов.'],
            ['name', 'string', 'max' => 64, 'message' => 'Поле названия роли должно состоять не более чем из 64-х символов.'],
            ['name', RoleUnique::className()],
            ['description', 'filter', 'filter' => 'trim']
        ];
    }

    public function create() {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole($this->name);
        $role->description = $this->description;

        return $auth->add($role);
    }

}
