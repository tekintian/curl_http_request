# Curl http 请求工具

超级灵活，强大，可自定义的curl http请求类， 可伪装来源，agent, 伪装IP地址等等，支持POST, GET等方式

## 使用方法:

1. 载入本工具类

~~~shell
composer require tekintian/curl_http_request
~~~

2. 使用本工具

~~~php
<?php

// 载入自动加载： 如果使用框架的话这个步骤可以忽略。
require_once __DIR__ . '/vendor/autoload.php';

use \tekintian\utils\CurlHttpRequest;

// 请求测试
$data = CurlHttpRequest::send("http://www.baidu.com");

echo $data;

~~~


