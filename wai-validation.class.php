<?php
/**
 * wai varidation
 * 
 * ver .1
 */

// 厳格型チェック
declare(strict_types=1);

/**
 * クラス定義
 */
class waiValidation {

    private $errors = array();
    private $err_message = array(
        'exist' => '必須入力項目です。',
        'email' => 'メールアドレスの形式ではありません。',
        'same' => '一致していません。'
    );
    /*
        array(
            'name' => 'エラーメッセージ',
            'email' => 'エラーメッセージ',
        )
    */

    private $target = array();
    private $target_keys = array();

    // コンストラクタ
    public function __construct(){
        $this->set_target( $_POST );
    }

    /**
     * rule
     * ルール設定
     */
    public function rule($name, array $valid=array()) {
        
        // キーの存在チェック
        if(! in_array($name,$this->target_keys)){
            return false;
        }
        $value = $this->target[$name];

        // バリデーション
        foreach($valid as $v){
            $e = $this->$v($value);
            if(!empty($e)){
                $this->errors[$name] = $e;
                break;
            }
        }

        $this->dump($this->errors);
    }

    /**
     * isError
     * エラーの存在があるかを bool値 で返す
     */
    public function isError(): bool {
        $this->dump(count($this->errors));

        if(0 === count($this->errors)){
            return false;
        }
        return true;
    }

    // 検証用 : 手動代入
    public function set_target(array $target): void {
        $this->target = $target;
        $this->target_keys = array_keys($this->target);
    }

    /**
     * private exist
     */
    private function exist($item) {
        if(empty($item)){
            return $this->err_message[__FUNCTION__];
        }
    }

    private function email(string $item) {
        $patten = '/\A[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@([a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*)\.([a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*)\z/';
        if(! preg_match($patten, $item, $match)){
            return $this->err_message[__FUNCTION__];
        }
    }

    private function dump($item): void {
        echo '<pre>';
        var_dump( $item );
        echo '</pre>';
    }
}