## 目录操作命令

### ls 列出目录内容命令

```bash
[root@demo ~]# ll
total 0
-rw-r--r-- 1 root root 0 Apr  9 00:04 a.txt
```

> ll是`ls -al`的缩写，详细用法使用`man ls`查看

### ls -l 的内容说明

| 位置 |     1      |    2     |   3    |  4   |  5   |        6         |   7    |
| :--: | :--------: | :------: | :----: | :--: | :--: | :--------------: | :----: |
| 内容 | -rw-r--r-- |    1     |  root  | root |  0   |   Apr  9 00:04   | a.txt  |
| 说明 |   权限位   | 引用计数 | 所有者 | 属组 | 大小 | 最后一次修改时间 | 文件名 |

> 其中权限位中的第一位由`-`、`l`、`d`等，分别表示普通文件，链接文件，目录

### cd 切换目录命令

```bash
[root@demo ~]# cd /home
[root@demo home]# 
```

### pwd 显示当前所在目录

```bash
[root@demo home]# pwd
/home
```

### mkdir 创建目录

```bash
[root@demo home]# mkdir project
[root@demo home]# ll
drwxr-xr-x 2 root root 4096 Apr  9 00:16 project
```

### rmdir 删除目录

```bash
[root@demo home]# rmdir project
```

>该命令只能删除空目录

## 文件操作命令

### touch 创建文件

```bash
[root@demo home]# touch index.html
```

### rm 删除文件

```bash
[root@demo home]# rm index.html
```

> rm -r 递归删除目录

### cat 获取文件所以内容并输出

```bash
[root@demo home]# cat index.html
```

### more 分屏显示文件内容

```bash
[root@demo home]# more index.html
```

### head 显示文件前几行
```bash
[root@demo home]# head index.html
```

### tail 显示文件后几行

```bash
[root@demo home]# tail -f index.html
```

### ln 创建软连接
```bash
[root@demo home]# ln -s /home/test/dir /root/test-dir
```

## 文件目录通用命令

### mv 移动或修改文件/目录名

### cp 复制文件/目录[并改名]

## 文件权限管理命令

### 权限位说明

`-rw-r--r-- `

- 第1位：文件类型
- 第2~4位：属主权限[u]
- 第5~7位：属组权限[g]
- 第8~10位：其他人权限[o]

r 读权限 w写权限 x执行权限

### chmod 修改权限 

`chmod u+x` u位增加执行权限

### chgrp 修改归属组

### chown 修改归属人

## 用户管理

### useradd

### passwd

## 帮助命令

### man

### help

## 查找命令

### whereis

### find

```bash
find	/etc	-name	init*	
```

## 加压解压文件

### tar

### zip/unzip

## 网络命令

### ping

### ifconfig

## 关机重启

shutdown -h now

reboot

## 挂载

### mount

## 服务器监控

Top

## 其他命令

### history

