<?php
namespace bl\rbac\models\validators;

use Yii;
use yii\validators\Validator;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class PermissionExists extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (!Yii::$app->authManager->getPermission($model->$attribute)) {
            $this->addError($model, $attribute, 'This permission does not exist');
        }
    }
}