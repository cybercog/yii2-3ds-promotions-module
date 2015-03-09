<?php

namespace yii3ds\promotions;

use yii\base\BootstrapInterface;

/**
 * Products module bootstrap class.
 */
class Bootstrap implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {

        // Add module URL rules.
        $app->getUrlManager()->addRules(
            [
                'POST <_m:promotions>' => '<_m>/default/index',
                'POST <_m:promotions>/<id:\d+>' => '<_m>/default/index',
                '<_m:promotions>' => '<_m>/default/index',
                '<_m:promotions>/<id:\d+>' => '<_m>/default/index',
                '<_m:promotions>/<controller:\w+>' => '<_m>/<controller>/index',
                'POST <_m:promotions>/<controller:\w+>' => '<_m>/<controller>/create',
            ]
        );
        // Add module I18N category.
        if (!isset($app->i18n->translations['yii3ds/promotions']) && !isset($app->i18n->translations['yii3ds/*'])) {
            $app->i18n->translations['yii3ds/promotions'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => '@yii3ds/promotions/messages',
                'forceTranslation' => true,
                'fileMap' => [
                    'yii3ds/promotions' => 'promotions.php',
                ]
            ];
        }
    }
}
