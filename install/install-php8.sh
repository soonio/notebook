echo -e "\033[32m🚀 start install.\033[0m"

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

echo -e "\033[32m🚀 install oniguruma .\033[0m"

curl -SL "https://github.com/kkos/oniguruma/archive/v6.9.4.tar.gz"  -o oniguruma694.tar.gz \
&& mkdir -p oniguruma694 \
&& tar -xf /root/oniguruma694.tar.gz -C oniguruma694 --strip-components=1 \
&& ( \
  cd oniguruma694 \
  && ./autogen.sh \
  && ./configure --prefix=/usr \
  && make \
  && make install \
)

echo -e "\033[32m🚀 install php8 .\033[0m"

cd /root \
&& curl -SL "http://mirrors.sohu.com/php/php-8.0.8.tar.gz"  -o php8.tar.gz \
&& mkdir -p php8 \
&& tar -xf /root/php8.tar.gz -C php8 --strip-components=1 \
&& ( \
  cd php8 \
  && mkdir -p "/etc/php/conf.d" \
  && ./configure \
  --prefix=/usr/local/php8 \
  --with-config-file-path="/etc/php" \
  --with-config-file-scan-dir="/etc/php/conf.d" \
  --with-pdo-mysql \
  --with-zlib \
  --with-openssl \
  --with-mhash \
  --with-curl \
  --with-fpm-user=nginx \
  --with-fpm-group=nginx \
  --enable-bcmath \
  --enable-soap \
  --enable-fpm \
  --enable-mbstring \
  --enable-sockets \
  --enable-opcache \
  --enable-pcntl \
  --enable-simplexml \
  --enable-xml \
  --disable-rpath \
  && make \
  && make install \
  && /bin/cp -rf php.ini-production /etc/php/php.ini
)

# 设置php-fpm.conf
cd "/usr/local/php8/etc" \
&& /bin/mv php-fpm.conf.default php-fpm.conf \
&& /bin/mv php-fpm.d/www.conf.default php-fpm.d/www.conf

# 把PHP加入环境变量
echo "PATH=\$PATH:/usr/local/php8/bin:/usr/local/php8/sbin" > /etc/profile.d/php.sh
echo "export PATH" >> /etc/profile.d/php.sh
source /etc/profile

echo -e "\033[32m🚀 install php-ext-redis .\033[0m"

cd /root \
&& curl -SL https://github.com/phpredis/phpredis/archive/5.3.2.tar.gz -o redis.tar.gz \
&& mkdir -p redis \
&& tar -xf redis.tar.gz -C redis --strip-components=1 \
&& ( \
  cd redis \
  && phpize \
  && ./configure \
  && make \
  && make install \
) \
&& echo "extension=redis.so" > /etc/php/conf.d/50_redis.ini \
&& php --ri redis

echo -e "\033[32m😁 mission completed.\033[0m"