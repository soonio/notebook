### Nginx 及 rtmp 模块下载准备
```bash
sudo apt install gcc libpcre3 libpcre3-dev zlib1g zlib1g-dev openssl libssl-dev make

wget https://nginx.org/download/nginx-1.25.3.tar.gz && tar -xvf nginx-1.25.3.tar.gz
wget https://github.com/arut/nginx-rtmp-module/archive/refs/tags/v1.2.2.tar.gz
```

###  安装及配置
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

sudo make && sudo make install
```

### 推流地址

  - rtmp://192.168.20.51/live/s1
  - rtmp://192.168.20.51/live/s2

### 拉流地址
    
  - http://192.168.20.51/live?&app=live&stream=s1
  - http://192.168.20.51/live?&app=live&stream=s2

### Nginx 配置

```nginx configuration
worker_processes  1; #运行在 Windows 上时，设置为 1，因为 Windows 不支持 Unix domain socket
error_log /var/log/nginx/error.log error;

events {
    worker_connections  4096;
}

http {
    include       mime.types;
    default_type  application/octet-stream;

    keepalive_timeout  65;

    server {
        listen       80;

        location / {
            index  index.html index.htm;
        }

        error_page   500 502 503 504  /50x.html;
        location = /50x.html {
            root   html;
        }

        location /live {
            flv_live on; #打开 HTTP 播放 FLV 直播流功能
            chunked_transfer_encoding on; #支持 'Transfer-Encoding: chunked' 方式回复

            add_header 'Access-Control-Allow-Origin' '*'; #添加额外的 HTTP 头
            add_header 'Access-Control-Allow-Credentials' 'true'; #添加额外的 HTTP 头
        }

        location /hls {
            types {
                application/vnd.apple.mpegurl m3u8;
                video/mp2t ts;
            }

            root /tmp;
            add_header 'Cache-Control' 'no-cache';
        }

        location /dash {
            root /tmp;
            add_header 'Cache-Control' 'no-cache';
        }

        location /stat {
            #推流播放和录制统计数据的配置

            rtmp_stat all;
            rtmp_stat_stylesheet stat.xsl;
        }

        location /stat.xsl {
            root html; #指定 stat.xsl 的位置
        }

        #如果需要 JSON 风格的 stat, 不用指定 stat.xsl
        #但是需要指定一个新的配置项 rtmp_stat_format

        #location /stat {
        #    rtmp_stat all;
        #    rtmp_stat_format json;
        #}

        location /control {
            rtmp_control all; #rtmp 控制模块的配置
        }
    }
}

rtmp_auto_push on;
rtmp_auto_push_reconnect 1s;
rtmp_socket_dir /tmp;

rtmp {
    out_queue           4096;
    out_cork            8;
    max_streams         128;
    timeout             15s;
    drop_idle_publisher 15s;

    #log_interval 5s; #log 模块在 access.log 中记录日志的间隔时间，对调试非常有用
    log_size     1m; #log 模块用来记录日志的缓冲区大小

    server {
        listen 1935;

        application live {
            live on;
            gop_cache on; #打开 GOP 缓存，减少首屏等待时间
        }

        application hls {
            live on;
            hls on;
            hls_path /tmp/hls;
        }

        application dash {
            live on;
            dash on;
            dash_path /tmp/dash;
        }
    }

}
```