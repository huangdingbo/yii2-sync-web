<?php

namespace dsj\sync\web;

/**
 * sync module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'dsj\sync\web\controllers';

    public $defaultRoute = 'index';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
