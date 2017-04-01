<?php

class Template {
	private $title = _TITLE_;
	private $template = null;

    public function addFile($file){
		$file = "./tpl/".$file;
		$handle = fopen($file, "r");
		$this->template .= fread($handle, filesize($file));
		fclose($handle);
	}
	
	public function setTitle($title){
		$this->title = $title;
	}
    
    public function replaceString($find, $replace){
        $this->template = str_replace($find, $replace, $this->template);
    }
	
	public function replaceFile($str, $file){
		$file = "./tpl/".$file;
		$handle = fopen($file, "r");
		$text = fread($handle, filesize($file));
		fclose($handle);
		
		$this->template = str_replace($str, $text, $this->template);
	}
	
	public function getTextFromFile($file){
		$file = "./tpl/".$file;
		$handle = fopen($file, "r");
		$text = fread($handle, filesize($file));
		fclose($handle);
		
		return $text;
	}
	
	public function addTitle($title){
		$this->title = $title . " » " . $this->title;
	}
<<<<<<< HEAD
    
    public function getTitle(){
        return $this->title;
    }
=======

    public function parse(){
		//global $user;
		
		//Строковые реплейсеры
		$this->template = str_replace("{header_title}", $this->title, $this->template);
		$this->template = str_replace("{isAdmin}", "<?php if( $user->isAdmin() ) { ?>", $this->template);
		$this->template = str_replace("{end}", "<?php } ?>", $this->template);
        
        //Категории главной страницы
		$this->template = str_replace("{categories}", Categories::getCategoriesAsHtml(), $this->template);

		/* Тема */

        // Загрузка основной части страницы
        $this->template = str_replace("{load_page_topic}", Topic::getMessagesAsHtml(), $this->template);
        // Форма внизу для сообщения
        $this->template = str_replace("{form_messages}", Topic::getFormMessagesAsHtml(), $this->template);
        // Подгрузка сообщения от пользователей
        $this->template = str_replace("{messages_users}", Topic::getMessagesUsersAsHtml(), $this->template);

        /* Раздел */
        //$this->template = str_replace("{sections}", Sections::getSectionsAsHtml(), $this->template);
        //$this->template = str_replace("{sections_theme}", Topics::getTopicsAsHtml(), $this->template);

		//Файловые репллейсеры
		//Пусть лежит для примера. Удалите как не будет нужен
		//$this->replaceFile("{user_block}", "user-panel.php");
		
		//Another preg Replace's
		//Я не помню для чего, пока оставим
		//$this->template = preg_replace("#\\{user\\[(.*?)\\]\\}#ies", "\$_SESSION['\\1']", $this->template);
	}
>>>>>>> origin/Artur

    public function getTemplate(){
		return $this->template;
	}
}