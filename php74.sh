

# 安装依赖
yum update -y \
&& yum install -y \
  gcc \
  autoconf \
  pcre pcre-devel \
  zlib zlib-devel \
  libxml2 libxml2-devel \
  openssl openssl-devel \
  libcurl libcurl-devel \
  libjpeg libjpeg-devel \
  libpng libpng-devel \
  freetype freetype-devel \
  libmcrypt libmcrypt-devel

# 官网源太慢了，换用sohu源
# curl -SL "https://www.php.net/distributions/php-7.2.33.tar.gz" -o php7.tar.gz
cd /root \
&& curl -SL "https://www.php.net/distributions/php-7.4.16.tar.gz"  -o php7.tar.gz \
&& mkdir -p php7 \
&& tar -xf /root/php7.tar.gz -C php7 --strip-components=1 \
&& ( \
  cd php7 \
  && mkdir -p "/etc/php/conf.d" \
  && ./configure \
    --prefix=/usr/local/php7 \
    --with-config-file-path="/etc/php" \
    --with-config-file-scan-dir="/etc/php/conf.d" \
    --with-mysqli \
    --with-pdo-mysql \
    --with-iconv-dir \
    --with-zlib \
    --with-openssl \
    --with-mhash \
    --with-curl \
    --with-fpm-user=nobody \
    --with-fpm-group=nobody \
    --enable-bcmath \
    --enable-soap \
    --enable-fpm \
    --enable-mbstring \
    --enable-sockets \
    --enable-opcache \
    --enable-pcntl \
    --enable-simplexml \
    --enable-xml \
  && make -s -j$(nproc) \
  && make install \
  && /bin/cp -rf php.ini-production /etc/php/php.ini
)

# 设置php-fpm.conf
cd "/usr/local/php7/etc" \
&& /bin/cp -rf  php-fpm.conf.default php-fpm.conf \
&& /bin/cp -rf  php-fpm.d/www.conf.default php-fpm.d/www.conf

# 把PHP加入环境变量
echo "PATH=\$PATH:/usr/local/php7/bin:/usr/local/php7/sbin" > /etc/profile.d/php.sh
echo "export PATH" >> /etc/profile.d/php.sh
source /etc/profile

# 打印PHP版本
php -v
php -m

## 安装swoole
yum install -y glibc-headers gcc-c++
cd /root \
&& curl -SL "https://github.com/swoole/swoole-src/archive/v${SWOOLE_VERSION}.tar.gz" -o swoole.tar.gz \
&& mkdir -p swoole \
&& tar -xf swoole.tar.gz -C swoole --strip-components=1 \
&& ( \
    cd swoole \
    && phpize \
    && ./configure --enable-mysqlnd --enable-openssl --enable-http2 \
    && make -s -j$(nproc) \
    && make install \
) \
&& echo "extension=swoole.so" > /etc/php/conf.d/50_swoole.ini \
&& php --ri swoole

## 安装memcache
cd /root \
&& curl -SL https://github.com/websupport-sk/pecl-memcache/archive/4.0.4.tar.gz -o memcache.tar.gz \
&& mkdir -p memcache \
&& tar -xf memcache.tar.gz -C memcache --strip-components=1 \
&& ( \
    cd memcache \
    && phpize \
    && ./configure --disable-memcache-session \
    && make -s -j$(nproc) \
    && make install \
) \
&& echo "extension=memcache.so" > /etc/php/conf.d/50_memcache.ini \
&& php --ri memcache

## 安装memcached
dnf config-manager --set-enabled PowerTools
yum install -y libmemcached libmemcached-devel

cd /root \
&& curl -SL https://github.com/php-memcached-dev/php-memcached/archive/v3.1.5.tar.gz -o memcached.tar.gz \
&& mkdir -p memcached \
&& tar -xf memcached.tar.gz -C memcached --strip-components=1 \
&& ( \
    cd memcached \
    && phpize \
    && ./configure \
    && make -s -j$(nproc) \
    && make install \
) \
&& echo "extension=memcached.so" > /etc/php/conf.d/50_memcached.ini \
&& php --ri memcached

# 安装amqp依赖、amqp
cd /root \
&& curl -SL https://github.com/alanxz/rabbitmq-c/releases/download/v0.8.0/rabbitmq-c-0.8.0.tar.gz -o rabbitmq-c.tar.gz \
&& mkdir -p rabbitmq-c \
&& tar -xf rabbitmq-c.tar.gz -C rabbitmq-c --strip-components=1 \
&& ( \
    cd rabbitmq-c \
    && ./configure --prefix=/usr/local/rabbitmq-c \
    && make -s -j$(nproc) \
    && make install \
) \
&& cd /root \
&& curl -SL https://github.com/php-amqp/php-amqp/archive/v1.10.2.tar.gz -o rabbitmq.tar.gz \
&& mkdir -p rabbitmq \
&& tar -xf rabbitmq.tar.gz -C rabbitmq --strip-components=1 \
&& ( \
    cd rabbitmq \
    && phpize \
    && ./configure --with-librabbitmq-dir=/usr/local/rabbitmq-c \
    && make -s -j$(nproc) \
    && make install \
) \
&& echo "extension=amqp.so" > /etc/php/conf.d/50_amqp.ini \
&& php --ri amqp

cd /root \
&& curl -SL https://github.com/phpredis/phpredis/archive/5.3.1.tar.gz -o redis.tar.gz \
&& mkdir -p redis \
&& tar -xf redis.tar.gz -C redis --strip-components=1 \
&& ( \
    cd redis \
    && phpize \
    && ./configure \
    && make -s -j$(nproc) \
    && make install \
) \
&& echo "extension=redis.so" > /etc/php/conf.d/50_redis.ini \
&& php --ri redis

echo -e "\033[32m😂 mission completed.\033[0m"



