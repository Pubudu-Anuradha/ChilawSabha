<?php
require_once 'includes.php';
use PHPUnit\Framework\TestCase;

final class testCoreModel extends TestCase
{
    private function makeTestTable()
    {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "CREATE TABLE IF NOT EXISTS `test` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
        $conn->query($sql);
        $conn->close();
    }

    private function dropTestTable()
    {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = "DROP TABLE IF EXISTS `test`";
        $conn->query($sql);
        $conn->close();
    }

    public function testModel()
    {
        $model = new Model();
        $this->assertInstanceOf(Model::class, $model);
    }

    public function testInsert()
    {
        $this->makeTestTable();
        $model = new Model();
        $data = [
            'name' => 'test',
            'email' => 'test@abc.com',
            'password' => '123456',
        ];
        $insert = $model->insert('test', $data);
        $this->assertTrue($insert['success']);
        $this->assertFalse($insert['error']);
        $this->assertEmpty($insert['errmsg']);
        $this->dropTestTable();
    }

    public function testSelect()
    {
        $this->makeTestTable();
        $model = new Model();
        $data = [
            'name' => 'test',
            'email' => 'test@abc.com',
            'password' => '123456',
        ];
        $insert = $model->insert('test', $data);
        $select = $model->select('test', '*', 'name="test"');
        $this->assertEquals($select['result'][0]['name'], 'test');
        $this->assertEquals($select['result'][0]['email'], 'test@abc.com');
        $this->assertEquals($select['result'][0]['password'], '123456');
        $this->assertNotEmpty($select['result']);
        $this->assertFalse($select['nodata']);
        $this->assertFalse($select['error']);
        $this->assertEmpty($select['errmsg']);

        $this->dropTestTable();
    }

    public function testUpdate()
    {
        $this->makeTestTable();
        $model = new Model();
        $data = [
            'name' => 'test',
            'email' => 'test@abc.com',
            'password' => '123456',
        ];
        $insert = $model->insert('test', $data);
        $update = $model->update('test', ['name' => 'test2'], 'name="test"');
        $this->assertNotEquals($update['rows'], 0);
        $this->assertTrue($update['success']);
        $this->assertFalse($update['error']);
        $this->assertEmpty($update['errmsg']);
        $this->dropTestTable();
    }

    public function testDelete()
    {
        $this->makeTestTable();
        $model = new Model();
        $data = [
            'name' => 'test',
            'email' => 'test@abc.com',
            'password' => '123456',
        ];
        $insert = $model->insert('test', $data);
        $delete = $model->delete('test', 'name="test"');
        $this->assertTrue($delete['success']);
        $this->assertFalse($delete['error']);
        $this->assertEmpty($delete['errmsg']);
        $this->dropTestTable();
    }

    public function testExists()
    {
        $this->makeTestTable();
        $model = new Model();
        $data = [
            'name' => 'test',
            'email' => 'test@abc.com',
            'password' => '123456',
        ];
        $insert = $model->insert('test', $data);
        $exists = $model->exists('test', [
            'name' => 'test',
            'email' => 'test@abc.com',
            'password' => '123456',
        ]);
        $this->assertTrue($exists);
        $delete = $model->delete('test', 'name="test"');
        $this->assertTrue($delete['success']);
        $this->assertFalse($delete['error']);
        $this->assertEmpty($delete['errmsg']);
        $exists = $model->exists('test', [
            'name' => 'test',
            'email' => 'test@abc.com',
            'password' => '123456',
        ]);
        $this->assertFalse($exists);
        $this->dropTestTable();
    }

    public function testSelectPaginated()
    {
        $this->makeTestTable();
        $model = new Model();
        for ($i = 0; $i < 1000; ++$i) {
            $data = [
                'name' => 'test' . $i,
                'email' => 'test' . $i . '@abc.com',
                'password' => 123456 * $i,
            ];
            $model->insert('test', $data);
        }
        $page_size = 10;
        for ($page = 0; $page < 1000/$page_size; ++$page) {
            $_GET['page'] = $page;
            $_GET['size'] = $page_size;
            $select = $model->selectPaginated('test');
            $this->assertCount(10, $select['result']);
            $this->assertEquals(1000,$select['count']);
            $this->assertEquals($select['page'][0], $page * $page_size);
            $this->assertEquals($select['page'][1], $page_size);
            for ($i = 0; $i < 10; ++$i) {
                $this->assertEquals($select['result'][$i]['name'], 'test' . ($page * $page_size + $i));
                $this->assertEquals($select['result'][$i]['email'], 'test' . ($page * $page_size + $i) . '@abc.com');
                $this->assertEquals($select['result'][$i]['password'], 123456 * ($page * $page_size + $i));
            }
        }
    }
}