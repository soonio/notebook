[TOC]

# 编译安装Python

> 2018年12月12日



## 1 Read Hat 发行版

### 1.1下载解压

```bash
wget https://www.python.org/ftp/python/3.7.0/Python-3.7.0.tgz
tar -zxvf Python-3.7.0.tgz
```

### 1.2 安装依赖

```bash
yum -y install zlib zlib-devel bzip2 bzip2-devel ncurses ncurses-devel readline readline-devel openssl openssl-devel openssl-static xz lzma xz-devel sqlite sqlite-devel gdbm gdbm-devel tk tk-devel libffi-devel
```

### 1.3 config

```bash
./configure --prefix=/usr/local/python3 --enable-optimizations
```

### 1.4 编译安装

```bash
make && make install
```

### 1.5 配置

```bash
ln -s /usr/local/python37/bin/python3 /usr/bin/python3

ln -s /usr/local/python37/bin/pip3 /usr/bin/pip3
```

## 2 Debian发行版

### 2.1 下载解压

> 同红帽发行版

### 2.2 安装依赖



### 2.3 configure

```bash
./configure --prefix=/opt/python37 --with-ssl
```



### 2.4 编译安装



### 2.5 配置



## 3 安装注意事项



- 进行configure的时候，如果--enable-optimizations就不用使用--with-ssl，二选一即可，否则使用的时候可能出错
- 时间充裕的情况下尽量启用--enable-optimizations

## 4 使用注意事项

在安装mysqlclient模块时，可能出现 以下情况

```bash
OSError: mysql_config not found
```

安装扩展以解决

```bash
apt-get install libmysqlclient-dev python3-dev
```

