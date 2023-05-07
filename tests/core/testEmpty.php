<?php require_once 'includes.php';
use PHPUnit\Framework\TestCase;
final class testEmpty extends TestCase
{
    public function testEmpty()
    {
        $controller = new Controller();
        [$valid,$err] = $controller->validateInputs([], [
            'test|?'
        ]);

        $this->assertNotContains('test', $err['missing'] ?? []);
        $this->assertNotContains('test', $err['empty'] ?? []);

        [$valid,$err] = $controller->validateInputs([], [
            'test'
        ]);

        $this->assertContains('test', $err['missing'] ?? []);
        $this->assertNotContains('test', $err['empty'] ?? []);

        [$valid,$err] = $controller->validateInputs([
            'test' => ''
        ], [
            'test'
        ]);

        $this->assertNotContains('test', $err['missing'] ?? []);
        $this->assertContains('test', $err['empty'] ?? []);

        [$valid,$err] = $controller->validateInputs([
            'test' => 'random'
        ], [
            'test'
        ]);

        $this->assertNotContains('test', $err['missing'] ?? []);
        $this->assertNotContains('test', $err['empty'] ?? []);
        $this->assertEquals('random', $valid['test'] ?? null);
    }
}