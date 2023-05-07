<?php require_once 'includes.php';
use PHPUnit\Framework\TestCase;

final class testNumberDoubleRules extends TestCase {
    public function testNumberDoubleRule() {
        $controller = new Controller();
        $this->expectException(Exception::class);
        [$valid,$err] = $controller->validateInputs([
            'test' => 'random'
        ],[
            'test|i[:]|i[:1000]'
        ]);
    }
}