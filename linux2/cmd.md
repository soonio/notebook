## 目录操作命令

- ls 列出目录内容命令

  ```bash
  [root@demo ~]# ll
  total 0
  -rw-r--r-- 1 root root 0 Apr  9 00:04 a.txt
  ```

	> ll是`ls -al`的缩写，详细用法使用`man ls`查看

	ls -l 的内容说明

  | 位置 |     1      |    2     |   3    |  4   |  5   |        6         |   7    |
  | :--: | :--------: | :------: | :----: | :--: | :--: | :--------------: | :----: |
  | 内容 | -rw-r--r-- |    1     |  root  | root |  0   |   Apr  9 00:04   | a.txt  |
  | 说明 |   权限位   | 引用计数 | 所有者 | 属组 | 大小 | 最后一次修改时间 | 文件名 |

	> 其中权限位中的第一位由`-`、`l`、`d`等，分别表示普通文件，链接文件，目录

- cd 切换目录命令

  ```bash
  [root@demo ~]# cd /home
  [root@demo home]# 
  ```

- pwd 显示当前所在目录

  ```bash
  [root@demo home]# pwd
  /home
  ```

- mkdir 创建目录

  ```bash
  [root@demo home]# mkdir project
  [root@demo home]# ll
  drwxr-xr-x 2 root root 4096 Apr  9 00:16 project
  ```

- rmdir 删除目录

  ```bash
  [root@demo home]# rmdir project
  ```

	>该命令只能删除空目录

## 文件操作命令

- touch 创建文件

  ```bash
  [root@demo home]# touch index.html
  ```

- rm 删除文件

  ```bash
  [root@demo home]# rm index.html
  ```

	> rm -r 递归删除目录

- cat 获取文件所以内容并输出

  ```bash
  [root@demo home]# cat index.html
  ```

- more 分屏显示文件内容

  ```bash
  [root@demo home]# more index.html
  ```

- head 显示文件前几行

  ```bash
  [root@demo home]# head index.html
  ```

- tail 显示文件后几行

  ```bash
  [root@demo home]# tail -f index.html
  ```

- ln 创建软连接

  ```bash
  [root@demo home]# ln -s /home/test/dir /root/test-dir
  ```

## 文件目录通用命令

- mv 移动或修改文件/目录名

- cp 复制文件/目录[并改名]

## 文件权限管理命令

- 权限位说明`-rw-r--r-- `
  - 第1位：文件类型
  - 第2~4位：属主权限[u]
  - 第5~7位：属组权限[g]
  - 第8~10位：其他人权限[o]
	> r 读权限 w写权限 x执行权限

- chmod 修改权限 

	`chmod u+x` u位增加执行权限

- chgrp 修改归属组

- chown 修改归属人

## 用户管理

- useradd

- passwd

## 帮助命令

- man
- help

## 查找命令

- whereis
- find

  ```bash
  find	/etc	-name	init*	
  ## 查找当前目录下名称中包含2019的文件并删除
  find . -maxdepth 1 -name "*20190*" | xargs rm -rf
  ```

## 加压解压文件

- tar
- zip/unzip

## 网络命令

- ping
- ifconfig
- scp
- ssh

## 关机重启

- shutdown -h now

- reboot

## 挂载

- mount

## 服务器信息

- `top` 命令

  ```bash
  top - 18:10:53 up 162 days, 23:57,  1 user,  load average: 0.04, 0.09, 0.13
  Tasks: 146 total,   1 running, 145 sleeping,   0 stopped,   0 zombie
  %Cpu(s):  1.8 us,  0.2 sy,  0.0 ni, 97.8 id,  0.2 wa,  0.0 hi,  0.0 si,  0.0 st
  KiB Mem : 15732560 total,  3188612 free,  1852516 used, 10691432 buff/cache
  KiB Swap:        0 total,        0 free,        0 used. 13394744 avail Mem 

    PID USER      PR  NI    VIRT    RES    SHR S  %CPU %MEM     TIME+ COMMAND   
  10845 www       20   0  252592  27800   5396 S   3.3  0.2   2:42.86 php-fpm  
  12017 www       20   0  252452  27756   5380 S   3.0  0.2   2:28.27 php-fpm 
  21847 polkitd   20   0 2656416 513856  13500 S   1.0  3.3 772:09.35 mysqld        
  ```
  
- free
  ```bash
  [root@demo ~]# free -h
                total        used        free      shared  buff/cache   available
  Mem:            15G        1.8G        3.0G        145M         10G         12G
  Swap:            0B          0B          0B
  ```
  
- df
  ```bash
  [root@demo ~]# df -h
  Filesystem      Size  Used Avail Use% Mounted on
  devtmpfs        7.5G     0  7.5G   0% /dev
  ```

- netstat

  ```bash
  [root@demo web]# sudo netstat -antp | grep 22
  tcp        0      0 0.0.0.0:22        0.0.0.0:*        LISTEN      967/sshd
  tcp        0      0 172.17.0.4:22     x.x.x.x:51582    ESTABLISHED 18280/sshd: root [p 
  tcp        0      0 172.17.0.4:22     q.q.q.q:7894     SYN_RECV    -
  tcp        0      0 172.17.0.4:22     q.q.q.q:12291    SYN_RECV    -
  tcp        0      0 172.17.0.4:22     q.q.q.q:51440    SYN_RECV    -
  ```

  

## 其他命令

- history

## 命令别名

```bash
[root@demo ~]# alias haha='ls -l'
[root@demo ~]# haha
total 12
-rwxr-xr-x 1 root root 326 Dec 10 16:01 test.sh
[root@demo ~]# cat ~/.bashrc 
# .bashrc
# 用户自定义的别名和方法
alias rm='rm -i'
alias cp='cp -i'
alias mv='mv -i'
# Source global definitions
if [ -f /etc/bashrc ]; then
	. /etc/bashrc
fi
```

> `source  ~/.bashrc` 可以让当前修改的.bashrc立即生效

## 命令大全

又是[菜鸟教程](https://www.runoob.com/linux/linux-command-manual.html)

## 命令应用

- 查找进程并关闭

```bash
ps -ef | grep a.php | grep -v grep | awk '{print $2}' | awk 'NR==1' | xargs kill -9
```



Update At : {docsify-updated}