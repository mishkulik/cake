<?php

class ProductsController extends AppController {
    
    public $uses = array('Category', 'Product');
    public $components = array('Paginator');
    
    public function index ($p_id = null) {
        // Проходим проверки по адресной строке
        if ( is_null($p_id) || !(int)$p_id || !$this->Product->exists($p_id) ) {
            throw new NotFoundException('Такой страницы нет.');
        }
        
        // Получаем данные продукта
        
        $product = $this->Product->find('first', array(
            'conditions' => array('Product.id' => $p_id),
            'recursive' => -1
        ));
        $this->set(compact('product'));
    }
    
    public function search () {
        $search = !empty($_GET['q']) ? $_GET['q'] : null;
        if (is_null($search) || mb_strlen($search, 'UTF-8') < 3) {
            return $this->set('search_res', 'Введите поисковый запрос. (Минимальная дляна строки - 3 символа.)');
        }
        // Если ввели что-то форму поиска, то делаем поиск по БД продуктов
        $this->Paginator->settings = array(
            'conditions' => array('Product.title LIKE' => '%'.$search.'%'),
            'fields' => array('id', 'title', 'price', 'img'),
            'recursive' => -1,
            'limit' => 3
        );
        $search_res = $this->Paginator->paginate('Product');
        
        /** Левого сайдбара */
        // Получаем корневые категории
        $cats = $this->Category->find('all', array(
            'conditions' => array('parent_id' => 0)
        ));
        // Получаем 1 уровень дочерних категорий
        $cats_menu_sidebar = $this->_catsMenuSidebar($cats, $cat_id = 0);
        $cats_menu_sidebar[$cat_id][$cat_id] = 'Каталог';
        /** Левого сайдбара */
        $this->set(compact('search_res', 'cats_menu_sidebar', 'cat_id'));
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
    
    
    /** Для админки */
    
    public function admin_add ($category_id = null) {
        if ( $this->request->is('post') ) {
            //debug($this->request->data);
            $data = $this->request->data['Product'];
            if ( !$data['img']['name'] ) {
                unset($data['img']);
            }
            $this->Product->create();
            if ( $this->Product->save($data) ) {
                $this->Session->setFlash('Товар успешно добавлен.', 'default', array('class' => 'ok'));
                return $this->redirect("/admin/category/$category_id");
            }else{
                $this->Session->setFlash('Ошибка при добавлении товара.', 'default', array('class' => 'error'));
            }
        }
        
        /** Скрикт подстановки выбранной категории */
        // Построим категории в шаблоне в виде дерева
        $cats = $this->Category->find('threaded', array(
            'fields' => array('id', 'title', 'parent_id')
        ));
        $categories = $this->_catsSelect($cats, $category_id);
        
        $this->set(compact('categories'));
        /** Скрикт подстановки выбранной категории */
    }
    
    public function admin_edit ($p_id = null) {
        /** Скрикт редактирования данных */
        if ( is_null($p_id) || !(int)$p_id ) {
            throw new NotFoundException('Такой страницы нет...');
        }
        $product = $this->Product->findById($p_id);
        if ( !$product ) {
            throw new NotFoundException('Такой страницы нет...');
        }
        
        if ( $this->request->is(array('post', 'put')) ) {
            $data = $this->request->data['Product'];
            $this->Product->id = $p_id;
            if ( isset($data['del_img']) && $data['del_img'] == '1' && !$data['img']['name'] ) {
                $this->Product->saveField('img', null);
            }
            if ( !$data['img']['name'] ) {
                unset($data['img']);
            }
            if ( $this->Product->save($data) ) {
                $this->Session->setFlash('Товар успешно редактирован.', 'default', array('class' => 'ok'));
                return $this->redirect($this->referer());
            }
            else{
                $this->Session->setFlash('Ошибка...', 'default', array('class' => 'error')); 
            }
        }
        /** Скрикт редактирования данных */
        
        /** Скрикт подстановки существующих данных в поля формы */
        if ( !$this->request->data ) {
            $this->request->data = $product;
            //$categories = $this->Product->Category->find('list');
            
            // Построим категории в шаблоне редактирования товара в виде дерева
            $cats = $this->Category->find('threaded', array(
                'fields' => array('id', 'title', 'parent_id')
            ));
            $categories = $this->_catsSelect($cats, $product['Category']['id']);
        }
        $this->set(compact('categories', 'product'));
        /** Скрикт подстановки существующих данных в поля формы */
    }
    
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
    
    public function admin_delete ( $p_id = null ) {
        if ( !$this->Product->exists($p_id) ){
            throw new NotFoundException('Такого товара не существует. Либо он уже удалён.');
        }
        if ( $this->request->is('get') ) {
            throw new MethodNotAllowedException();
        }
        if ( $this->Product->delete($p_id) ) {
            $this->Session->setFlash('Товар удалён.', 'default', array('class' => 'ok'));
        }else{
            $this->Session->setFlash('Ошибка при удалении товара.', 'default', array('class' => 'error'));
        }
        return $this->redirect($this->referer());
    }
    
}