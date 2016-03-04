<?php

class Product extends AppModel {
    public $belongsTo = 'Category';
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty',
            'message' => 'Введите название товара.'
        ),
        'body' => array(
            'rule' => 'notEmpty',
            'message' => 'Введите описание товара.'
        ),
        'price' => array(
            'rule' => 'numeric',
            'message' => 'В этом поле должны быть введены только цифры.'
        ),
        'img' => array(
        /* Стандартные правила */
            'uploadError' => array(
                'rule' => 'uploadError',
                'message' => 'Ошибка, файл не загружен.',
                'allowEmpty' => true
            ),
            'mimeType' => array(
                'rule' => array('mimeType', array('image/gif', 'image/png', 'image/jpg', 'image/jpeg')),
                'message' => 'К загрузке разрешены картинки с расширением jpg, png и gif',
                'allowEmpty' => true
            ),
            'fileSize' => array(
                'rule' => array('fileSize', '<=', '1MB'),
                'message' => 'Размер картинки не должен превышать 1 МБ.',
                'allowEmpty' => true
            ),
        /* Стандартные правила */
        /* Самописные правила */
            'customUploadImg' => array(
                'rule' => 'customUploadImg',
                'message' => 'Ошибка при обработке загруженной картинки.',
                'allowEmpty' => true
            )
        /* Самописные правила */
        )
    );
    
    public function customUploadImg ( $file = array() ) {
        if ( !is_uploaded_file($file['img']['tmp_name']) ) {
            return false;
        }
        $ext = strtolower(preg_replace("#.+\.([a-z]+)$#", "$1", $file['img']['name']));
        $fileName = $this->genNameFile($ext); // - получили уникальное имя
        $path = WWW_ROOT.'img'.DS.'products_img'.DS.$fileName; // - определили путь основной картинки
        $path_thumbs = WWW_ROOT.'img'.DS.'products_img'.DS.'thumbs'.DS.$fileName; // - определили путь миниатюры картинки
        if ( !move_uploaded_file($file['img']['tmp_name'], $path) ) {
            return false; // Во всех таких случаях возвращения false будет выведено сообщение message правила вилидации, что прописано выше.
        }
        $this->resizeImg($path, $path_thumbs, 165, 165, $ext);
        $this->data[$this->alias]['img'] = $fileName;
        return true;   
    }
    
    // Ресайз картинки 
    public function resizeImg($target, $dest, $wmax = 165, $hmax = 165, $ext){
		/*
		$target - путь к оригинальному файлу
		$dest - путь сохранения обработанного файла
		$wmax - максимальная ширина
		$hmax - максимальная высота
		$ext - расширение файла
		*/
		list($w_orig, $h_orig) = getimagesize($target);
		$ratio = $w_orig / $h_orig; // =1 - квадрат, <1 - альбомная, >1 - книжная

		if(($wmax / $hmax) > $ratio){
			$wmax = $hmax * $ratio;
		}else{
			$hmax = $wmax / $ratio;
		}
		
		$img = "";
		// imagecreatefromjpeg | imagecreatefromgif | imagecreatefrompng
		switch($ext){
			case("gif"):
				$img = imagecreatefromgif($target);
				break;
			case("png"):
				$img = imagecreatefrompng($target);
				break;
			default:
				$img = imagecreatefromjpeg($target);    
		}
		$newImg = imagecreatetruecolor($wmax, $hmax); // создаем оболочку для новой картинки
		
		if($ext == "png"){
			imagesavealpha($newImg, true); // сохранение альфа канала
			$transPng = imagecolorallocatealpha($newImg,0,0,0,127); // добавляем прозрачность
			imagefill($newImg, 0, 0, $transPng); // заливка  
		}
		
		imagecopyresampled($newImg, $img, 0, 0, 0, 0, $wmax, $hmax, $w_orig, $h_orig); // копируем и ресайзим изображение
		switch($ext){
			case("gif"):
				imagegif($newImg, $dest);
				break;
			case("png"):
				imagepng($newImg, $dest);
				break;
			default:
				imagejpeg($newImg, $dest);    
		}
		imagedestroy($newImg);
	}
    
    public function genNameFile ($ext) {
        $name = md5(microtime()).".{$ext}";
        if ( is_file(WWW_ROOT.'img'.DS.'products_img'.DS.$name) ) {
            $name = $this->genNameFile($ext); 
        }
        return $name;
    }
























}