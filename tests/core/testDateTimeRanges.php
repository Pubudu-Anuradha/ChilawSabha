<?php
require_once 'includes.php';
use PHPUnit\Framework\TestCase;
final class testDateTimeRanges extends TestCase
{
    public function testDateTimeRanges()
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

        [$valid,$err] = $controller->validateInputs([
            'test' => date('Y-m-d')
        ], [
            'test|dt[:]'
        ]);


        $NotErrorSetArr('date_parse');
        $NotErrorSetArr('before');
        $NotErrorSetArr('after');
        $isValidValue(date('Y-m-d'));


        [$valid,$err] = $controller->validateInputs([
            'test' => '2023-04-30'
        ], [
            'test|dt[2023-05-01:2023-05-05]'
        ]);

        $NotErrorSetArr('date_parse');
        $ErrorSetArr('before');
        $NotErrorSetArr('after');
        $isNotValid('2023-04-30');

        [$valid,$err] = $controller->validateInputs([
            'test' => '2023-05-06'
        ], [
            'test|dt[2023-05-01:2023-05-05]'
        ]);

        $NotErrorSetArr('date_parse');
        $NotErrorSetArr('before');
        $ErrorSetArr('after');
        $isNotValid('2023-04-30');


        [$valid,$err] = $controller->validateInputs([
            'test' => 'not a date'
        ], [
            'test|dt[2023-05-01:2023-05-05]'
        ]);

        $ErrorSet('date_parse');
        $NotErrorSetArr('before');
        $NotErrorSetArr('after');
        $isNotValid('not a date');
    }
}