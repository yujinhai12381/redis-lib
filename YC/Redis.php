<?php
class YC_Redis {
    const DEFAULT_TIMEOUT = 3;

    private static $_INSTANCE = array();

    public static function getInstance($keyName,$config) {
        if(!isset(self::$_INSTANCE[$keyName])) {
            self::$_INSTANCE[$keyName] = new self($config);
        }
        return self::$_INSTANCE[$keyName];
    }

    private $_redis = null;

    private function __construct($config) {
        $timeout = isset($config['timeout']) ? (int) $config['timeout'] : self::DEFAULT_TIMEOUT;

        $this->_redis = new \Redis();
        if(array_key_exists('port',$config)) {
            $this->_redis->connect($config['host'][0],$config['port'],$timeout);
        } else {
            $this->_redis->connect($config['host'][0],6379,$timeout);
        }

        $this->_redis->select($config['prefix']);
        $this->_redis->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_IGBINARY);
    }
    /**
     ** 返回redis对象
     ** 拿着这个对象就可以直接调用redis自身方法
     */
    public function redis() {
        return $this->_redis;
    }

    public function set($key, $value, $expire = 0) {
        if ( empty($key) ) {
            return false;
        }

        return $this->_redis->set($key, $value, $expire);
    }

    public function get($key) {
        if ( empty($key) ) {
            return false;
        }

        return $this->_redis->get($key);
    }

    public function mset(array $keys) {
        return $this->_redis->mset($keys);
    }

    public function mget(array $keys) {
        return $this->_redis->mget($keys);
    }

    public function hSet($key, $hashKey, $value) {
        return $this->_redis->hSet($key, $hashKey, $value);
    }

    public function hGet($key, $hashKey) {
        return $this->_redis->hGet($key, $hashKey);
    }

    public function hGetAll($key) {
        return $this->_redis->hGetAll($key);
    }

    public function hMset($key, $members) {
        return $this->_redis->hMset($key, $members);
    }

    public function hMget($key, $memberKeys) {
        return $this->_redis->hMget($key, $memberKeys);
    }

    public function hDel($key, $field) {
         return $this->_redis->hDel($key, $field);
    }

    public function expire($key, $seconds) {
        return $this->_redis->expire($key, $seconds);
    }

    public function flushDB() {
        return $this->_redis->flushDB();
    }

    public function exists($key) {
        if ( empty($key) ) {
            return false;
        }

        return $this->_redis->exists($key);
    }

    public function delete($key) {
        if ( empty($key) ) {
            return false;
        }

         return $this->_redis->delete($key);
    }

    public function del($key) {
        if ( empty($key) ) {
            return false;
        }

         return $this->_redis->del($key);
    }

    public function getLastError() {
         return $this->_redis->getLastError();
    }

    public function close() {
        return $this->_redis->close($key);
    }
}
