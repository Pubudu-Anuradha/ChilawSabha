<?php require_once 'includes.php';
use PHPUnit\Framework\TestCase;

final class testStringLengthRules extends TestCase {
    public function testStringLengthRanges() {
        $controller = new Controller();
        [$err,$valid] = [[],[]];

        $ErrorSet = function($error_name) use (&$err) {
            $this->assertContains('test',$err[$error_name] ?? []);
        };

        $ErrorSetArr = function($error_name) use (&$err) {
            $this->assertContains('test',array_map(function($a){
                return $a[0];
            },$err[$error_name] ?? []));
        };

        $NotErrorSetArr = function($error_name) use (&$err) {
            $this->assertNotContains('test',array_map(function($a){
                return $a[0];
            },$err[$error_name] ?? []));
        };

        $NotErrorSet = function($error_name) use (&$err) {
            $this->assertNotContains('test',$err[$error_name][0] ?? []);
        };

        $isValidValue = function($value) use (&$valid) {
            $this->assertEquals($value,$valid['test'] ?? null);
        };

        $isNotValid = function() use (&$valid) {
            $this->assertNotContains('test',$valid);
        };

        [$valid,$err] = $controller->validateInputs([
            'test' => 'test'
        ],[
            'test|l[0:10]'
        ]);


        $NotErrorSet('number');
        $NotErrorSetArr('max_len');
        $NotErrorSetArr('min_len');
        $isValidValue('test');

        [$valid,$err] = $controller->validateInputs([
            'test' => 'test'
        ],[
            'test|l[5:10]'
        ]);


        $NotErrorSet('number');
        $NotErrorSetArr('max_len');
        $ErrorSetArr('min_len');
        $isNotValid('test');

        [$valid,$err] = $controller->validateInputs([
            'test' => 'longer than 10 characters'
        ],[
            'test|l[5:10]'
        ]);

        $NotErrorSet('number');
        $ErrorSetArr('max_len');
        $NotErrorSetArr('min_len');
        $isNotValid('longer than 10 characters');
    }
}