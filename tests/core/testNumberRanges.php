<?php
require_once 'includes.php';
use PHPUnit\Framework\TestCase;

final class testNumberRanges extends TestCase
{
    public function testNumberRanges()
    {
        $controller = new Controller();
        [$err,$valid] = [[],[]];

        $ErrorSet = function ($error_name) use (&$err) {
            $this->assertContains('test', $err[$error_name] ?? []);
        };

        $ErrorSetArr = function ($error_name) use (&$err) {
            $this->assertContains('test', array_map(function ($a) {
                return $a[0];
            }, $err[$error_name] ?? []));
        };

        $NotErrorSetArr = function ($error_name) use (&$err) {
            $this->assertNotContains('test', array_map(function ($a) {
                return $a[0];
            }, $err[$error_name] ?? []));
        };

        $NotErrorSet = function ($error_name) use (&$err) {
            $this->assertNotContains('test', $err[$error_name][0] ?? []);
        };

        $isValidValue = function ($value) use (&$valid) {
            $this->assertEquals($value, $valid['test'] ?? null);
        };

        $isNotValid = function () use (&$valid) {
            $this->assertNotContains('test', $valid);
        };

        // Integer Tests
        [$valid,$err] = $controller->validateInputs([
            'test' => 'random'
        ], [
            'test|i'
        ]);

        [$valid,$err] = $controller->validateInputs([
            'test' => 'random'
        ], [
            'test|i[:]'
        ]);

        $ErrorSet('number');

        [$valid,$err] = $controller->validateInputs([
            'test' => '1000'
        ], [
            'test|i[:]'
        ]);

        $NotErrorSet('number');

        [$valid,$err] = $controller->validateInputs([
            'test' => '1000'
        ], [
            'test|i[:1000]'
        ]);

        $NotErrorSet('number');
        $NotErrorSetArr('max');
        $NotErrorSetArr('min');
        $isValidValue(1000);

        [$valid,$err] = $controller->validateInputs([
            'test' => '1001'
        ], [
            'test|i[:1000]'
        ]);

        $NotErrorSet('number');
        $ErrorSetArr('max');
        $NotErrorSetArr('min');
        $isNotValid();

        [$valid,$err] = $controller->validateInputs([
            'test' => '-1'
        ], [
            'test|i[0:]'
        ]);


        $NotErrorSet('number');
        $NotErrorSetArr('max');
        $ErrorSetArr('min');
        $isNotValid();

        [$valid,$err] = $controller->validateInputs([
            'test' => '-1'
        ], [
            'test|i[0:100]'
        ]);


        $NotErrorSet('number');
        $NotErrorSetArr('max');
        $ErrorSetArr('min');
        $isNotValid();

        for($i=0;$i<=100;++$i) {
            [$valid,$err] = $controller->validateInputs([
                'test' => "$i"
            ], [
                'test|i[0:100]'
            ]);


            $NotErrorSet('number');
            $NotErrorSetArr('max');
            $NotErrorSetArr('min');
            $isValidValue($i);
        }

        [$valid,$err] = $controller->validateInputs([
            'test' => '101'
        ], [
            'test|i[0:100]'
        ]);


        $NotErrorSet('number');
        $ErrorSetArr('max');
        $NotErrorSetArr('min');
        $isNotValid();

        // Doubles Tests
        [$valid,$err] = $controller->validateInputs([
            'test' => 'random'
        ], [
            'test|d'
        ]);

        [$valid,$err] = $controller->validateInputs([
            'test' => 'random'
        ], [
            'test|d[:]'
        ]);

        $ErrorSet('number');

        [$valid,$err] = $controller->validateInputs([
            'test' => '1000'
        ], [
            'test|d[:]'
        ]);

        $NotErrorSet('number');

        [$valid,$err] = $controller->validateInputs([
            'test' => '1000'
        ], [
            'test|d[:1000]'
        ]);

        $NotErrorSet('number');
        $NotErrorSetArr('max');
        $NotErrorSetArr('min');
        $isValidValue(1000);

        [$valid,$err] = $controller->validateInputs([
            'test' => '1001'
        ], [
            'test|d[:1000]'
        ]);

        $NotErrorSet('number');
        $ErrorSetArr('max');
        $NotErrorSetArr('min');
        $isNotValid();

        [$valid,$err] = $controller->validateInputs([
            'test' => '-1'
        ], [
            'test|d[0:]'
        ]);


        $NotErrorSet('number');
        $NotErrorSetArr('max');
        $ErrorSetArr('min');
        $isNotValid();

        [$valid,$err] = $controller->validateInputs([
            'test' => '-1'
        ], [
            'test|d[0:100]'
        ]);


        $NotErrorSet('number');
        $NotErrorSetArr('max');
        $ErrorSetArr('min');
        $isNotValid();

        for($i=0;$i<=100;++$i) {
            [$valid,$err] = $controller->validateInputs([
                'test' => "$i"
            ], [
                'test|d[0:100]'
            ]);


            $NotErrorSet('number');
            $NotErrorSetArr('max');
            $NotErrorSetArr('min');
            $isValidValue($i);
        }

        [$valid,$err] = $controller->validateInputs([
            'test' => '101'
        ], [
            'test|d[0:100]'
        ]);


        $NotErrorSet('number');
        $ErrorSetArr('max');
        $NotErrorSetArr('min');
        $isNotValid();
    }
}