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


		// $model = new SignupForm();

		// if ($model->load(Yii::$app->request->post())) {

		// 	// $user = new User();			
		// 	// $user->login = $model->login;
		// 	// $user->email = $model->email;
		// 	// $user->password = $model->password;
		// 	// $user->save();		
		// 	$login = $model->login;
		// 	$email = $model->email;
		// 	$password = $model->password;
		// 	// TODO add checker on user name
		// 	//if()
		// 		Yii::$app->db->createCommand('INSERT INTO `User` (`login`,`email`,`password`) VALUES (:login,:email,:password)', [
		// 			':login' => $login,
		// 			':email' => $email,
		// 			':password' => $password
		// 		])->execute();
		// 	return $this->goHome();
		// } 	

		// return $this->render('signup', [
		// 	'model' => $model,
		// ]);
	}

	public function actionAddNewProperName(){

		$data = Yii::$app->request->post();

		if(Yii::$app->request->post()){

			$data = Yii::$app->getRequest()->getBodyParams();
			return \Yii::createObject([
				'class' => 'yii\web\Response',
				'format' => \yii\web\Response::FORMAT_JSON,
				'data' => [
					'message' => $data,
					'code' => 200,
				],
			]);
		}
		if(Yii::$app->user->isGuest){
			return $this->goHome();
		}

		return $this->render('add-new-proper-name', [
			'data' => $data
		]);
	}

	/**
	 * Displays contact page.
	 *
	 * @return Response|string
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
			Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		}
		return $this->render('contact', [
			'model' => $model,
		]);
	}


	public function actionAbout()
	{
	return $this->render('about');
	}
}
