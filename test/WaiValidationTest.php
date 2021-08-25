<?php
/**
 * WaiValidationTest
 * 
 * @author: suhirock
 */
declare(strict_types=1);
require_once __DIR__.'/../src/config.php';
require_once __DIR__.'/../src/class/WaiValidation.php';
use PHPUnit\Framework\TestCase;

class WaiValidationTest extends TestCase {
    /**
     * @test
     */
    public function exist__validation() {
        $vali = new WaiValidation();

        // sample post value
        $vali->set_target(
            [
                'name' => ''
            ]
        );

        // rule
        $rule = [ 'name', 'お名前', ['exist']];

        // rule set & validation
        $vali->rule($rule[0],$rule[1],$rule[2]);

        // error flg check
        $this->assertNotFalse($vali->isError());

        // error text check
        $errors = $vali->errors();
        $this->assertSame('お名前は必須入力項目です。',$errors['name']);
    }

    /**
     * @test
     */
    public function mail_format__validation() {
        $vali = new WaiValidation();

        // sample
        $vali->set_target(
            [
                'email' => 'hogehoge'
            ]
        );

        // rule
        $rule = [ 'email', 'メールアドレス', ['exist', 'email'] ];

        // validation
        $vali->rule($rule[0],$rule[1],$rule[2]);

        // error check
        $this->assertNotFalse($vali->isError());

        // error text check
        $errors = $vali->errors();
        $this->assertSame('メールアドレスは（xxx@yyy.com）のような形式でご入力ください。',$errors['email']);
    }

    /**
     * @test
     */
    public function mail_same__validation() {
        $vali = new WaiValidation();

        // sample
        $vali->set_target(
            [
                'email1' => 'example1@hoge.com',
                'email2' => 'example2@hoge.com'
            ]
        );

        // rule
        $rules = [
            ['email1', 'メールアドレス', ['exist', 'email'] ],
            ['email2', 'メールアドレス', ['exist', 'email', 'same'=>'email1'] ],
        ];

        // validation
        foreach($rules as $rule){
            $vali->rule($rule[0],$rule[1],$rule[2]);
        }

        // error check
        $this->assertNotFalse($vali->isError());

        // error text check
        $errors = $vali->errors();
        $this->assertSame('メールアドレスと一致していません。',$errors['email2']);
    }
}