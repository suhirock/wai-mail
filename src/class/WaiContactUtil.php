<?php
/**
 * WaiContactUtil
 * 
 * ver .1.3
 */

// 厳格型チェック
declare(strict_types=1);

/**
 * クラス定義
 */
class WaiContactUtil {

    public $csrfkey = '_CSRF_';
    private $headerFile = '';
    private $footerFile = '';

    // コンストラクタ
    public function __construct(){
        $this->headerFile = __DIR__.'/../tpl/common-header.php';
        $this->footerFile = __DIR__.'/../tpl/common-footer.php';
    }

    /*
    * random
    */
    public function rand_str(int $length=8, string $chars=''): string {
        $chars = empty($chars) ? 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJLKMNOPQRSTUVWXYZ0123456789_!./-' : $chars;
		$clength = mb_strlen($chars);
	    $str = '';
	    for ($i = 0; $i < $length; ++$i) {
	        $str .= $chars[mt_rand(0, $clength-1)];
	    }
	    return $str;
	}

    /*
    * csrf
    */
    public function csrf() {
        if(session_status() == PHP_SESSION_ACTIVE){
            if($_SERVER['REQUEST_METHOD'] === 'GET'){
                $_SESSION[$this->csrfkey] = $this->rand_str(25);
                return $_SESSION[$this->csrfkey];
            } else if($_SERVER['REQUEST_METHOD'] === 'POST'){
                return $_POST[$this->csrfkey] === $_SESSION[$this->csrfkey];
            }
        } else {
            /**
             * @todo エラーハンドリングが必要
             */
            echo 'SESSIONが無効です。';
        }
	}

   
    public function form_value($item) {
        return !empty($item) ? $item : '';
	}
    public function check_one_value($item) {
        return !empty($item) ? ' checked="checked"' : '';
	}
    public function select_value($item) {
        // @todo
	}
    public function check_value($item) {
        // @todo
	}
    public function error_value($item) {
        return !empty($item) ? '<div class="error">'.$item.'</div>' : '';
	}
    public function confirm_value($item,$empty='') {
        return !empty($item) ? nl2br(htmlspecialchars($item)) : $empty;
	}

    /*
    * set header file
    */
    public function set_header($file) {
        $this->$headerFile = $file;
        return $this;
    }

    /*
    * set footer file
    */
    public function set_footer($file) {
        $this->$footerFile = $file;
        return $this;
    }

    /*
    * render
    */
    public function render(
        string $file,
        array $param, 
        bool $echo=true
        ) {
        $_util = $this; // use in form template
        ob_start();
        extract($param);
        require_once $this->headerFile;
        require_once $file;
        require_once $this->footerFile;
        $content = ob_get_contents();
        ob_end_clean();
        
        if(!empty($param['hidden'])){
            $hidden = '';
            foreach($param['hidden'] as $k => $v){
                $hidden .= '<input type="hidden" name="'.$k.'" value="'.strip_tags($v).'">'."\n";
            }
            $content = str_replace('</form',$hidden."</form",$content);
        }

        if($echo){
            echo $content;
        } else {
            return $content;
        }
	}

}