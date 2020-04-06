
[引用](http://www.centoscn.com/image-text/config/2016/1214/8277.html)
## 环境说明：
### 系统环境：
    系统：CentOS Linux release 7.2.1511 (Core)
    GCC版本：gcc (GCC) 4.8.5 20150623 (Red Hat 4.8.5-4)
    LNMP环境：
    Nginx版本：1.10.2
    PHP版本：PHP 7.1.0 (cli)
    MySQL版本：5.7.16
    php7安装路径：/usr/local/php7/
    
安装扩展之前先用pear设置php.ini的路径：
```
/usr/local/php7/bin/pear config-set php_ini /usr/local/php7/etc/php.ini
```
这样做的好处就是用pecl安装php扩展的时候，会自动在php.ini中引用扩展包，不用自己手动添加扩展包。

## 1、安装yaf扩展：
```/usr/local/php7/bin/pecl install channel://pecl.php.net/yaf-3.0.4```


> 安装扩展之前先用pear设置php.ini的路径：  
```/usr/local/php7/bin/pear config-set php_ini /usr/local/php7/etc/php.ini```

> 安装yaf  
```/usr/local/php7/bin/pecl install channel://pecl.php.net/yaf-3.0.4```
安装完成之后会自动把yaf.so加入到php.ini中，不用自己手动添加扩展

## 2、安装yaconf扩展：
```/usr/local/php7/bin/pecl install channel://pecl.php.net/yaconf-1.0.4```

## 3、安装swoole扩展：
```/usr/local/php7/bin/pecl install channel://pecl.php.net/swoole-1.9.1```
## 4、安装redis扩展：

### 1、安装Redis服务：
安装教程详见：CentOS7安装Redis

### 2、安装扩展：
/usr/local/php7/bin/pecl install channel://pecl.php.net/redis-3.0.0

## 5、安装SeasLog扩展：
```/usr/local/php7/bin/pecl install channel://pecl.php.net/SeasLog-1.6.8```

## 6、安装memcache扩展：

### 1、首先安装memcache服务端memcached：
```
yum -y install libevent-devel
cd ~ && wget http://memcached.org/latest -O memcached-1.4.33.tar.gz
tar -zxvf memcached-1.4.33.tar.gz
cd memcached-1.4.33
./configure && make && make install
```
详细安装说明请见：Memcached官方说明，安装完成开始启动memcached：
```
memcached -d -l 127.0.0.1 -p 11211 -m 150 -u root  -c 512 -P /var/run/memcached.pid
```
启动参数说明：

    -d选项是启动一个守护进程，
    -l是监听的服务器IP地址，如果有多个地址的话，我这里指定了本机地址127.0.0.1
    -p是设置Memcache监听的端口，我这里设置了默认的11211，最好是1024以上的端口，
    -m是分配给Memcache使用的内存数量，单位是MB，我这里是10MB，
    -u是运行Memcache的用户，我这里是root，
    -c选项是最大运行的并发连接数，默认是1024，我这里设置了512，按照你服务器的负载量来设定，
    -P是设置保存Memcached的pid文件，我这里是保存在/var/run/memcached.pid

启动完成查看启动结果：
```    
ps -ef | grep memcached
```

设置memcache开机启动：
```
echo -e 'memcached -d -l 127.0.0.1 -p 11211 -m 150 -u root  -c 512 -P /var/run/memcached.pid\n' >> /etc/rc.local
```
### 2、安装memcache扩展：

#### Ⅰ、ⅣⅤ安装依赖库libmemcached：
```
cd ~ && wget https://launchpadlibrarian.net/165454254/libmemcached-1.0.18.tar.gz
tar -zxvf libmemcached-1.0.18.tar.gz
cd libmemcached-1.0.18/
./configure
make && make install
```

#### Ⅱ、安装扩展：
```
cd ~ && git clone https://github.com/php-memcached-dev/php-memcached.git
cd php-memcached/
git checkout php7
phpize
./configure --disable-memcached-sasl
make && make install && make test
```

### Ⅲ、配置扩展：在/etc/php.ini中加入以下内容：
```
extension="memcached.so"
```

重启php：
```
kill -USR2 `cat /usr/local/php7/var/run/php-fpm.pid`
```
重启之后查看php是否已经正常加载：
```
php -m|grep memcached
```
如果输出：memcached则说明配置成功