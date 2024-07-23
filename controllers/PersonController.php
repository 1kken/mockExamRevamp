<?php

namespace app\controllers;

use app\models\Person;
use app\models\PersonSearch;
use app\models\Population;
use Yii;
use yii\db\Expression;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PersonController implements the CRUD actions for Person model.
 */
class PersonController extends Controller
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
                            'actions'=>['index'],
                            'allow'=>true,
                            'roles'=>['@']
                        ],
                        [
                            'actions'=>['view','update','delete','create'],
                            'allow'=>true,
                            'roles'=>['managePerson'],
                            'roleParams'=>function () {
                                $id = Yii::$app->request->get('id');
                                $person = Person::findOne(['id'=>$id]);
                                return ['person'=>$person];
                            }
                        ],
                    ],
                ]
            ]
        );
    }

    /**
     * Lists all Person models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PersonSearch();
        $queryParamsOverWrited = $this->overWriteSearchParams($this->request->queryParams,Yii::$app->user->identity->getParamsPersonIndex(),);
        $dataProvider = $searchModel->search($queryParamsOverWrited);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Person model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Person model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Person();

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
     * Updates an existing Person model.
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
     * Deletes an existing Person model.
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
     * Finds the Person model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Person the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Person::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMasterlist($region=null,$province=null,$citymun=null){
        $params = [];
        if(isset($region)){
            if(trim($region)!=''){
                $params += ['region_c'=>$region];
            }
        }
        if(isset($province)){
            if(trim($province)!=''){
                $params += ['province_c'=>$province];
            }
        }
        if(isset($citymun)){
            if(trim($citymun)!=''){
                $params += ['citymun_id'=>$citymun];
            }
        }
        $gender = ['male','female'];
        $status = [
                0=>'Under Investigation',
                1=>'Surrendered',
                2=>'Apprehended',
                3=>'Escaped',
                4=>'Deceased'
            ];

        //get all person with params
        $persons = Person::find()->where($params)
            ->select([new Expression('CONCAT(first_name," ",last_name) as name'),'birthdate',
                new Expression('TIMESTAMPDIFF(YEAR,birthdate,NOW()) as age'),'sex',
                'region_c','province_c','citymun_id','district_c','contact_info','status'])
            ->with('citymun','provinceC','regionC')
            ->asArray()
            ->all();
            $final = [];
            foreach ($persons as $person) {
                $final[] = [
                    'name' => $person['name'],
                    'birthdate' => $person['birthdate'],
                    'age' => $person['age'],
                    'sex' => $gender[intval($person['sex'])],
                    'region' => $person['regionC']['region_m'],
                    'province' => $person['provinceC']['province_m'],
                    'citymun' => $person['citymun']['citymun_m'],
                    'district' => $person['district_c'],
                    'contact_info' => $person['contact_info'],
                    'status' => $status[$person['status']],
                ];
            }

            return Json::encode($final);
    }

    private function overWriteSearchParams($searchParams,$params){
        foreach ($params as $key=>$value){
            $searchParams['PersonSearch'][$key] = $value;
        }
        return $searchParams;
    }
}
