<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/12
 * Time: 10:45
 */

namespace backend\controllers;


use backend\models\CategoryModel;
use backend\models\form\CategoryForm;
use backend\models\form\TagForm;
use backend\models\TagModel;
use yii\data\Pagination;

class TagController extends BaseController
{
    /**
     * 创建
     * @return string
     */
    public function actionCreate()
    {
        $formModel = new TagForm();

        /**
         * 如果为get提交展示创建视图
         */
        if (\Yii::$app->request->isGet) {

            /**
             * 获取分类列表,因为标签是挂在分类下的
             */
            $categorys = CategoryModel::getAllEnableCategory();
            if (empty($categorys)) {
                $emptyCateogry = ['id' => 0, 'name' => '没有分类，请先去添加分类'];
                array_unshift($categorys, $emptyCateogry);
            }


            /**
             * 获取所有标签列表，因为可能给标签添加子标签
             */
            $tags = TagModel::getAllEnableTags();
            $topTag = ['id' => 0, 'name' => '顶级标签'];
            array_unshift($tags, $topTag);

            $formModel->status = 1;

            return $this->render('create', [
                'model' => $formModel,
                'categorys' => $categorys,
                'tags' => $tags,
            ]);
        }

        /**
         * 如果为post提交,做入库操作
         */
        if (\Yii::$app->request->isPost) {

            $session = \Yii::$app->session;

            $formModel->setScenario(TagForm::SCENARIOS_CREATE);
            if ($formModel->load(\Yii::$app->request->post())) {
                if ($formModel->create() !== false) {

                    $session->setFlash('formSuccess', '提交成功 ...');
                    return $this->redirect([\Yii::$app->controller->id . '/' . \Yii::$app->controller->action->id]);
                } else {
                    $session->setFlash('formError', '提交失败 ...');
                }
            } else {
                $session->setFlash('formError', '提交失败 ...');
            }

            /**
             * 获取分类列表,因为标签是挂在分类下的
             */
            $categorys = CategoryModel::getAllEnableCategory();
            if (empty($categorys)) {
                $emptyCateogry = ['id' => 0, 'name' => '没有分类，请先去添加分类'];
                array_unshift($categorys, $emptyCateogry);
            }


            /**
             * 获取所有标签列表，因为可能给标签添加子标签
             */
            $tags = TagModel::getAllEnableTags();
            $topTag = ['id' => 0, 'name' => '顶级标签'];
            array_unshift($tags, $topTag);

            $formModel->status = 1;

            return $this->render('create', [
                'model' => $formModel,
                'categorys' => $categorys,
                'tags' => $tags,
            ]);
        }
    }

    /**
     * 列表页
     * @return string
     */
    public function actionList()
    {
        $query = TagModel::find()->where(['<>', 'status', CategoryModel::STATUS_DELETE]);
        $count = $query->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        $list = $query->orderBy('sort desc')->offset($pages->offset)->limit($pages->limit)->asArray()->all();
        return $this->render('list', ['list' => $list, 'pages' => $pages]);
    }

    /**
     * 修改
     * @return string|\yii\web\Response
     */
    public function actionEdit()
    {
        $formModel = new TagForm();

        /**
         * 如果为get提交展示创建视图
         */
        if (\Yii::$app->request->isGet) {
            $id = (int)\Yii::$app->request->get('id');

            if (!$id) return $this->goBack();

            $formModel->id = $id;
            $model = $formModel->getTagById();
            if ($model === false) {
                return $this->goBack();
            }
            $formModel->name = $model->name;
            $formModel->pid = $model->pid;
            $formModel->cid = $model->cid;
            $formModel->sort = $model->sort;
            $formModel->status = $model->status;

            /**
             * 获取分类列表,因为标签是挂在分类下的
             */
            $categorys = CategoryModel::getAllEnableCategory();
            if (empty($categorys)) {
                $emptyCateogry = ['id' => 0, 'name' => '没有分类，请先去添加分类'];
                array_unshift($categorys, $emptyCateogry);
            }


            /**
             * 获取所有标签列表，因为可能给标签添加子标签
             */
            $tags = TagModel::getAllEnableTags();
            $topTag = ['id' => 0, 'name' => '顶级标签'];
            array_unshift($tags, $topTag);

            return $this->render('edit', [
                'model' => $formModel,
                'categorys' => $categorys,
                'tags' => $tags,
            ]);
        }

        /**
         * 如果为post提交,做入库操作
         */
        if (\Yii::$app->request->isPost) {

            $session = \Yii::$app->session;

            $formModel->setScenario(TagForm::SCENARIO_UPDATE);
            if ($formModel->load(\Yii::$app->request->post())) {
                if ($formModel->edit() !== false) {
                    $session->setFlash('formSuccess', '提交成功 ...');
                } else {
                    $session->setFlash('formError', '提交失败 ...');
                }
            } else {
                $session->setFlash('formError', '提交失败 ...');
            }

            /**
             * 获取分类列表,因为标签是挂在分类下的
             */
            $categorys = CategoryModel::getAllEnableCategory();
            if (empty($categorys)) {
                $emptyCateogry = ['id' => 0, 'name' => '没有分类，请先去添加分类'];
                array_unshift($categorys, $emptyCateogry);
            }


            /**
             * 获取所有标签列表，因为可能给标签添加子标签
             */
            $tags = TagModel::getAllEnableTags();
            $topTag = ['id' => 0, 'name' => '顶级标签'];
            array_unshift($tags, $topTag);

            return $this->render('edit', [
                'model' => $formModel,
                'categorys' => $categorys,
                'tags' => $tags,
            ]);
        }
    }

    /**
     * 删除
     * @return \yii\web\Response
     */
    public function actionDel()
    {
        $id = (int)\Yii::$app->request->get('id');

        if (!$id) return $this->goBack();

        $delRs = TagModel::delById($id);

        $session = \Yii::$app->session;
        if ($delRs) {
            $session->setFlash('formSuccess', '提交成功 ...');
        } else {
            $session->setFlash('formError', '提交失败 ...');
        }
        return $this->redirect([\Yii::$app->controller->id . '/list']);
    }
}