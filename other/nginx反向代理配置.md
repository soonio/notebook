```log
server {
    charset utf-8;
    client_max_body_size 128M;
    sendfile off;

    listen      80;
    listen      443 ssl;
    server_name www.test.com;
    root        /root-dir;
    index       index.html;

    access_log  logs/test.access.log;
    error_log   logs/test.error.log;

    ssl_certificate  cert/xxx.pem;
    ssl_certificate_key  cert/xxx.key;
    ssl_session_timeout 5m;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;

    location / {
        proxy_http_version 1.1;
        proxy_set_header Connection "keep-alive";
        proxy_set_header X-Real-IP $remote_addr;
        if (!-e $request_filename) {
            proxy_pass http://127.0.0.1:9501;
        }
    }

    location ^~ /2.0/ {
        proxy_pass http://127.0.0.1:9502/;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
    }

    location ^~ /2.6/ {
        proxy_pass http://127.0.0.1:9503/;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
    }

    location ~ /\.(ht|svn|git) {
        deny all;
    }
}

```

暂且记录这些，回头再详解
