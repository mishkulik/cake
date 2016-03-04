<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    public $components = array('DebugKit.Toolbar', 'Menu', 'Session', 'Auth' => array(
        'loginRedirect' => '/admin/',
        'logoutRedirect' => '/', // Здесь мы вольны записывать любой другой адрес.
        'authenticate' => array(
            'Form' => array(
                'passwordHasher' => 'Blowfish'
            )
        )
    ));
    public $helpers = array('Html', 'Form', 'Session');
    
    public function beforeFilter () {
        parent::beforeFilter();
        // Включение файлового менеджера KCFINDER для авторизованного пользователя
        if (AuthComponent::user() ) {
            $_SESSION['KCFINDER'] = array('disabled' => false);
        }
        $admin = ( isset($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin' ) ? '/admin' : false;
        
        // Открытие всей пользовательской части сайта
        if ( !$admin ) $this->Auth->allow();
        // Подключение своего шаблона
        if ( $admin ){
            // Для админки
            $this->layout = 'santana_admin';
        }else{
            // Для пользовательской части
            $this->layout = 'santana';
        }
        
        $cat_menu = $this->Menu->getCatMenu($admin);
        $main_menu = $this->Menu->getMainMenu();
        $this->set(compact('cat_menu', 'main_menu'));
    }

}   





