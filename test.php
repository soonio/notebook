<?php

// 测试脚本

/**
 * 测试数据库链接状态
 * @param $host
 * @param $port
 * @param $user
 * @param $password
 * @param $database
 */
function test_mysql($host, $port, $user, $password, $database)
{
    $dsn = "mysql:host={$host}:{$port};dbname={$database}";

    try {
        new PDO($dsn, $user, $password);
    } catch (PDOException $exception) {
        var_dump($exception->getCode());
        echo "数据库 链接失败\n";
        return;
    }
    echo "链接成功：{$dsn}\n";
}

/**
 * 测试链接redis
 * @param $host
 * @param $port
 * @param null $password
 */
function test_redis($host, $port, $password=null)
{
    $r = new \Redis();
    try {
        $r->connect($host, $port, 1);
    } catch (RedisException $exception) {
        echo "redis 链接失败\n\t" . $exception->getMessage();
        return;
    }
    $password && $r->auth($password);
    try {
        if ($r->set('test111', 1) && $r->get('test111') == 1) {
            echo "redis链接成功\n";
        } else {
            echo "redis读写校验失败\n";
        }
    } catch (Exception $exception) {
        echo "redis 读写异常\n\t" . $exception->getMessage();
    }

}

/**
 * 测试链接rabbitmq
 * @param $host
 * @param $port
 * @param $login
 * @param $password
 * @throws AMQPChannelException
 * @throws AMQPConnectionException
 * @throws AMQPExchangeException
 * @throws AMQPQueueException
 */
function test_rabbitmq($host, $port, $login, $password)
{
    $conn = new AMQPConnection([
        'host'      => $host,
        'port'      => $port,
        'login'     => $login,
        'password'  => $password,
    ]);
    try {
        $conn->connect();
    } catch (AMQPConnectionException $e) {
        echo "链接rabbitMQ失败\n\t:" . $e->getMessage() . PHP_EOL;
        return;
    }

    try {
        $channel = new AMQPChannel($conn);
    } catch (AMQPConnectionException $e) {
        echo "创建rabbitMQ-channel失败\n\t:" . $e->getMessage() . PHP_EOL;
        return;
    }

    try {
        $exchange = new AMQPExchange($channel);
    } catch (AMQPConnectionException $e) {
        echo "因为connection导致创建exchange失败\n\t:" . $e->getMessage() . PHP_EOL;
        return;
    } catch (AMQPExchangeException $e) {
        echo "导致创建exchange失败\n\t:" . $e->getMessage() . PHP_EOL;
        return;
    }
    $exchange->setName("TestExchange");
    $exchange->setType(AMQP_EX_TYPE_DIRECT);
    $exchange->declareExchange();

    // 发布消息
    $exchange->publish(date('Y-m-d H:i:s') . "发布一条消息", "TestQueue");

    // 消费消息
    $queue = new AMQPQueue($channel);
    $queue->setName("TestQueue");
    $queue->setFlags(AMQP_DURABLE);
    $queue->declareQueue();

    $queue->bind("TestExchange", 'TestQueue');
    try {
        $queue->consume(function (AMQPEnvelope $envelope, AMQPQueue $queue) {
            echo "rabbit MQ消费成功, 消息内容为：" . $envelope->getBody() . "\n";
            throw new Exception("使用异常抛出的方式中断队列", 50000);
        });
    } catch (Exception $exception) {
        if ($exception->getCode() == 50000) {
            echo $exception->getMessage() . "\n";
            echo "rabbitMQ 链接正常\n";
        }
    }
}

/**
 * 测试链接memcache
 * @param $host
 * @param $port
 */
function test_memcache($host, $port)
{
    $m = new Memcache();
    if ($m->connect($host, $port)) {
        $m->set('JustForTestMemcache', '2020');
        echo "Memcache 链接成功" . $m->get('JustForTestMemcache');
        $m->delete('JustForTestMemcache');
    } else {
        echo "Memcache链接失败";
    }
}


test_mysql('192.168.1.7', 3306, 'root', '12345678', 'mysql');
test_redis('192.168.1.7', 6379, '12345678');
test_rabbitmq('192.168.1.4', 5672, 'admin', '12345678');
test_memcache('192.168.1.7', 11211);
