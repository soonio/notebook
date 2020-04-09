## 什么是shell

Shell 是一个用 C 语言编写的程序，它是用户使用 Linux 的桥梁。Shell 既是一种命令语言，又是一种程序设计语言。

Shell 是指一种应用程序，这个应用程序提供了一个界面，用户通过这个界面访问操作系统内核的服务。

Ken Thompson 的 sh 是第一种 Unix Shell，Windows Explorer 是一个典型的图形界面 Shell。

> 以上内容饮用[菜鸟教程](https://www.runoob.com/linux/linux-shell.html)介绍

## shell便捷操作

- 使用tab键可以对命令，文件名等进行快速补全

- 重定向

  - Shell对于每个进程预先定义了3个文件描述字

    0 标准输入 STDIN	键盘；1 标准输出 STDOUT	显示器；2 标准错误输出 STDERR

    重定向，就是改变这个标准设备，不用键盘输入，不用显示器输出

  - 使用`>`(覆盖模式)或`>>`(追加模式)重定向输出，`<`重定向输入

  - 通过组合，就可以把 脚本执行的结果输入到文件中而不是屏幕上了

    ```bash
    [root@demo ~]# ls -l >test.log
    [root@demo ~]# cat test.log 
    total 12
    -rwxr-xr-x 1 root root 326 Dec 10 16:01 test.sh
    [root@demo ~]# ls -qqw >>test.log 2>&1
    ```

  > 关于`command >>log 2>&1`的问题，就是把commond执行的正常输出log(>>前面省略了1)，同时设置错误内容2输出到1所指向的位置，也就是log文件

- 快捷命令

  - CTRL+C 终止命令
  - CTRL+L 清理屏幕
  - CTRL+D 注销登陆相当于exit和logout或者保存
  - CTRL+Z 将进程在后台挂起

- 管道连接符`|`

  - 将一个命令的输出，传送给另一个命令，作为另一个命令的输入，可以连接多个命令

    ```bash
    ps -ef | grep skeleton | grep -v grep | awk '{print $2}' | awk 'NR==1' | xargs kill -9
    ```

    > 上述例子是从运行的进程中找出名为skeleton，并过滤掉当前 grep进程名称，使用awk选取第二列内容(pid),在此选取第一行内容，最后作为kill -9的参数关闭进程

- 命令连接符

  - 命令分割符(`;`) 被分割的命令之间不相互影响

  - 命令逻辑与符(`&&`) 多个命令使用改符号进行连续执行，如 `cd /home && ls -l`

  - 命令逻辑或符(`||`) 如果前面执行失败，则执行符号之后的，如`haha || which haha`

  - 命令替换符（``）

    ```bash
    [root@demo home]# ls -l `which touch`
    -rwxr-xr-x 1 root root 62480 Aug 20  2019 /usr/bin/touch
    ```

    

Update At : {docsify-updated}