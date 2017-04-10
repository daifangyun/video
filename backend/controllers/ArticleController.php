<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/10
 * Time: 13:28
 */

namespace backend\controllers;

use backend\models\ArticleModel;
use backend\models\form\ArticleForm;
use yii\data\Pagination;

class ArticleController extends BaseController
{
    /**
     * 获取文章列表
     * @return string
     */
    public function actionList()
    {
        $query = ArticleModel::find()->where(['status' => ArticleModel::ENABLE_STATUS]);
        $count = $query->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $articles = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('list', ['articles' => $articles, 'pages' => $pages]);
    }

    /**
     * 创建文章
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new ArticleForm();

        if (\Yii::$app->request->isPost) {
            $model->setScenario($model::SCENARIOS_CREATE);
            if ($model->load(\Yii::$app->request->post()) && $model->validate() && $model->createArticle()) {
                return $this->redirect([\Yii::$app->controller->id . '/' . 'list']);
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * 修改文章
     * @return string|\yii\web\Response
     */
    public function actionEdit()
    {
        /**
         * 如果为get提交,获取文章信息
         */
        if (\Yii::$app->request->isGet) {
            $id = (int)\Yii::$app->request->get('id');
            if (!$id) {
                return $this->goHome();
            }
            $formModel = new ArticleForm();
            $formModel->id = $id;
            $article = $formModel->findArticleById();

            if (!$article) {
                return $this->goHome();
            }

            $formModel->setAttributes($article->toArray());
            return $this->render('edit', ['model' => $formModel]);
        }

        /**
         * 如果为post提交,修改数据
         */
        if (\Yii::$app->request->isPost) {
            $formModel = new ArticleForm();
            $formModel->setScenario(ArticleForm::SCENARIO_UPDATE);
            if ($formModel->load(\Yii::$app->request->post(), 'ArticleForm') && $formModel->validate()) {
                $article = $formModel->findArticleById();

                if (!$article) {
                    return $this->goHome();
                }

                if ($formModel->updateArticle()) {
                    return $this->redirect(['/' . \Yii::$app->controller->id . '/list']);
                } else {
                    return $this->render('edit', ['model' => $formModel]);
                }
            } else {
                return $this->render('edit', ['model' => $formModel]);
            }
        }
    }

    public function actionDel()
    {
        if (\Yii::$app->request->isGet) {
            $id = \Yii::$app->request->get('id');
            if (!$id) {
                return $this->goHome();
            }
            $article = ArticleModel::findOne($id);

            if (!$article or $article->status == ArticleModel::DISABLE_STATUS) {
                return $this->goBack();
            }

            $article->status = ArticleModel::DISABLE_STATUS;
            $article->save();

            return $this->redirect([\Yii::$app->controller->id . '/list']);
        } else {
            return $this->goBack();
        }
    }
}