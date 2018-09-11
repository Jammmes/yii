<?php

namespace app\controllers;

use app\behaviors\EventAccessBehavior;
use app\objects\viewModels\EventView;
use Yii;
use app\models\Event;
use app\models\search\EventSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\HttpCache;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'eventAccess' => [
                'class' => EventAccessBehavior::class,
                'except' => ['index','list'],
                'rules' => [
                    ['allow' => true, 'roles' => ['@']],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index','create','update','delete'],
                'rules' => [
                    ['allow' => true, 'roles' => ['@']],
                ]
                ],
            'httpCache' => [
                'class' => HttpCache::class,
                'only' => ['view'],
                'lastModified' => function () {
                    $id = \Yii::$app->request->get('id');
                    $model = $this->findModel($id);

                    return $model ? \strtotime($model->updated_at) : 0;
                }
            ]
        ];
    }

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $viewModel = new EventView();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'viewModel' => $viewModel,
        ]);
    }


    /**
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $viewModel = new EventView();

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'viewModel' => $viewModel,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if (!(new EventAccessChecker)->isAllowedToWrite($model)) {
            throw new ForbiddenHttpException('У Вас нет доступа к созданию события');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if (!(new EventAccessChecker)->isAllowedToWrite($model)) {
            throw new ForbiddenHttpException('У Вас нет доступа к удалению события');
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Метод выводит все атрибуты из модели Event в формате JSON
     */
    public function actionJson()
    {

        header('content-type:text/plain');

        $model = new Event();

        $attributes = $model->getAttributes();

        $json_attr = json_encode($attributes);

        var_dump($json_attr);

        exit;

    }
}
