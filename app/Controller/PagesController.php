<?php
App::uses('CakeEmail', 'Network/Email');
class PagesController extends AppController {
    
    public function index ($page_alias = null) {
        if ( is_null($page_alias) ) {
            throw new NotFoundException('Такой страницы не существует...');
        }
        $page = $this->Page->findByAlias($page_alias);
        $title_for_layout = $page['Page']['title'];
        $meta['keywords'] = $page['Page']['keywords'];
        $meta['description'] = $page['Page']['description'];
        if ( !$page ) {
            throw new NotFoundException('Такой страницы не существует...');
        }
        $this->set(compact('page_alias', 'page', 'meta', 'title_for_layout'));
    }
    
    public function sendmail () {
        if ( !empty($this->request->data) ) {
            $email = new CakeEmail();
            //$email->config('default');
            $email->from(array('admin@cake.loc' => 'Administration of Cake.loc'))
                ->to('michael.187@mail.ru')
                ->subject($this->request->data['Page']['subject']);
            $text = "Email: {$this->request->data['Page']['email']}\n";
            $text .= "Сообщение: {$this->request->data['Page']['body']}";
            if ( $email->send($text) ){
                $this->Session->setFlash('Ваше письмо успешно отправлено.', 'default', array('class' => 'ok'));
                return $this->redirect($this->referer());
            }else{
                $this->Session->setFlash('Произошла ошибка при отправке письма', 'default', array(
                'class' => 'error'
                ));
                return $this->redirect($this->referer());
            }  
        }
    }
    
    /** Админка */
    
    public function admin_index () {
        $pages = $this->Page->find('all', array(
            'fields' => array('id', 'title')
        ));
        $this->set(compact('pages'));
    }
    
    public function admin_add () {
        if ( $this->request->is('post') ) {
            $this->Page->create();
            if ( $this->Page->save($this->request->data) ) {
                $this->Session->setFlash('Страница добавлена.', 'default', array('class' => 'ok'));
                $this->redirect('/admin/page');
            }else{
                $this->Session->setFlash('Ошибка при добавлении старницы.', 'default', array('class' => 'error'));
            }
        }
    }
    
    public function admin_edit ( $page_id = null ) {
        if ( is_null($page_id) || !(int)$page_id || !$this->Page->exists($page_id) ) {
            throw new NotFoundException('Такой страницы нет.');
        }
        $page = $this->Page->findById($page_id);
        
        if ( $this->request->is(array('post', 'put')) ) {
            $this->Page->id = $page_id;
            if ( $this->Page->save($this->request->data) ) {
                $this->Session->setFlash('Сохранено', 'default', array('class' => 'ok'));
                return $this->redirect('/admin/page');
            }else{
                $this->Session->setFlash('Ошибка.', 'default', array('class' => 'error'));
            }
        }
        
        if ( !$this->request->data ) {
            $this->request->data = $page; // - подстановка существующих данных в поля формы
        }
        $this->set(compact('page'));
    }
    
    public function admin_delete ( $id ) {
        if ( !$this->Page->exists($id) ){
            throw new NotFoundException('Такой страницы не существует.');
        }
        if ( $this->request->is('get') ) {
            throw new MethodNotAllowedException();
        }
        if ( $this->Page->delete($id) ) {
            $this->Session->setFlash('Страница удалена.', 'default', array('class' => 'ok'));
        }else{
            $this->Session->setFlash('Ошибка при удалении страницы.', 'default', array('class' => 'error'));
        }
        return $this->redirect($this->referer());
    }
    
    
    
    
}
