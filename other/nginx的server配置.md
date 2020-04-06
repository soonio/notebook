```conf
server {
    listen          80;
    server_name     demo.com;

    rewrite ^(.*)$ https://$host$1 permanent;
}
server {
    charset utf-8;
    client_max_body_size 128M;
    sendfile off;

    listen 443 ssl;
    server_name demo.com;

    access_log  logs/demo.com.access.log;
    error_log   logs/demo.com.error.log;

    ssl_certificate  cert/demo.com/c.pem;
    ssl_certificate_key  cert/demo.com/c.key;
    ssl_session_timeout 5m;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;

    location / {
        # 前端代码
        root /data/pai;
        try_files $uri $uri/ /index.html;
        # add_header access-control-allow-origin *;
    }

    location ^~ /2.6/ {
        add_header access-control-allow-origin *; // 会产生跨域问题
        proxy_pass http://127.0.0.1:9503/;

        proxy_set_header X-Forwarded-Host   $host:$server_port;
        proxy_set_header X-Real-IP          $remote_addr;
        proxy_set_header Origin             $host:$server_port;
        proxy_set_header Referer            $host:$server_port;

    }    
    
    location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
    {
        expires 30d;
    }

    location ~* \.(eot|otf|ttf|woff)$ {
        add_header Access-Control-Allow-Origin *;
    }


    location ~* \.(ini|sql|conf|bak)$ {
        return 404;
    }

    location ~* ^/(themes|images|logs|data|demo|wap_themes)/.*\.(php|php5)$ {
        deny all;
    }

    location ~ /\.(svn|git|)/ {
        deny all;
    }

    location ~ .*\.(js|css)?$
    {
        expires 1h;
    }
}
```
