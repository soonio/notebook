# 服务器环境搭建

服务器系统环境 centos7.6


## 系统相关更新

```bash
yum update -y
yum install gcc autoconf pcre pcre-devel zlib zlib-devel libxml2 libxml2-devel openssl openssl-devel libcurl libcurl-devel libjpeg libjpeg-devel libpng libpng-devel freetype freetype-devel libmcrypt libmcrypt-devel glibc-headers gcc-c++  -y
```

## 建立www用户

```bash
groupadd -r www
useradd -r -g www -s /bin/false -M www
```

> groupadd  -r --system 创建一个系统账户
>
> useradd -r 建立系统帐号 -g 指定用户所属的群组 -s 指定用户登入后所使用的shell -M 不要自动建立用户的登入目录

## 安装PHP

### 版本选择及下载

```bash
wget https://www.php.net/distributions/php-7.2.24.tar.gz
tar -zxvf php-7.2.24.tar.gz
cd php-7.2.24
./configure \
	--prefix=/usr/local/php72 \
	--with-mysqli --with-pdo-mysql \
	--with-jpeg-dir --with-png-dir \
	--with-iconv-dir --with-freetype-dir \
	--with-zlib --with-libxml-dir \
	--with-gd --with-openssl \
	--with-mhash --with-curl --with-pear \
	--with-fpm-user=www --with-fpm-group=www \
	--enable-bcmath --enable-soap \
	--enable-zip --enable-fpm \
	--enable-mbstring --enable-sockets \
	--enable-opcache --enable-pcntl \
	--enable-simplexml --enable-xml \
	--disable-fileinfo --disable-rpath 
make && make install
cp php.ini-production /usr/local/php72/lib/php.ini
cd /usr/local/php72/etc \
&& cp php-fpm.conf.default php-fpm.conf \
&& cp php-fpm.d/www.conf.default php-fpm.d/www.conf

```

> php的进程数还需要根据实际情况进行配置

### 添加环境变量

```bash
vim /etc/profile # 在 export PATH ...前一行加入下一行的内容(无#号)
# PATH=$PATH:/usr/local/php72/bin:/usr/local/php72/sbin 
source /etc/profile
php -v # 可以看到php的命令已经生效
```

### 设置开机启动

```
cp php-src-dir/sapi/fpm/init.d.php-fpm /etc/init.d/php-fpm 
chmod +x /etc/init.d/php-fpm # 添加可执行权限
/sbin/chkconfig php-fpm on # 设置开机启动
systemctl start php-fpm.service 
```

###扩展安装

#### fileinfo(php内置的)

```
cd php-7.2.24/ext/fileinfo
phpize && ./configure && make && make install
vim /usr/local/php72/lib/php.ini # 搜索extension=fileinfo删除前面的#
php -m | grep fileinfo # 可以查看到输出fileinfo即为安装配置成功
```



#### swolle(外部下载)

```bash
wget https://github.com/swoole/swoole-src/archive/v4.4.8.tar.gz
tar zxf v4.4.8.tar.gz && cd swoole-src-4.4.8/
phpize && ./configure && make && make install
vim /usr/local/php72/lib/php.ini # 加入extension=swoole
php -m | grep fileinfo # 可以查看到输出swoole即为安装配置成功
```

### 安装composer

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php --install-dir=/usr/local/bin --filename=composer
php -r "unlink('composer-setup.php');"
```



## 安装nginx

```bash
mkdir /var/tmp/nginx
wget http://nginx.org/download/nginx-1.17.5.tar.gz
tar zxf nginx-1.17.5.tar.gz && cd nginx-1.17.5
./configure \
	--prefix=/usr/local/nginx \
	--conf-path=/usr/local/nginx/conf/nginx.conf \
	--pid-path=/usr/local/nginx/conf/nginx.pid \
	--lock-path=/var/lock/nginx.lock \
	--error-log-path=/var/log/nginx/error.log \
	--http-log-path=/var/log/nginx/access.log \
	--http-client-body-temp-path=/var/tmp/nginx/client \
	--http-proxy-temp-path=/var/tmp/nginx/proxy \
	--http-fastcgi-temp-path=/var/tmp/nginx/fastcgi \
	--http-uwsgi-temp-path=/var/tmp/nginx/uwsgi \
	--http-scgi-temp-path=/var/tmp/nginx/scgi \
	--with-http_gzip_static_module \
	--with-http_stub_status_module \
	--with-http_ssl_module \
	--user=www --group=www
make && make install
vim /etc/profile #在上文的PHP环境变量后加入":/usr/local/nginx/sbin"
source /etc/profile
```

> 创建的/var/tmp/nginx用于存放nginx相关的数据

### 设置开机启动

```bash
vim /usr/lib/systemd/system/nginx.service
```

```reStructuredText
[Unit]
Description=nginx
After=network.target
  
[Service]
Type=forking
ExecStart=/usr/local/nginx/sbin/nginx
ExecReload=/usr/local/nginx/sbin/nginx -s reload
ExecStop=/usr/local/nginx/sbin/nginx -s quit
PrivateTmp=false
  
