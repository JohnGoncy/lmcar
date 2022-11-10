<?php

namespace Test\App;

use PHPUnit\Framework\TestCase;
use App\App\Demo;
use App\Util\HttpRequest;

class DemoTest extends TestCase
{

    private $logger;
    private $req;

    public function test_foo()
    {
        $this->logger = \Logger::getLogger("Log");
        $this->req = new HttpRequest();
        $demo = new Demo($this->logger,$this->req);

        $this->assertEquals("bar", $demo->foo());
    }

    public function test_get_user_info()
    {
        //构造用户信息接口返回的数据（用于改造有源程序src/App/Demo.php中的get_user_info()函数）
        $retData = [
            'error' => 0,
            'data'  => [
                'id' => 1,
                'username' => 'hello world',
            ],
        ];

        $this->logger = \Logger::getLogger("Log");
        $this->req = new HttpRequest();

        $demo = new Demo($this->logger, $this->req);
        $this->assertTrue($this->isValidData($demo->get_user_info()));
    }

    /**
     * 判断接口返回值是否有效
     * @param $data
     * @return bool
     */
    private function isValidData($data)
    {
        //判断接口返回的数据是否为空，或非数组
        if(empty($data) || !is_array($data)){
            return false;
        }
        //针对数组判断字段是否存在，及类型是否正确
        if (!isset($data['id']) || !is_numeric($data['id'])) {
            return false;
        }
        if (!isset($data['username']) || !is_string($data['username'])) {
            return false;
        }
        return true;
    }
}
