<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\db\ActiveRecord;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\SignupForm;
use app\models\ContactForm;
use app\models\AddInfoForm;
use app\models\CategoryForm;
use app\models\Category;
use app\models\ProperName;
use app\models\ProperNameForm;
use app\models\User;


class SiteController extends Controller
{

	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
					'class' => AccessControl::class,
					'only' => ['logout'],
					'rules' => [
						[
							'actions' => ['logout'],
							'allow' => true,
							'roles' => ['@'],
						],
					],
			],
			'verbs' => [
					'class' => VerbFilter::class,
					'actions' => [
						'logout' => ['post'],
					],
			],
		];
	}

		/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		var_dump(Yii::$app->user->id,"User id");
		return [
			'error' => [
					'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
					'class' => 'yii\captcha\CaptchaAction',
					'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	public function actionExtendedSearch(){
		return $this->render('extended-search');
	}

	public function actionListProperNames(){
		return $this->render('list-proper-names');
		}
	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack(); 
		}

		$model->password = '';
		return $this->render('login', [
			'model' => $model,
		]);
	}

	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	public function actionSignup()
	{
		if(!Yii::$app->user->isGuest){
			return $this->goHome();
		}

		$model = new SignupForm();
			
		if ($model->load(Yii::$app->request->post())) {
			if ($user = $model->signup()) {
					if (Yii::$app->getUser()->login($user)) {
						$modelLogin = new LoginForm();
						$modelLogin->login = $model->login;
						$modelLogin->password = $model->password;
						if ($modelLogin->login()) {
							return $this->goHome(); 
						}		
					}
			}
		}

		return $this->render('signup', [
			'model' => $model,
		]);
	}

	public function actionAddNewProperName(){
		$model = new ProperNameForm();
		if(Yii::$app->request->post()){
			$data = Yii::$app->getRequest()->getBodyParams();
			if(isset($data['file'])){
				$dublicates=[];
				foreach ($data as $value) {
					$model->name = $value['name'];
					$model->description = $value['description'];
					$id_category =  (Category::find()
					->select('id')
					->where(['name' => $value['category']])
					->one())['id'];
					if(!$model->getProperName() && !$model->getDescription()){
						Yii::$app->db->createCommand('INSERT INTO `PropersNames` (`name`,`description`,`user_id`,`category_id`) VALUES (:name,:description,:user_id,:category_id)', [
							':name' => $value['name'],
							':description' => $value['description'],
							':user_id' => Yii::$app->user->id,
							':category_id' => $id_category 
						])->execute();
					}else if($model->getProperName()){
						array_push($dublicates,$value['name']);
					}
				}
				if(!empty($dublicates)){
					return \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => [
							'message' => $data,
							'code' => 200,
							'error' => 'dublicates'
						],
					]);
				}else{
					return \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => [
							'message' => $model->category_id = Category::find()
							->select('id')
							->where(['name' => $data[0]['category']])
							->one(),
							'code' => 200,
							'error' => null
						],
					]);
				}
			}
			else if($model->load(Yii::$app->request->post())){
				$dublicates = null;
				if($model->validate()){
					Yii::$app->db->createCommand('INSERT INTO `PropersNames` (`name`,`description`,`user_id`,`category_id`) VALUES (:name,:description,:user_id,:category_id)', [
						':name' => $model->name,
						':description' => $model->description,
						':user_id' => Yii::$app->user->id,
						':category_id' => (int)$model->category_id
					])->execute();
					return $this->render('add-new-proper-name', [
						'model' => $model,
						'message' => "Загрузка данных успешна"
					]);
				}
			}
		}
		
		if(Yii::$app->user->isGuest){
			return $this->goHome();
		}
		return $this->render('add-new-proper-name', [
			'model' => $model,
			'message' => ''
		]);
	}

	public function actionAddNewCategory(){
		$model = new CategoryForm();

		if(Yii::$app->request->post()){
		
			$data = Yii::$app->getRequest()->getBodyParams();
			if(isset($data['file'])){
				$dublicates=[];
				foreach ($data as $value) {
					$model->name = $value['name'];
					if(!$model->getNameCategory()){
						Yii::$app->db->createCommand('INSERT INTO `Category` (`id`,`name`,`ancestor`) VALUES (:id,:name,:ancestor)', [
							':id' => $value['id'],
							':name' => $value['name'],
							':ancestor' => $value['ancestor']
						])->execute();
					}else if($model->getNameCategory()){
						array_push($dublicates,$value['name']);
					}
				}
				if(!empty($dublicates)){
					return \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => [
							'message' => $dublicates,
							'code' => 200,
							'error' => 'dublicates'
						],
					]);
				}else{
					return \Yii::createObject([
						'class' => 'yii\web\Response',
						'format' => \yii\web\Response::FORMAT_JSON,
						'data' => [
							'message' => "Вся загруженная информация занесена!",
							'code' => 200,
							'error' => null
						],
					]);
				}
			}
			else if($model->load(Yii::$app->request->post())){
				$dublicates = null;
				if($model->validate()){
					Yii::$app->db->createCommand('INSERT INTO `Category` (`name`,`ancestor`) VALUES (:name,:ancestor)', [
						':name' => $model->name,
						':ancestor' => $model->ancestor
					])->execute();
					
					return $this->render('add-new-category', [
						'model' => $model,
						'message' => "Загрузка данных успешна"
					]);
				}
				return $this->render('add-new-category', [
					'model' => $model,
					'message' => ""
				]);
			}
		}
		
		if(Yii::$app->user->isGuest){
			return $this->goHome();
		}

		return $this->render('add-new-category', [
			'model' => $model,
			'message' => ""
		]);
	}



	public function actionAbout()
	{
		return $this->render('about');
	}
}
