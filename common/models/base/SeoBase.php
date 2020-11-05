<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "seo".
 *
 * @property int $id 自增ID
 * @property string $name 页面名称
 * @property int $web 站点: 0-PC端, 1-M端
 * @property string $uri 路由地址
 * @property string $title SEO标题
 * @property string $keywords SEO关键词
 * @property string $description SEO描述
 * @property string $demo_page 示例页面
 * @property int $enabled 已启用
 * @property string $create_time 创建时间
 * @property string $update_time 更新时间
 */
class SeoBase extends \common\extensions\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'uri'], 'required'],
            [['web', 'enabled'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name'], 'string', 'max' => 45],
            [['uri', 'title', 'keywords', 'description', 'demo_page'], 'string', 'max' => 255],
            [['web', 'uri'], 'unique', 'targetAttribute' => ['web', 'uri']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增ID',
            'name' => '页面名称',
            'web' => '站点: 0-PC端, 1-M端',
            'uri' => '路由地址',
            'title' => 'SEO标题',
            'keywords' => 'SEO关键词',
            'description' => 'SEO描述',
            'demo_page' => '示例页面',
            'enabled' => '已启用',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
