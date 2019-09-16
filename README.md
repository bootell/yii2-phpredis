<p align="center">
    <a href="http://redis.io/" target="_blank" rel="external">
        <img src="http://download.redis.io/logocontest/82.png" height="100px">
    </a>
    <h1 align="center">Yii 2 Redis extension using phpredis</h1>
    <br>
</p>

The original [yiisoft/yii2-redis](https://github.com/yiisoft/yii2-redis) extension uses socket to communicate. It has performance issues in high concurrency: long response time, and `Failed to read from socket` error. Instead of using the socket, this extension uses the [phpredis](https://github.com/phpredis/phpredis) to connect to redis server, and all classes and methods has save input and output as the original extension.

Yii 原始的 [yiisoft/yii2-redis](https://github.com/yiisoft/yii2-redis) 扩展使用 socket 进行通信，在高并发下有性能问题，响应时间较长，并且会出现 `Failed to read from socket` 错误。

本扩展在原有 yii2-redis 的基础上，将连接方式替换为使用 php 原生扩展 [phpredis/phpredis](https://github.com/phpredis/phpredis)，性能大幅提高的同时，保持与原有扩展相同的调用方法方式，支持 Cache/Session/ActiveRecord，仅需替换对应类即可。


安装
-------------


```
php composer.phar require --prefer-dist bootell/yii2-phpredis:"*"
```


配置
-------------

```php
return [
    //....
    'components' => [
        'redis' => [
            'class' => 'bootell\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
    ]
];
```

说明
-------------

- [phpredis](https://github.com/phpredis/phpredis) 不支持配置超时重试次数 `retries`，但可配置重试间隔 `retry_interval`；
