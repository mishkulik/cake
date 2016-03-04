<?php

class CategoriesController extends AppController {
    public $uses = array('Category', 'Product');
    public $components = array('Paginator');
    
    
    public function index ($cat_id = null) { // $cat_id = null мы сделали, чтобы предусмотреть возможность ввода
                                            //несуществующей категории пользователем
        if (is_null($cat_id)) {
            // Получаем все товары категории (когда нет параметров в адресной строке)
            $this->Paginator->settings = array(
                'fields' => array('id', 'title', 'price', 'img'),
                'recursive' => -1,
                'limit' => 3
            );
            $products = $this->Paginator->paginate('Product');
            
            // Получаем корневые категории для левого сайдбара
            
            $cats = $this->Category->find('all', array(
                'conditions' => array('parent_id' => 0)
            ));
            $cats_menu_sidebar = $this->_catsMenuSidebar($cats, $cat_id = 0);
            $cats_menu_sidebar[$cat_id][$cat_id] = 'Каталог';
            return $this->set(compact('products', 'cats_menu_sidebar', 'cat_id'));
        }
        
        if (!(int)$cat_id || !$this->Category->exists($cat_id)) {
            // Ввели строку или 0 || такой категории нет (404 ошибка)
            throw new NotFoundException(__('Такой страницы нет...'));  
        }
        
        // Получение какой-либо конкретной категории вместе с подкатегориями
        $cats = $this->Category->find('all');
        $ids = $this->_catsIds($cats, $cat_id);
        $ids = !$ids ? $cat_id : $ids.$cat_id; // Если нет подкатегорий, то запишем переданную из адресной строки, если есть - то допишем ещё и саму переданную категорию (где могут быть товары, не занесённые ни в одну из категорий). 
        $ids = explode(',', $ids); // Так сделали, чтобы у кейка смог сработать оператор IN, которому нужны не значения через запятую (как обычно в SQL), а массив этих значений.
        $this->Paginator->settings = array(
            'conditions' => array('Product.category_id' => $ids),
            'fields' => array('id', 'title', 'price', 'img'),
            'recursive' => -1,
            'limit' => 3
        );
        $products = $this->Paginator->paginate('Product');
        
        // Получаем 1 уровень дочерних категорий
        
        $cats_menu_sidebar = $this->_catsMenuSidebar($cats, $cat_id);
        /*echo '<pre>';
        print_r($cats_menu_sidebar);
        echo '</pre>';*/
        //debug($cats_menu_sidebar);
        return $this->set(compact('products', 'cats_menu_sidebar', 'cat_id'));
    }
    
    
    protected function _catsMenuSidebar ($cats, $cat_id) {
        $data = array();
        foreach($cats as $item){
            if($item['Category']['id'] == $cat_id){
                $data[$cat_id][$cat_id] = $item['Category']['title'];
            }
            if($item['Category']['parent_id'] == $cat_id){
                $data[$cat_id]['Children'][$item['Category']['id']] = $item['Category']['title'];
            }
        }
        return $data;
    }
    
    
    // Получение абсолютно всех дочерних категорий у одного родителя
    protected function _catsIds ($cats, $cat_id) {
        $data = '';
        foreach($cats as $item) {
            if ($item['Category']['parent_id'] == $cat_id) {
                $data .= $item['Category']['id'].','; // Здесь мы вычислили id-ники дочерних категорий.
                $data .= $this->_catsIds($cats, $item['Category']['id']); // Рекурсивный вызов функции.
            }
        }
        return $data;
    }
    
    
    /** Админская зона */
    
    public function admin_index ($cat_id = null) {
        $this->index($cat_id);
    }
    
    public function admin_add () {
        if ( $this->request->is('post') ) {
            $this->Category->create();
            if ( $this->Category->save($this->request->data) ) {
                $this->Session->setFlash('Категория добавлена', 'default', array('class' => 'ok'));
                return $this->redirect($this->referer());
            }else{
                $this->Session->setFlash('Ошибка', 'default', array('class' => 'error'));
            }
        }
        $cats = $this->Category->find('threaded');
        $categories = $this->_catsSelect($cats, 0);
        $this->set(compact('categories'));
    }

    /** Для формирования списка категорий */
    protected function _catsSelect ($cats, $category_id, $tab = '') {
        $string = '';
        foreach($cats as $item) {
            $string .= $this->_catsSelectTemplate($item, $category_id, $tab);
        }
        return $string;
        
    }
    
    protected function _catsSelectTemplate ($category, $category_id, $tab) {
        ob_start();
        include APP.'View/Elements/cats_select_tpl.ctp';
        return ob_get_clean();
    }
    /** Для формирования списка категорий */
    
    public function admin_edit ( $category_id = null ) {
        if ( is_null($category_id) || !(int)$category_id ) {
            throw new NotFoundException('Такой страницы нет.');
        }
        $category = $this->Category->findById($category_id);
        if ( !$category ) {
            throw new NotFoundException('Такой страницы нет.');
        }
        
        if ( $this->request->is(array('post', 'put')) ) {
            $this->Category->id = $category_id;
            if ( $this->request->data['Category']['parent_id'] != $category_id ) {
                // Если пользователь что-то поменял в списке категорий
                if ( $this->Category->save($this->request->data) ) {
                    $this->Session->setFlash('Сохранено.', 'default', array('class' => 'ok'));
                    return $this->redirect("/admin/category/{$category_id}");
                }
            }else{
                if ( $this->Category->saveField('title', $this->request->data['Category']['title'], true) ) {
                    $this->Session->setFlash('Сохранено.', 'default', array('class' => 'ok'));
                    return $this->redirect("/admin/category/{$category_id}");
                }
            }
            $this->Session->setFlash('Ошибка.', 'default', array('class' => 'error'));
        }
        
        $this->request->data = $category;
        $cats = $this->Category->find('threaded');
        $categories = $this->_catsSelect($cats, $category_id);
        $this->set(compact('categories', 'category'));
    }
    
    public function admin_delete ( $category_id ) {
        if ( !$this->Category->exists($category_id) ){
            throw new NotFoundException('Такой страницы нет, либо она уже удалена.');
        }
        if ( is_null($category_id) || !(int)$category_id ) {
            throw new NotFoundException('Такой страницы нет.');
        }
        if ( $this->request->is('get') ) {
            throw new MethodNotAllowedException();
        }
        // Проверка на наличие подкатегорий
        $cats = $this->Category->find('first', array(
            'conditions' => array('parent_id' => $category_id)
        ));
        if ( $cats ) {
            $this->Session->setFlash('Ошибка, нельзя удалить категорию, в которой есть подкатегории.', 'default', array('class' => 'error'));
            $this->redirect($this->referer());
        }
        // Проверка на наличие продуктов у категории
        $products = $this->Product->find('first', array(
            'conditions' => array('category_id' => $category_id)
        ));
        if ( $products ) {
            $this->Session->setFlash('Ошибка, нельзя удалить категорию, в которой есть товары.', 'default', array('class' => 'error'));
            $this->redirect($this->referer());
        }
        
        if ( $this->Category->delete($category_id) ) {
            $this->Session->setFlash('Категория удалена.', 'default', array('class' => 'ok'));
            return $this->redirect('/admin/');
        }else{
            $this->Session->setFlash('Ошибка при удалении категории.', 'default', array('class' => 'error'));
        }
    }
    
    
    
    
    
    
}