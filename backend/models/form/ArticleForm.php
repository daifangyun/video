<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/7
 * Time: 13:28
 */

namespace backend\models\form;

use backend\models\ArticleModel;
use yii\base\Model;

class ArticleForm extends Model
{
    public $title;
    public $abstract;
    public $content;
    public $id;

    private $_article;

    const SCENARIOS_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public function rules()
    {
        return [
            ['id', 'required', 'message' => '{attribute}必须填写'],
            ['id', 'integer', 'min' => 1, 'max' => 11111111111, 'tooSmall' => '{attribute}不符合', 'tooBig' => '{attribute}不符合'],
            [['title', 'abstract', 'content'], 'required', 'message' => '{attribute}必须填写'],
            [['title', 'abstract'], 'string', 'min' => 5, 'max' => 255, 'tooShort' => '{attribute}最少为5位', 'tooLong' => '{attribute}最长为255']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'title' => '标题',
            'abstract' => '摘要',
            'content' => '详情',
        ];
    }

    /**
     * 设置场景
     * @return array
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIOS_CREATE] = ['title', 'abstract', 'content'];
        $scenarios[self::SCENARIO_UPDATE] = ['id', 'title', 'abstract', 'content'];
        return $scenarios;
    }

    /**
     * 创建文章
     * @return ArticleModel|bool
     */
    public function createArticle()
    {
        $articleModel = new ArticleModel();
        $articleModel->title = $this->title;
        $articleModel->abstract = $this->abstract;
        $articleModel->content = $this->content;
        $articleModel->status = ArticleModel::ENABLE_STATUS;
        if ($articleModel->save()) {
            return $articleModel;
        }
        $this->addError('formError', '创建失败,请重试');
        return false;
    }

    /**
     * 根据id查找文章
     * @return static
     */
    public function findArticleById()
    {
        $this->_article = ArticleModel::findOne($this->id);
        return $this->_article;
    }

    /**
     * 修改文章
     * @return bool|static
     */
    public function updateArticle()
    {
        $this->_article->title = $this->title;
        $this->_article->abstract = $this->abstract;
        $this->_article->content = $this->content;
        if ($this->_article->save()) {
            return $this->_article;
        }
        $this->addError('formError', '修改失败,请重试');
        return false;
    }
}