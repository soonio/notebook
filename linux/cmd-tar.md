[TOC]

# TAR 

> 2018年12月11日

> 也叫归档文件实用工具，能加压解压文件

## 1 实例

Examples:

```php 
tar -cf archive.tar foo bar  # 压缩foo和bar为压缩文件archive.tar.
tar -tvf archive.tar         # 列出所有文件.
tar -xf archive.tar          # 解压文件
```



## 2 常用可选参数

| 短名称 | 长名称                     | 说明                                         |
| :----: | -------------------------- | -------------------------------------------- |
|   -c   | --create                   | 创建一个归档文件                             |
|   -x   | --extract, --get           | 从存档中提取文件                             |
|   -f   | --file=ARCHIVE             | 实用归档文件或设备归档文件                   |
|   -z   | --gzip, --gunzip, --ungzip | 使用GZIP解压文件(处理对应后缀的文件.gz,.taz) |
|   -Z   | --compress, --uncompress   | 使用GZIP压缩文件(文件后缀要有.gz,taz)        |
|   -v   | --verbose                  | 输出处理的过程                               |

## 常见操作

```BASH
TODO
```

