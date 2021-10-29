## 什么是进程

什么是进程，这个就很难说清楚了。

从操作系统的角度来讲，进程是操作系统分配资源的基本单位；

从用户角度来讲，进程是程序的一次动态执行过程，换句话说，就是`运行中的程序`。

> 程序是指计算机能够识别和执行的指令集。也就是编程语言中的代码。

## 常用命令

- `w`

  ```bash
  [root@demo ~]# w
   10:13:34 up 15 days, 16:42,  1 user,  load average: 0.08, 0.03, 0.05
  USER     TTY      FROM             LOGIN@   IDLE   JCPU        PCPU            WHAT
  root     pts/0    180.171.105.238  10:13    6.00s  2:23m       0.00s            w
  登陆用户  虚拟终端/0 来源地            登陆时间  空闲时间 消耗的cpu 正在执行程序消耗的cpu 做什么
  ```

- `who` 

  ```bash
  [root@demo ~]# who
  root     pts/0        2020-04-11 10:16 (180.171.105.238)
  ```

- `ps` 用的最多的命令了

  ```bash
  # 如抓取当前在运行php进程
  ps -ef | grep php
  ps aux | grep apache
  ```

- `kill` 关闭进程

  ```bash
  kill -9 10001 # 关闭某个进程
  pkill php # 关闭某个名字命名的进程
  ```

- `top`、 `fg`、`bg`、`free -h`
