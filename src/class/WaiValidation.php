<?php
/**
 * wai varidation
 * 
 * ver .1.3
 */

// 厳格型チェック
declare(strict_types=1);

/**
 * クラス定義
 */
class WaiValidation {

    private $labels = array();
    private $errors = array();
    private $err_message = array(
        'exist' => '{label}必須入力項目です。',
        'email' => '{label}メールアドレスの形式ではありません。',
        'same' => '{target}一致していません。',
        'exist_all' => '{target}すべて必須入力項目です。',
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
    public function rule(string $name, $label, array $valid=array()) {
        
        // ラベル
        $this->labels[$name] = $label;

        // 
        $value = !empty($this->target[$name]) ? $this->target[$name] : '';

        // バリデーション
        foreach($valid as $k => $v){
            if($k === 'same'){
                $l = !empty($this->labels[$v]) ? $this->labels[$v].'と' : '';
                $e = str_replace('{target}',$l,$this->$k($value,$this->target[$v]));
            } elseif($k === 'exist_all'){
                $e = '';
                foreach($v as $v2){
                    $err = $this->exist($this->target[$v2]);
                    if(!empty($err)){
                        $l = !empty($this->labels[$name]) ?$this->labels[$name].'は' : '';
                        $e = str_replace('{label}',$l,$err);
                        break;
                    }
                }
            } else {
                $l = !empty($this->labels[$name]) ? $this->labels[$name].'は' : '';
                $e = str_replace('{label}',$l,$this->$v($value));
            }
            if(!empty($e)){
                $this->errors[$name] = $e;
                break;
            }
        }

    }

    /**
     * isError
     * エラーの存在があるかを bool値 で返す
     */
    public function isError(): bool {
        if(0 === count($this->errors)){
            return false;
        }
        return true;
    }

    /**
     * errors : 返すだけ
     */
    public function errors(): array {
        return $this->errors;
    }

    // 検証用 : 手動代入
    public function set_target(array $target): void {
        $this->target = $target;
        $this->target_keys = array_keys($this->target);
    }

    /**
     * private validate
     */
    private function exist($item) {
        if(empty($item)){
            return $this->err_message[__FUNCTION__];
        }
        return '';
    }

    private function email(string $item) {
        $patten = '/\A[a-zA-Z0-9.!#$%&\'*+\/=?^_`{|}~-]+@([a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*)\.([a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*)\z/';
        if(! preg_match($patten, $item, $match)){
            return $this->err_message[__FUNCTION__];
        }
        return '';
    }

    private function same(string $item, string $target) {
        if($item != $target){
            return $this->err_message[__FUNCTION__];
        }
        return '';
    }

}