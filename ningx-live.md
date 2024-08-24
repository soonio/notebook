sudo apt install gcc libpcre3 libpcre3-dev zlib1g zlib1g-dev openssl libssl-dev make



wget https://nginx.org/download/nginx-1.25.3.tar.gz && tar -xvf nginx-1.25.3.tar.gz 


wget https://github.com/arut/nginx-rtmp-module/archive/refs/tags/v1.2.2.tar.gz


```bash
sudo groupadd -r www \
&& sudo useradd -r -g www -s /bin/false -M www

mkdir /var/tmp/nginx

sudo ./configure \
    --prefix=/usr/local/nginx \
    --conf-path=/usr/local/nginx/conf/nginx.conf \
    --pid-path=/usr/local/nginx/conf/nginx.pid \
    --lock-path=/var/lock/nginx.lock \
    --error-log-path=/var/log/nginx/error.log \
    --http-log-path=/var/log/nginx/access.log \
    --with-http_gzip_static_module \
    --http-client-body-temp-path=/var/tmp/nginx/client \
    --http-proxy-temp-path=/var/tmp/nginx/proxy \
    --http-fastcgi-temp-path=/var/tmp/nginx/fastcgi \
    --http-uwsgi-temp-path=/var/tmp/nginx/uwsgi \
    --http-scgi-temp-path=/var/tmp/nginx/scgi \
    --with-http_stub_status_module \
    --with-http_ssl_module \
    --add-module=/home/ubuntu/nginx-http-flv-module-1.2.11 \
    --user=ubuntu \
    --group=ubuntu

```

sudo make && sudo make install


rtmp://192.168.20.51:8999/live1
rtmp://192.168.20.51:8999/live1


rtmp://192.168.20.51/live/xxx


# 推流地址
rtmp://192.168.20.51/live/s1

# 拉流地址
http://192.168.20.51/live?&app=live&stream=s1

# 推流地址
rtmp://192.168.20.51/live/s2

# 拉流地址
http://192.168.20.51/live?&app=live&stream=s2