[Install]
WantedBy=multi-user.target
```

启用nginx的开机启动

```
systemctl enable nginx.service
```



### 添加vhost

```
mkdir /usr/local/nginx/conf/vhost
vim /usr/local/nginx/conf/nginx.conf
```

```
http {
		...
		include vhost/*.conf
}
```

### 虚拟域名

```conf
server {
    listen 80;
    server_name  www.domain.com;
    rewrite ^(.*)$ https://$host$1 permanent;
}
server {
    listen       443 ssl;
    server_name  www.domain.com;

    #charset koi8-r;
    #access_log  /var/log/nginx/host.access.log  main;
    root /src-code/;
    index index.html index.htm index.php;

    ssl_certificate  cert/www.domain.com.pem;
    ssl_certificate_key  cert/www.domain.com.key;
    ssl_session_timeout 5m;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;
    
    location / {
        if (!-e $request_filename) {
            rewrite  ^/(.*)$  /index.php/$1  last;
            break;
        }
    }
    
    location ~ \.php {
        include fastcgi_params;
        fastcgi_split_path_info ^(.+\.php)(.*)$;
        fastcgi_param PATH_INFO $fastcgi_path_info;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass  127.0.0.1:9000;
        fastcgi_index index.php;
    }
    
    location ^~ /ws/ {
        proxy_pass http://127.0.0.1:9501;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
    }
    
    location ~ /\.(ht|svn|git) {
        deny all;
    }
}
```



## 安装docker

```bash
sudo yum install -y yum-utils device-mapper-persistent-data lvm2
sudo yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
sudo yum-config-manager --enable docker-ce-nightly
sudo yum install docker-ce docker-ce-cli containerd.io -y
sudo systemctl start docker
```

### 设置docker开机启动

```bash
systemctl enable docker
```

### 安装docker中的redis

```
docker pull redis
mkdir -p /data/db/redis
# 需要创建/data/db/redis/redis.conf配置文件(可以从docker容器中复制)
docker run -d \
  --name redis \
  -v /data/db/redis:/data \
  -p 6379:6379 \
  --restart unless-stopped \
  redis redis-server /data/redis.conf --appendonly yes
```

> /data/db/redis/redis.conf的requirepass:12345678 开启并设置密码，bind 修改为0.0.0.0

### 安装docker中的mysql

```
docker pull mysql:5.7.20
mkdir -p /data/db/mysql/data
mkdir -p /data/db/mysql/backup

docker run \
    -v /data/db/mysql/data:/var/lib/mysql \
    -v /data/db/mysql/backup:/data \
    -p 3306:3306 --name mysql \
    -e MYSQL_ROOT_PASSWORD=12345678 \
    --privileged=true \
    --restart unless-stopped \
    --name mysql \
    -d mysql:5.7
```

## 数据备份机制&恢复

### docker中的数据库定时备份shell

Crontab

```bash
30 0 * * * /data/shell/mysql-backup.sh 
```

备份脚本

```bash
#!/bin/bash
backup_dir='/home/mysql/backup'
# 如果备份目录不存在则创建备份目录
if [ ! -d $backup_dir ]; then
  sudo mkdir -p -m 755 $backup_dir
  echo "sudo mkdir -p -m 755 ${backup_dir} done"
fi
dbname='cube' # 备份的数据库
oldsql=$dbname'-'`date +%Y%m%d --date="-8 day"`'-bak.sql'
newsql=$dbname'-'`date +%Y%m%d`'-bak.sql'
find $backup_dir -name $oldsql  -exec rm -rf {} \; # 查找并删除旧的备份
# 从docker中备份数据库
docker exec -it mysql mysqldump -u root -p12345678 --single-transaction cube > $backup_dir/$newsql
```

> chmod +x /data/shell/mysql-backup.sh 给脚本加权限
>
>  sed -i '1d' filename 删除备份文件的第一行，第一行为mysql提示密码明文输入的notice，可以先用more命令查看第一行的内容

### 二进制日志

### 数据恢复

```bash
mysql -u root -p dbname < /var/lib/mysql/demo.sql
```



TODO

## 进程守护工具

### supervisor

安装

```
yum install -y epel-release
yum install -y supervisor  
```

> 默认配置文件 /etc/supervisord.conf，扩展配置目录/etc/supervisord.d/*.ini

创建配置文件demo.ini

```ini
# 新建一个应用并设置一个名称，这里设置为 demo
[program:demo]
# 设置命令在指定的目录内执行
directory=/data/www/demo
# 这里为您要管理的项目的启动命令
command=php demo-cli.php
# 以哪个用户来运行该进程
user=root
# supervisor 启动时自动该应用
autostart=true
# 进程退出后自动重启进程
autorestart=true
# 进程持续运行多久才认为是启动成功
startsecs=1
# 重试次数
startretries=3
# stderr 日志输出位置
stderr_logfile=/tmp/logs/demo/stderr.log
# stdout 日志输出位置
stdout_logfile=/tmp/logs/demo/stdout.log
```

测试脚本

```php
<?php
$i = 10;
while ($i--) {
    echo date('Y-m-d H:i:s') . " info ...\n";
    sleep(3);
}
```

启动supervisor

```
/usr/bin/supervisord -c /etc/supervisord.conf 
```

> 安装supervisor默认会自动启动，设置完配置后，启动supervisor需要kill掉之前的进程

关闭某个进程

```bash
supervisorctl stop demo
```

