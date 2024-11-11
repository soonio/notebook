

## 源码安装

  - 下载PHP72及解压源码包
   [PHP源码包地址](https://www.php.net/downloads)
  - 安装前的准备
    ```bash
    yum install -y gcc autoconf
    yum install -y pcre pcre-devel
    yum install -y zlib zlib-devel
    yum install libxml2 libxml2-devel openssl openssl-devel libcurl libcurl-devel libjpeg libjpeg-devel libpng libpng-devel freetype freetype-devel libmcrypt libmcrypt-devel -y
    ```
  - 执行./configure 命令
    ```bash
    ./configure --prefix=/usr/local/php72 \
      --with-mysqli \
      --with-pdo-mysql \
      --with-jpeg-dir \
      --with-png-dir \
      --with-iconv-dir \
      --with-freetype-dir \
      --with-zlib \
      --with-libxml-dir \
      --with-gd \
      --with-openssl \
      --with-mhash \
      --with-curl \
      --with-pear \
      --with-fpm-user=nginx \
      --with-fpm-group=nginx \
      --enable-bcmath \
      --enable-soap \
      --enable-zip \
      --enable-fpm \
      --enable-mbstring \
      --enable-sockets \
      --enable-opcache \
      --enable-pcntl \
      --enable-simplexml \
      --enable-xml 
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

## 安装扩展
  - 方式一: `pecl`安装扩展
  ```bash
  # 要先安装pecl命令才能使用
  yum install php-pear php-devel -y
  # 如安装swoole扩展
  pecl install swoole
  ```
  - 方式二: 源码安装
  ```bash
  # 安装依赖工具
  yum install gcc autoconf -y
  # 如安装swoole扩展
  yum install glibc-headers
  yum install gcc-c++
  curl -SL "https://github.com/swoole/swoole-src/archive/refs/tags/v4.8.0.tar.gz"  -o swoole.tar.gz \
    && mkdir -p swoole \
    && tar -xf swoole.tar.gz -C swoole --strip-components=1 \
    && cd swoole \
    && phpize && ./configure && make && make install
  ```
  > 找到`php.ini`, 搜索";extension=",在最后一个被搜索到的地方添加extension=swoole.so，然后`php -ir | grep swoole`查看swoole信息

## 安装composer包管理工具
  ```shell
  # 下载 https://github.com/composer/composer/releases
  wget https://github.com/composer/composer/releases/download/2.0.12/composer.phar
  wget https://getcomposer.org/download/2.0.12/composer.phar

  # 放到用户bin目录
  chmod u+x composer.phar && mv composer.phar /usr/local/bin/composer

  ```

## 自动重启

  - 启用进程id保存到文件 (/usr/local/php7/etc/php-fpm.conf => pid=run/php-fpm.pid)
  - 编写systemctl管理的配置文件 `/usr/lib/systemd/system/php-fpm.service`
    ```
    [Unit]
    Description=The PHP FastCGI Process Manager
    After=system.target network.target
    
    [Service]
    Type=forking
    PIDFile=/usr/local/php7/var/run/php-fpm.pid
    ExecStartPre=/usr/bin/rm -f /usr/local/php7/var/run/php-fpm.pid
    ExecStart=/usr/local/php7/sbin/php-fpm 
    ExecReload=/bin/kill -USR2 $MAINPID
    PrivateTmp=true
    
    [Install]
    WantedBy=multi-user.target
    ```
  - systemctl enable php-fpm.service (设置开机启动)
  - systemctl daemon-reload 重启服务