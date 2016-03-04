<?php

class UsersController extends AppController {
    public function login () {
        if ( $this->request->is('post') ) {
            if ( $this->Auth->login() ) {
                return $this->redirect($this->Auth->redirectUrl()); // на тот адрес, который был запрошен до авторизации 
            }
            $this->Session->setFlash('Неверный логин или пароль.', 'default', array('class' => 'error'));
        }
    }
    public function logout () {
        return $this->redirect($this->Auth->logout()); // здесь редирект туда, куда мы определили при подключении компонента Auth в AppController    
    }
}