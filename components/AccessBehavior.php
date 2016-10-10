<?php
namespace bl\rbac\components;

use Yii;
use yii\base\Behavior;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @author Gutsulyak Vadim <guts.vadim@gmail.com>
 */
class AccessBehavior extends Behavior
{
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }

    public function beforeAction()
    {
        if(Yii::$app->getRequest()->url == Url::to([Yii::$app->getUser()->loginUrl])) {
            return;
        }

        $user = Yii::$app->getUser();
        if ($user->isGuest || !$user->can('adminPanelAccess')) {
            Yii::$app->getResponse()->redirect([Yii::$app->getUser()->loginUrl]);
        }
    }
}