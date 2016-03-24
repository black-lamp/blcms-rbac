<?php
namespace bl\rbac\models\validators;

use Yii;
use yii\validators\Validator;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class RoleExists extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (!Yii::$app->authManager->getRole($model->$attribute)) {
            $this->addError($model, $attribute, 'This role does not exist');
        }
    }
}