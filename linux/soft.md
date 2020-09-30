> 软件即命令，主要列出我用过的或常用的

## vi/vim

linux上的文字编辑器，具体的介绍及用法移步[菜鸟教程](https://www.runoob.com/linux/linux-vim.html)

> 快捷键很多，反正我是没记住，只会vim打开文件，修改文件，退出

## yum

Yellowdog Updater Modified一个软件包管理工具,`man yum` 查看用法

## tar 压缩/解压缩文件

```bash
[root@demo ~]# tar -zxvf test.tar.gz 
test.log
```

```
tar -cf archive.tar foo bar  # 压缩foo和bar为压缩文件archive.tar.
tar -tvf archive.tar         # 列出所有文件.
tar -xf archive.tar          # 解压文件
```

| 短名称 | 长名称                     | 说明                                         |
| :----: | :------------------------- | :------------------------------------------- |
|   -c   | --create                   | 创建一个归档文件                             |
|   -x   | --extract, --get           | 从存档中提取文件                             |
|   -f   | --file=ARCHIVE             | 实用归档文件或设备归档文件                   |
|   -z   | --gzip, --gunzip, --ungzip | 使用GZIP解压文件(处理对应后缀的文件.gz,.taz) |
|   -Z   | --compress, --uncompress   | 使用GZIP压缩文件(文件后缀要有.gz,taz)        |
|   -v   | --verbose                  | 输出处理的过程                               |

## zip/unzip

```bash
zip -q -r test.zip ./
unzip test.zip -d /tmp
```

## wget/curl 下载文件

```bash
wget www.baidu.com
curl www.baidu.com
```

## rsync 同步文件



Update At : {docsify-updated}