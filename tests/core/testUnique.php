<?php require_once 'includes.php';
use PHPUnit\Framework\TestCase;
final class testUnique extends TestCase {
    public function testUnique() {
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

        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        $conn->query('DROP TABLE IF EXISTS `test`;');
        $conn->query('CREATE TABLE IF NOT EXISTS `test` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `test` varchar(255) NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');

        $conn->query('INSERT INTO `test` (`id`, `test`) VALUES
            (1, \'test\'),
            (2, \'test2\'),
            (3, \'test3\');');

        [$valid,$err] = $controller->validateInputs([
            'test' => 'test'
        ],[
            'test|u[test]'
        ]);

        $ErrorSet('unique');
        $isNotValid();

        [$valid,$err] = $controller->validateInputs([
            'test' => 'test4'
        ],[
            'test|u[test]'
        ]);

        $NotErrorSet('unique');
        $isValidValue('test4');

        $conn->query('DROP TABLE `test`;');
    }
}