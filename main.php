<?php
#########################################################################
# File Name: main.php
# Desc: 
# Author: yujinhai
# mail: yujinhai12381@126.com
# Created Time: Thu 08 Oct 2015 03:45:54 PM CST
#########################################################################

include './config.php';
include './YC/Redis.php';

const REDIS_DB_DISTANCE = 'distance';
const REDIS_DB_PRICE = 'price';

//var_export($redisConfig);
$redisDistance = YC_Redis::getInstance(REDIS_DB_DISTANCE,$redisConfig['distance']);
$redisPrice = YC_Redis::getInstance(REDIS_DB_PRICE,$redisConfig['price']);

/*test set and get */
//var_export($redisConfig);
$result = $redisDistance->set('test',"11111111111");
var_dump($result);    //结果：bool(true)

$result = $redisDistance->get('test');
var_dump($result);

/*直接调用redis*/
$result1 = $redisDistance->redis()->keys("dispatch*");
var_dump($result1);

/*redis keys*/
error_log("==========exists  test======================");
$result2 = $redisDistance->exists("test");
var_dump($result2);

/*redis delete*/
//error_log("==========test ( delete ) ======================");
//$result3 = $redisDistance->delete("test");
//var_dump($result3);

error_log("==========test ( del ) ======================");
$result3 = $redisDistance->del("test");
var_dump($result3);


error_log("==========test ( hSet hget ) ======================");
$redisDistance->delete('h');
$ret = $redisDistance->hSet('h', 'key1', 'hello'); /* 1, 'key1' => 'hello' in the hash at "h" */
var_dump($ret);
$result4 = $redisDistance->hGet('h', 'key1'); /* returns "hello" */
var_dump($result4);
$ret = $redisDistance->hSet('h', 'key1', 'plop'); /* 0, value was replaced. */
var_dump($ret);
$result5 = $redisDistance->hGet('h', 'key1'); /* returns "plop" */
var_dump($result5);

error_log("==========test ( hGetAll ) ======================");
$redis = YC_Redis::getInstance(REDIS_DB_DISTANCE,$redisConfig['distance']);
$redis->delete('h');
$redis->hSet('h', 'a', 'x');
$redis->hSet('h', 'b', 'y');
$redis->hSet('h', 'c', 'z');
$redis->hSet('h', 'd', 't');
var_dump($redis->hGetAll('h'));

error_log("==========test ( hdel) ======================");
$redis->hDel('h', 'a');
$redis->hDel('h', 'b');
var_dump($redis->hGetAll('h'));

error_log("==========test ( hMset hMget) ======================");
$redis->delete('user:1');
$redis->hMset('user:1', array('name' => 'Joe', 'salary' => 2000));
$ret = $redis->hMget('user:1',array('name','salary'));
var_dump($ret);

error_log("==========test (mset mget) ======================");
$redis->mset(array('key0' => 'value=0', 'key1' => 'value=1'));
var_dump($redis->mget(array('key0','key1')));

error_log("==========test (getLastError) ======================");
var_dump($redis->getLastError());


