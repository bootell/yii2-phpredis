<?php

namespace bootell\redis;

use Yii;
use yii\base\InvalidConfigException;

/**
 * Redis Session implements a session component using [redis](http://redis.io/) as the storage medium.
 *
 * Redis Session requires redis version 2.6.12 or higher to work properly.
 *
 * It needs to be configured with a redis [[Connection]] that is also configured as an application component.
 * By default it will use the `redis` application component.
 *
 * To use redis Session as the session application component, configure the application as follows,
 *
 * ~~~
 * [
 *     'components' => [
 *         'session' => [
 *             'class' => 'bootell\redis\Session',
 *             'redis' => [
 *                 'hostname' => 'localhost',
 *                 'port' => 6379,
 *                 'database' => 0,
 *             ]
 *         ],
 *     ],
 * ]
 * ~~~
 *
 * Or if you have configured the redis [[Connection]] as an application component, the following is sufficient:
 *
 * ~~~
 * [
 *     'components' => [
 *         'session' => [
 *             'class' => 'bootell\redis\Session',
 *             // 'redis' => 'redis' // id of the connection application component
 *         ],
 *     ],
 * ]
 * ~~~
 *
 * @property bool $useCustomStorage Whether to use custom storage. This property is read-only.
 *
 */
class Session extends \yii\redis\Session
{
    /**
     * @inheritDoc
     */
    public function init()
    {
        if (is_string($this->redis)) {
            $this->redis = Yii::$app->get($this->redis);
        } elseif (is_array($this->redis)) {
            if (!isset($this->redis['class'])) {
                $this->redis['class'] = Connection::class;
            }
            $this->redis = Yii::createObject($this->redis);
        }
        if (!$this->redis instanceof Connection) {
            throw new InvalidConfigException("Session::redis must be either a Redis connection instance or the application component ID of a Redis connection.");
        }
        if ($this->keyPrefix === null) {
            $this->keyPrefix = substr(md5(Yii::$app->id), 0, 5);
        }
        \yii\web\Session::init();
    }
}
