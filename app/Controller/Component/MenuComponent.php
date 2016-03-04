<?php
class MenuComponent extends Component {
    
    public function getMainMenu () {
        $pageModel = ClassRegistry::init('Page');
        $main_menu = Cache::read('main_menu', 'short_forMainMenu');
        if (!$main_menu) { // Если из кэша ничего не вытащили
            $main_menu = $pageModel->find('all', array(
                'fields' => array('id', 'alias', 'title')
            ));
            Cache::write('main_menu', $main_menu, 'short_forMainMenu');
        }
        return $main_menu;
        
    }
    
    public function getCatMenu ($admin = false) {
        $categoryModel = ClassRegistry::init('Category');
        if ( $admin ) {
            $cat_menu_tree = $categoryModel->find('threaded');
            $cat_menu = $this->_catMenuHtml($cat_menu_tree, $admin); // _catMenuHtml описана ниже
            return $cat_menu;
        }else{
            $cat_menu = Cache::read('cat_menu', 'short_forCatMenu');
            if (!$cat_menu) {
                $cat_menu_tree = $categoryModel->find('threaded');
                $cat_menu = $this->_catMenuHtml($cat_menu_tree, $admin); // _catMenuHtml описана ниже
                Cache::write('cat_menu', $cat_menu, 'short_forCatMenu');
            }
            return $cat_menu;
        }
        
    }
    
    protected function _catMenuHtml ($cat_menu_tree = false, $admin) {
        if (!$cat_menu_tree) return false;
        $html = '';
        foreach($cat_menu_tree as $item) {
            $html .= $this->_catMenuTemplate($item, $admin); 
        }
        return $html;
    }
    // Эта функция складывает данные из БД в буфер, а затем возвращает их оттуда.
    protected function _catMenuTemplate ($category, $admin) {
        ob_start();
        include APP.'View'.DS.'Elements'.DS.'menu_tpl.ctp';// В шаблоне menu_tpl.ctp у нас будет готовая разметка, в которую мы будем просто вставлять данные.
        return ob_get_clean(); // Данная функция возвращает содерживое буфера и очищает после этого буфер.
    }
}