<?php

namespace App\Service;

use think\facade\Log;

class AppLogger
{
    const TYPE_LOG4PHP = 'log4php';
    const TYPE_THINKLOG = 'think-log';

    private $logger;
    private $logType;

    public function __construct($type = self::TYPE_LOG4PHP)
    {
        $this->logType = $type;//初始化日志引擎的类型（用到代理模式）
        if ($type == self::TYPE_LOG4PHP) {
            $this->logger = \Logger::getLogger("Log");
        } elseif (self::TYPE_THINKLOG == $type) {
            Log::init([
                'default'	=>	'file',
                'channels'	=>	[
                    'file'	=>	[
                        'type'	=>	'file',
                        'path'	=>	'./logs/',
                    ],
                ],
            ]);
        }
    }

    public function info($message = '')
    {
        if (self::TYPE_LOG4PHP == $this->logType) {
            $this->logger->info($message);
        } elseif (self::TYPE_THINKLOG == $this->logType) {
            $message = strtoupper($message);//日志内容改为大写
            Log::info($message);
        }
    }

    public function debug($message = '')
    {
        if (self::TYPE_LOG4PHP == $this->logType) {
            $this->logger->debug($message);
        } elseif (self::TYPE_THINKLOG == $this->logType) {
            $message = strtoupper($message);//日志内容改为大写
            Log::debug($message);
        }
    }

    public function error($message = '')
    {
        if (self::TYPE_LOG4PHP == $this->logType) {
            $this->logger->error($message);
        } elseif (self::TYPE_THINKLOG == $this->logType) {
            $message = strtoupper($message);//日志内容改为大写
            Log::error($message);
        }
    }
}