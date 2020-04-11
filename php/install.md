

## 源码安装

- 下载PHP72

  [PHP下载页面](https://www.php.net/downloads)

- 安装前的准备
  - 安装相关的环境

    ```bash
    yum install -y gcc autoconf
    yum install -y pcre pcre-devel
    yum install -y zlib zlib-devel
    yum install libxml2 libxml2-devel openssl openssl-devel libcurl libcurl-devel libjpeg libjpeg-devel libpng libpng-devel freetype freetype-devel libmcrypt libmcrypt-devel -y
    ```
- 配置安装
  - 执行./configure 命令

    ```bash
    ./configure --prefix=/usr/local/php72 --with-mysqli --with-pdo-mysql --with-jpeg-dir --with-png-dir  --with-iconv-dir --with-freetype-dir --with-zlib --with-libxml-dir --with-gd --with-openssl --with-mhash --with-curl --with-pear --with-fpm-user=nobody --with-fpm-group=nobody --enable-bcmath --enable-soap --enable-zip --enable-fpm --enable-mbstring --enable-sockets --enable-opcache --enable-pcntl --enable-simplexml --enable-xml --disable-fileinfo --disable-rpath 
    ```
    > --with-fpm-user=nobody --with-fpm-group=nobody 设置为www用户也可以
    
  - 编译和安装

    ```bash
    make && make install
    ```

  - 复制配置文件到php的配置目录

    ```bash
    cp php.ini-development /usr/local/php72/lib/php.ini
    ```


> 注意目录的对应,生产环境的为php.ini-production

## Dnf(centos8)

```bash
dnf module list php
dnf module enable php:remi-7.2
dnf install php php-cli php-common
php -v
```

## Yum(Centos7)

TODO