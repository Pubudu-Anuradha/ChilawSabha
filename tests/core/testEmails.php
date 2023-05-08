<?php
require_once 'includes.php';
use PHPUnit\Framework\TestCase;

final class testEmails extends TestCase {
    public function testEmails() {
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
            'test' => 'valid@email.com'
        ],[
            'test|e'
        ]);

        $NotErrorSet('email');
        $valid_addresses = [
            'example@example.com',
            'firstname.lastname@example.com',
            'user.name+tag+sorting@example.com',
            'example-indeed@strange-example.com',
            'example@example.travel',
            'example@example.travel.travel'
        ];

        $invalid_addresses = [
            'plainaddress',
            '@missingusername.com',
            'example@.com',
            'example@.com.',
            'example@missingtld.',
            'example@-domain.com'
        ];

        foreach($valid_addresses as $address) {
            [$valid,$err] = $controller->validateInputs([
                'test' => $address
            ],[
                'test|e'
            ]);

            $NotErrorSet('email');
            $isValidValue($address);
        }

        foreach($invalid_addresses as $address) {
            [$valid,$err] = $controller->validateInputs([
                'test' => $address
            ],[
                'test|e'
            ]);

            $ErrorSet('email');
            $isNotValid();
        }
    }
}