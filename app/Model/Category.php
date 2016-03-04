<?php

class Category extends AppModel {
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'Введите название категории.'
        ));
}