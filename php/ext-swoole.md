## 安装

参考[扩展模块](php/ext?id=源码安装)

## 官方文档

[swoole官方文档](https://wiki.swoole.com/)

## swoole动态proces管理样例

```php
<?php

/**
 * 动态进程池，类似fpm
 * 动态新建进程
 * 有初始进程数，最小进程数，进程不够处理时候新建进程，不超过最大进程数
 */

use Swoole\Process;

// 一个进程定时投递任务

/**
 * 1. tick
 * 2. process及其管道通讯
 * 3. event loop 事件循环
 */
class processPool
{
    private $pool;

    /**
     * @var Process[] 记录所有worker的process对象
     */
    private $workers = [];

    /**
     * @var array 记录worker工作状态
     */
    private $usedWorkers = [];

    /**
     * @var int 最小进程数
     */
    private $minWorkerNum = 5;

    /**
     * @var int 初始进程数
     */
    private $startWorkerNum = 10;

    /**
     * @var int 最大进程数
     */
    private $maxWorkerNum = 20;

    /**
     * 进程闲置销毁秒数
     * @var int
     */
    private $idleSeconds = 5;

    /**
     * @var int 当前进程数
     */
    private $currNum;

    /**
     * 闲置进程时间戳
     * @var array
     */
    private $activeTime = [];

    public function __construct()
    {
        $this->pool = new Process(function () {
            // 循环建立worker进程
            for ($i = 0; $i < $this->startWorkerNum; $i++) {
                $this->createWorker();
            }
            echo '初始化进程数：' . $this->currNum . PHP_EOL;
            // 每秒定时往闲置的worker的管道中投递任务
            swoole_timer_tick(1000, function ($timerId) {
                static $count = 0;
                $count++;
                $needCreate = true;
                foreach ($this->usedWorkers as $pid => $used) {
                    if ($used == 0) {
                        $needCreate = false;
                        $this->workers[$pid]->write($count . ' job');
                        // 标记使用中
                        $this->usedWorkers[$pid] = 1;
                        $this->activeTime[$pid] = time();
                        break;
                    }
                }
                foreach ($this->usedWorkers as $pid => $used)
                    // 如果所有worker队列都没有闲置的，则新建一个worker来处理
                    if ($needCreate && $this->currNum < $this->maxWorkerNum) {
                        $newPid = $this->createWorker();
                        $this->workers[$newPid]->write($count . ' job');
                        $this->usedWorkers[$newPid] = 1;
                        $this->activeTime[$newPid] = time();
                    }

                // 闲置超过一段时间则销毁进程
                foreach ($this->activeTime as $pid => $timestamp) {
                    if ((time() - $timestamp) > $this->idleSeconds && $this->currNum > $this->minWorkerNum) {
                        // 销毁该进程
                        if (isset($this->workers[$pid]) && $this->workers[$pid] instanceof swoole_process) {
                            $this->workers[$pid]->write('exit');
                            unset($this->workers[$pid]);
                            $this->currNum = count($this->workers);
                            unset($this->usedWorkers[$pid]);
                            unset($this->activeTime[$pid]);
                            echo "{$pid} destroyed\n";
                            break;
                        }
                    }
                }

                echo "任务{$count}/{$this->currNum}\n";

                if ($count == 20) {
                    foreach ($this->workers as $pid => $worker) {
                        $worker->write('exit');
                    }
                    // 关闭定时器
                    swoole_timer_clear($timerId);
                    // 退出进程池
                    $this->pool->exit(0);
                    exit();
                }
            });

        });

        $master_pid = $this->pool->start();
        echo "Master $master_pid start\n";

        while ($ret = swoole_process::wait()) {
            $pid = $ret['pid'];
            echo "process {$pid} existed\n";
        }
    }

    /**
     * 创建一个新进程
     * @return int 新进程的pid
     */
    public function createWorker()
    {
        $workerProcess = new Process(function (Process $worker) {
            // 给子进程管道绑定事件
            swoole_event_add($worker->pipe, function ($pipe) use ($worker) {
                $data = trim($worker->read());
                if ($data == 'exit') {
                    $worker->exit(0);
                    exit();
                }
                echo "{$worker->pid} 正在处理 {$data}\n";
                sleep(5);
                // 返回结果，表示空闲
                $worker->write("complete");
            });
        });

        $workerPid = $workerProcess->start();

        // 给父进程管道绑定事件
        swoole_event_add($workerProcess->pipe, function ($pipe) use ($workerProcess) {
            $data = trim($workerProcess->read());
            if ($data == 'complete') {
                // 标记为空闲
                // echo "{$workerProcess->pid} 空闲了\n";
                $this->usedWorkers[$workerProcess->pid] = 0;
            }
        });

        // 保存process对象
        $this->workers[$workerPid] = $workerProcess;
        // 标记为空闲
        $this->usedWorkers[$workerPid] = 0;
        $this->activeTime[$workerPid] = time();
        $this->currNum = count($this->workers);
        return $workerPid;
    }

}

new processPool();
```