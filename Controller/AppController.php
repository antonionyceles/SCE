<?php
App::uses('Controller', 'Controller');
App::uses('Usuario', 'Model');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $helpers = array(
		'Html',
		'Form',
		'Session',
		'Time',
		'Js' => array('Jquery'),
		'Util'
	);

/**
 * Array containing the names of components this controller uses. Component names
 * should not contain the "Component" portion of the classname.
 *
 * @access public
 * @var array
 * @link http://book.cakephp.org/view/961/components-helpers-and-uses
 */
	public $components = array(
		'RequestHandler',
		'Session',
		'Auth' => array(
			'loginAction' => array('controller' => 'usuarios', 'action' => 'login'),
			'loginRedirect' => array('controller' => 'alunos', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'usuarios', 'action' => 'login'),
			'authorize' => array('Controller'),
		),
	);

/**
 * beforeFilter callback
 *
 * @access public
 * @return void
 */
	public function beforeFilter() {
		$this->RequestHandler->addInputType('json', array('json_decode', true));
		$this->setUpAuth();
		$this->getAnoPadrao();
	}

/**
 * beforeRender callback
 *
 * @access public
 * @return void
 */
	public function beforeRender() {
		$this->setUpUser();
//		$this->set('debugToolbarJavascript', array('libs' => array('/js/jquery.js', '/debug_kit/js/js_debug_toolbar.js')));
	}

/**
 * isAutorized method
 *
 * @access public
 * @param array $usuario
 * @return boolean
 */
	public function isAuthorized($usuario) {
		if (isset($usuario['perfil']) && $usuario['perfil'] == Usuario::PERFIL_ADMIN) {
			return true;
		}
		return false;
	}

/**
 * setUpAuth method
 *
 * @access protected
 * @return void
 */
	protected function setUpAuth() {
		$this->Auth->authenticate = array(
			AuthComponent::ALL => array(
				'userModel' => 'Usuario',
				'fields' => array(
					'username' => 'login',
					'password' => 'senha',
				),
				'scope' => array(
					'Usuario.ativo' => true,
				),
			),
			'Form',
		);
		$this->Auth->authError = 'Você não possui autorização.';
		$this->Auth->flash = array('element' => 'flash_failure', 'key' => 'auth', 'params' => array());
	}

/**
 * setUpUser method
 *
 * @access protected
 * @return void
 */
	protected function setUpUser() {
		$isAdmin = false;
		$userId = $this->Auth->user('id');
		$this->loadModel('Usuario');
		if ($userId) {
			$userData = $this->Usuario->find('first', array('conditions' => array('Usuario.id' => $userId)));
			if ($userData['Usuario']['perfil'] == Usuario::PERFIL_ADMIN) {
				$isAdmin = true;
			}
			$this->set(compact('userData', 'isAdmin'));
		}
	}

/**
 * getAnoPadrao method
 *
 * @access protected
 * @return void
 */
	protected function getAnoPadrao() {
		$this->loadModel('AnoQuestionario');
		$this->set('anoPadrao', $this->AnoQuestionario->find('first', array(
			'order' => 'AnoQuestionario.descricao DESC',
			'contain' => array(),
			'conditions' => array('default' => true)
		)));
	}

}
