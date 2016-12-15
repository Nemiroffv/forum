<?php

namespace frontend\controllers;

use common\models\Post;
use common\models\PostSearch;
use common\models\Rating;
use Yii;
use common\models\Topic;
use common\models\TopicSearch;
use app\components\MainController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Event;
use common\models\User;
use yii\web\Response;

/**
 * TopicController implements the CRUD actions for Topic model.
 */
class TopicController extends MainController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Topic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TopicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$test=Post::find()->where(['creator_id'=>Yii::$app->user->identity->id])->all();
        //$count=count($test);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
         //   'count'=>$count
        ]);
    }

    /**
     * Displays a single Topic model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
     //   if(Yii::$app->request->isAjax){

       //     $global=Yii::$app->request->post();
        //    $a=$global['index'];

      //      return $a;


      //  }
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        $newPost = new Post();
     //   $id1=User::find()->where(['identify'=>Yii::$app->user->id])->all();

     //   foreach ($id1 as $key){
     //       $creator=$key->id;
    //    }
    //    if($creator) {
     //       $newPost->creator_id = $creator;
    //    }else
            $newPost->creator_id=Yii::$app->user->id;
        $newPost->topic_id = $id;

      //  if($creator) {

     //       $propusk = Rating::find()->where(['iduser' => $creator, 'idtopic' => $newPost->topic_id])->count();
   //     }else {
            $propusk = Rating::find()->where(['iduser' => Yii::$app->user->id, 'idtopic' => $newPost->topic_id])->count();
            $d=Rating::find()->where(['iduser' => Yii::$app->user->id, 'idtopic' => $newPost->topic_id])->asArray()->all()[0]['reit'];

    //    }

//Рейтинг запись в базу
        if (Yii::$app->request->post()&&Yii::$app->request->isAjax) {

           $l=$post = Yii::$app->request->post();


            if (!$propusk) {


                $rait = new Rating();

                $rait->reit = $post['index'];

                $rait->idtopic = $newPost->topic_id;
          //      if ($creator) {
           //         $rait->iduser = $creator;
              //  } else
                    $rait->iduser = Yii::$app->user->id;

                $rait->save();
            }



        }

        $allRaits = Rating::find()->where(['idtopic' =>$newPost->topic_id])->all();


        $sum=0;$c=0;
        foreach ($allRaits as $key){
            $sum=$key->reit+$sum;
            $c++;
        }
        if($c) {
            $sum = round($sum / $c, 2);
        }

//-------------------------

  //убедимся что это AJAX'овый запрос

        //





        if ($newPost->load(Yii::$app->request->post()) && $newPost->save()) {
            return $this->redirect(['view', 'id' => $id]);
        }



        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelPost' => $newPost,
            'sum'=>$sum,
            'ch'=>$c,
            'propusk'=>$propusk,
            'd'=>$d,


        ]);
    }

    /**
     * Creates a new Topic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Topic();

         //$id=User::find()->where(['identify'=>Yii::$app->user->id])->all();
        // foreach ($id as $key){
         //    $creator=$key->id;
         //}

        $model->creator_id = Yii::$app->user->id;;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $this->uploadImage($model, 'image');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Topic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $image = $model->image;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->delete_image) {
                if ($image) {
                    $this->deleteImage($model, 'image', $image);
                }
                $model->image = null;
            } else {
                $this->uploadImage($model, 'image', $image);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Topic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $model2 = $this->findModel($id);

        if($model->delete()){
            if($model2->image){
                $this->deleteImage($model2, 'image', $model2->image);
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Topic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Topic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Topic::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionGo($id){

        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        $newPost = new Post();

        //    if($creator) {
        //       $newPost->creator_id = $creator;
        //    }else
        $newPost->creator_id=Yii::$app->user->id;
        $newPost->topic_id = $id;

        //  if($creator) {



        //     }else {


        //    }

//Рейтинг запись в базу
        $propusk = Rating::find()->where(['iduser' => Yii::$app->user->id, 'idtopic' => $newPost->topic_id])->count();
        $d=Rating::find()->where(['iduser' => Yii::$app->user->id, 'idtopic' => $newPost->topic_id])->asArray()->all()[0]['reit'];

        //    }

//Рейтинг запись в базу




        $allRaits = Rating::find()->where(['idtopic' =>$newPost->topic_id])->all();


        $sum=0;$c=0;
        foreach ($allRaits as $key){
            $sum=$key->reit+$sum;
            $c++;
        }
        if($c) {
            $sum = round($sum / $c, 2);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!Yii::$app->user->isGuest)

        return ['percents'=>$sum*20,'rezult'=>$c];
    }
}
