<?php

class Page extends AppModel {
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'Введите название страницы.'
        ),
        'body' => array(
            'rule' => 'notEmpty',
            'message' => 'Введите описание страницы.'
        ),
        'alias' => array(
            'rule1' => array(
                'rule' => 'isUnique',
                'message' => 'Такой алиас уже существует. Попробуйте другое название алиаса.'
            ),
            'rule2' => array(
                'rule' => 'alphaNumeric',
                'message' => 'Должны быть только буквы и цифры.'
            )
        )
    );
}