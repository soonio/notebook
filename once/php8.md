## Centos8一键安装PHP8.0

```shell
yum update -y \
&& yum install -y \
  gcc \
  autoconf automake libtool \
  pcre pcre-devel \
  zlib zlib-devel \
  libxml2 libxml2-devel \
  openssl openssl-devel \
  libcurl libcurl-devel \
  libjpeg libjpeg-devel \
  libpng libpng-devel \
  freetype freetype-devel \
  libmcrypt libmcrypt-devel \
  sqlite-devel

curl -SL "https://github.com/kkos/oniguruma/archive/v6.9.4.tar.gz"  -o oniguruma694.tar.gz \
&& mkdir -p oniguruma694 \
&& tar -xf /root/oniguruma694.tar.gz \
&& ( \
  cd oniguruma694 \
  && ./autogen.sh \
  && ./configure --prefix=/usr \
  && make -s -j$(nproc) \
  && make install \
)

cd /root \
&& curl -SL "http://mirrors.sohu.com/php/php-8.0.1.tar.gz"  -o php80.tar.gz \
&& mkdir -p php80 \
&& tar -xf /root/php80.tar.gz -C php80 --strip-components=1 \
&& ( \
  cd php80 \
  && mkdir -p "/etc/php/conf.d" \
  && ./configure \
  --prefix=/usr/local/php80 \
  --with-config-file-path="/etc/php" \
  --with-config-file-scan-dir="/etc/php/conf.d" \
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
  --with-fpm-user=nobody \
  --with-fpm-group=nobody \
  --enable-bcmath \
  --enable-soap \
  --enable-zip \
  --enable-fpm \
  --enable-mbstring \
  --enable-sockets \
  --enable-opcache \
  --enable-pcntl \
  --enable-simplexml \
  --enable-xml \
  --disable-fileinfo \
  --disable-rpath \
  && make -s -j$(nproc) \
  && make install \
  && /bin/cp -rf php.ini-production /etc/php/php.ini
)

# 设置php-fpm.conf
cd "/usr/local/php80/etc" \
&& /bin/cp -rf  php-fpm.conf.default php-fpm.conf \
&& /bin/cp -rf  php-fpm.d/www.conf.default php-fpm.d/www.conf

# 把PHP加入环境变量
echo "PATH=\$PATH:/usr/local/php80/bin:/usr/local/php80/sbin" > /etc/profile.d/php.sh
echo "export PATH" >> /etc/profile.d/php.sh
source /etc/profile

cd /root \
&& curl -SL https://github.com/phpredis/phpredis/archive/5.3.2.tar.gz -o redis.tar.gz \
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
```