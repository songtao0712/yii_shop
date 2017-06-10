<?php
/**
 * Created by PhpStorm.
 * User: TT
 * Date: 2017/6/8
 * Time: 18:48
 */

namespace backend\controllers;

use backend\models\Category;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class CategoryController extends Controller{

    //完成分类展示功能
    public function actionIndex(){
        $model = Category::find();
        $total = $model->count();
        $page = new Pagination(
            [
                'totalCount'=>$total,//总条数
                'defaultPageSize'=>5,//每页显示多少条数据
            ]
        );

        $cate = $model->offset($page->offset)->limit($page->limit)->all();
        return $this->render('index',['cate'=>$cate,'page'=>$page]);
    }


    //完成文章分类的添加功能
    public function actionAdd(){
        $model = new Category();
        $request = new Request();
        //接收数据
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            //验证数据
            if($model->validate()){
                //保存数据
                $model->save();
                //跳转
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['category/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }

    //完成删除功能
    public function actionDel($id){
        $model = Category::findOne($id);

        //删除
        $model->delete();
    }

    //完成修改功能
    public function actionEdit($id){
        $model = Category::findOne($id);
        $request = new Request();
        //接收数据
        if($request->isPost){
            //加载数据
            $model->load($request->post());
            //验证数据
            if($model->validate()){
                //保存数据
                $model->save();
                //跳转
                \Yii::$app->session->setFlash('success','修改成功');
                return $this->redirect(['category/index']);
            }else{
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }
}