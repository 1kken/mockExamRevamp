<?php

namespace app\controllers;

use app\models\Population;
use app\models\PopulationSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use function PHPUnit\Framework\throwException;

/**
 * PopulationController implements the CRUD actions for Population model.
 */
class PopulationController extends Controller
{

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
                'access'=>[
                    'class'=>AccessControl::class,
                    'rules'=>[
                        [
                            'actions'=>['index','view','update','delete'],
                            'allow'=>true,
                            'roles'=>['managePopulation'],
                            'roleParams'=>function () {
                                $id = Yii::$app->request->get('id');
                                $population = Population::findOne(['id'=>$id]);
                                return ['population'=>$population];
                            }
                        ],
                    ]
                ]
            ]
        );
    }

    /**
     * Lists all Population models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PopulationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $queryParamsOverWrited = $this->overWriteSearchParams($this->request->queryParams,Yii::$app->user->identity->getParamsPersonIndex(),);
        $dataProvider = $searchModel->search($queryParamsOverWrited);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    private function overWriteSearchParams($searchParams,$params){
        foreach ($params as $key=>$value){
            $searchParams['PersonSearch'][$key] = $value;
        }
        return $searchParams;
    }

    /**
     * Displays a single Population model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException
     */
    public function actionView($id)
    {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
    }

    /**
     * Creates a new Population model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Population();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Population model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Population model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Population model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Population the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Population::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
