<?php

namespace yii3ds\promotions\traits;

use yii3ds\promotions\Module;

/**
 * Class ModuleTrait
 * @package yii3ds\promotions\traits
 * Implements `getModule` method, to receive current module instance.
 */
trait ModuleTrait
{
    /**
     * @var \yii3ds\promotions\Module|null Module instance
     */
    private $_module;

    /**
     * @return \yii3ds\promotions\Module|null Module instance
     */
    public function getModule()
    {
        if ($this->_module === null) {
            $this->_module = Module::getInstance();
        }
        return $this->_module;
    }
}
