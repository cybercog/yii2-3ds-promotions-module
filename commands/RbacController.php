<?php

namespace yii3ds\promotions\commands;

use Yii;
use yii\console\Controller;

/**
 * Promotions RBAC controller.
 */
class RbacController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'add';

    /**
     * @var array Main module permission array
     */
    public $mainPermission = [
        'name' => 'administratePromotions',
        'description' => 'Can administrate all "Promotions" module'
    ];

    /**
     * @var array Permission
     */
    public $permissions = [
        'BViewPromotions' => [
            'description' => 'Can view backend promotions list'
        ],
        'BCreatePromotions' => [
            'description' => 'Can create backend promotions'
        ],
        'BUpdatePromotions' => [
            'description' => 'Can update backend promotions'
        ],
        'BDeletePromotions' => [
            'description' => 'Can delete backend promotions'
        ],
        'viewPromotions' => [
            'description' => 'Can view promotions'
        ],
        'createPromotions' => [
            'description' => 'Can create promotions'
        ],
        'updatePromotions' => [
            'description' => 'Can update promotions'
        ],
        'updateOwnPromotions' => [
            'description' => 'Can update own promotions',
            'rule' => 'author'
        ],
        'deletePromotions' => [
            'description' => 'Can delete promotions'
        ],
        'deleteOwnPromotions' => [
            'description' => 'Can delete own promotions',
            'rule' => 'author'
        ]
    ];

    /**
     * Add comments RBAC.
     */
    public function actionAdd()
    {
        $auth = Yii::$app->authManager;
        $superadmin = $auth->getRole('superadmin');
        $mainPermission = $auth->createPermission($this->mainPermission['name']);
        if (isset($this->mainPermission['description'])) {
            $mainPermission->description = $this->mainPermission['description'];
        }
        if (isset($this->mainPermission['rule'])) {
            $mainPermission->ruleName = $this->mainPermission['rule'];
        }
        $auth->add($mainPermission);

        foreach ($this->permissions as $name => $option) {
            $permission = $auth->createPermission($name);
            if (isset($option['description'])) {
                $permission->description = $option['description'];
            }
            if (isset($option['rule'])) {
                $permission->ruleName = $option['rule'];
            }
            $auth->add($permission);
            $auth->addChild($mainPermission, $permission);
        }

        $auth->addChild($superadmin, $mainPermission);

        $updatePromotions = $auth->getPermission('updatePromotions');
        $updateOwnPromotions = $auth->getPermission('updateOwnPromotions');
        $deletePromotions = $auth->getPermission('deletePromotions');
        $deleteOwnPromotions = $auth->getPermission('deleteOwnPromotions');

        $auth->addChild($updatePromotions, $updateOwnPromotions);
        $auth->addChild($deletePromotions, $deleteOwnPromotions);

        return static::EXIT_CODE_NORMAL;
    }

    /**
     * Remove comments RBAC.
     */
    public function actionRemove()
    {
        $auth = Yii::$app->authManager;
        $permissions = array_keys($this->permissions);

        foreach ($permissions as $name => $option) {
            $permission = $auth->getPermission($name);
            $auth->remove($permission);
        }

        $mainPermission = $auth->getPermission($this->mainPermission['name']);
        $auth->remove($mainPermission);

        return static::EXIT_CODE_NORMAL;
    }
}
