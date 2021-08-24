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

        // sample
        $vali->set_target(
            [
                'name' => ''
            ]
        );

        // rule
        $rule = [ 'name', 'お名前', ['exist']];

        // validation
        $vali->rule($rule[0],$rule[1],$rule[2]);

        // error check
        $this->assertNotFalse($vali->isError());
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
    }
}