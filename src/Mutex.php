<?php

namespace bootell\redis;

use Yii;
use yii\di\Instance;

/**
 * Redis Mutex implements a mutex component using [redis](http://redis.io/) as the storage medium.
 *
 * Redis Mutex requires redis version 2.6.12 or higher to work properly.
 *
 * It needs to be configured with a redis [[Connection]] that is also configured as an application component.
 * By default it will use the `redis` application component.
 *
 * To use redis Mutex as the application component, configure the application as follows:
 *
 * ```php
 * [
 *     'components' => [
 *         'mutex' => [
 *             'class' => 'bootell\redis\Mutex',
 *             'redis' => [
 *                 'hostname' => 'localhost',
 *                 'port' => 6379,
 *                 'database' => 0,
 *             ]
 *         ],
 *     ],
 * ]
 * ```
 *
 * Or if you have configured the redis [[Connection]] as an application component, the following is sufficient:
 *
 * ```php
 * [
 *     'components' => [
 *         'mutex' => [
 *             'class' => 'bootell\redis\Mutex',
 *             // 'redis' => 'redis' // id of the connection application component
 *         ],
 *     ],
 * ]
 * ```
 *
 * @see \yii\mutex\Mutex
 * @see http://redis.io/topics/distlock
 *
 */
class Mutex extends \yii\redis\Mutex
{
    /**
     * @inheritDoc
     */
    protected $_lockValues = [];


    /**
     * @inheritDoc
     */
    public function init()
    {
        \yii\mutex\Mutex::init();
        $this->redis = Instance::ensure($this->redis, Connection::class);
        if ($this->keyPrefix === null) {
            $this->keyPrefix = substr(md5(Yii::$app->id), 0, 5);
        }
    }
}
