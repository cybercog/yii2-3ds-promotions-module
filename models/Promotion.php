<?php

namespace yii3ds\promotions\models;

use yii3ds\base\behaviors\PurifierBehavior;
use yii3ds\promotions\Module;
use yii3ds\promotions\traits\ModuleTrait;
use yii3ds\promotions\behaviors\UploadBehavior3ds as UploadBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Class Promotion
 * @package yii3ds\promotions\models
 * Promotion model.
 *
 * @property integer $id ID
 * @property string $title_th Title Thai
 * @property string $title_en Title Eng
 * @property string $detail_th Content thai
 * @property string $detail_en Content Eng
 * @property string $imageThumb Image
 * @property integer $created_at Created time
 * @property integer $create_user User who create this event
 * @property integer $event_type_id Promotion type
 */
class Promotion extends ActiveRecord
{
    use ModuleTrait;

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%promotions}}';
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new PromotionQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            
            'uploadBehavior' => [
                'class' => UploadBehavior::className(),
                'attributes' => [
                    
                    'image' => [
                        'path' => $this->module->imagePath,
                        'tempPath' => $this->module->imagesTempPath,
                        'url' => $this->module->imageUrl
                    ]
                ]
            ],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // Required
            [['title_th', 'title_en'], 'required'],
            // Trim
            [['title_th', 'title_en'], 'trim'],
        ];
    }
}
