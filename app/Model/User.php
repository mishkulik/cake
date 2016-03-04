<?php 
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class User extends AppModel {
    public $validate = array(
        'username' => 'notEmpty',
        'password' => 'notEmpty'
    );
    
    
    
    // Регистрация нового пользователя
    /*public function beforeSave ($options = array()) {
        if ( isset($this->data[$this->alias]['password']) ) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }*/
}