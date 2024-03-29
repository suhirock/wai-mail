<?php
/**
 * WaiContactUtilTest
 * 
 * @author: suhirock
 */
declare(strict_types=1);
require_once __DIR__.'/../src/class/WaiContactUtil.php';
use PHPUnit\Framework\TestCase;

class WaiContactUtilTest extends TestCase {
    /**
     * @test
     */
    public function formant__rand_str(): void {
        $util = new WaiContactUtil();
        $rand = $util->rand_str();
        $this->assertMatchesRegularExpression(
            '/^[a-zA-Z0-9_!\.\/\-]+$/',
            $rand
        );
    }

    /**
     * @test
     */
    public function count__rand_str(): void {
        $util = new WaiContactUtil();
        $rand = $util->rand_str();
        $this->assertSame(8,strlen($rand));
    }

    /**
     * provider
     */
    public function empty_provider__form_value() {
        return [
            'null' => [null],
            'empty' => [''],
            'zero' => [0],
        ];
    }

    /**
     * @test
     * @dataProvider empty_provider__form_value
     */
    public function empty_string__form_value($value) {
        $util = new WaiContactUtil();
        $form_value = $util->form_value($value);
        $this->assertSame('',$form_value);
    }

    /**
     * @test
     */
    public function not_empty__form_value() {
        $util = new WaiContactUtil();
        $value = 'item';
        $form_value = $util->form_value($value);
        $this->assertSame($value,$form_value);
    }

    /**
     * @test
     * @dataProvider empty_provider__form_value
     */
    public function empty__check_one_value($value) {
        $util = new WaiContactUtil();
        $form_value = $util->check_one_value($value);
        $this->assertSame('',$form_value);
    }

    /**
     * @test
     */
    public function not_empty__check_one_value() {
        $util = new WaiContactUtil();
        $value = 'item';
        $form_value = $util->check_one_value($value);
        $this->assertSame(' checked="checked"',$form_value);
    }

    /**
     * @test
     * @dataProvider empty_provider__form_value
     */
    public function empty__error_value($value) {
        $util = new WaiContactUtil();
        $form_value = $util->error_value($value);
        $this->assertSame('',$form_value);
    }

    /**
     * @test
     */
    public function check_code__error_value() {
        $util = new WaiContactUtil();
        $value = 'Error';
        $code = $util->error_value($value);
        $this->assertSame('<div class="error">Error</div>',$code);
	}

    /**
     * @test
     */
    public function set_empty__confirm_value() {
        $util = new WaiContactUtil();
        $value = '';
        $empty = '-';
        $output = $util->confirm_value($value,$empty);
        $this->assertSame($empty,$output);
	}

    /**
     * @test
     */
    public function not_empty__check_same_value() {
        $util = new WaiContactUtil();
        $value = '1';
        $empty = '1';
        $output = $util->check_same_value($value,$empty);
        $this->assertSame(' checked="checked"',$output);
	}

    // render : タイトルの出力
    // render : hiddenの出力
}