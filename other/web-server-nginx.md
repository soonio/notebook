# 当前服务的 Nginx 配置

## 证书更新

```bash
sudo certbot --nginx -n \
    --agree-tos \
    --email soonio@qq.com \
    -d notebook.iosoon.cn \
    --nginx-server-root /etc/nginx/
    --nginx-config-dir /etc/nginx/sites-available
```

## iosoon.cn

```nginx configuration
server {
    listen 80 ;
    listen [::]:80 ;
    server_name www.iosoon.cn;

    return 301 https://$host$request_uri; # managed by Certbot
}

server {
    server_name www.iosoon.cn;

    listen [::]:443 ssl ipv6only=on; # managed by Certbot
    listen 443 ssl; # managed by Certbot

    ssl_certificate /etc/letsencrypt/live/www.iosoon.cn/fullchain.pem; # managed by Certbot
    ssl_certificate_key /etc/letsencrypt/live/www.iosoon.cn/privkey.pem; # managed by Certbot
    include /etc/letsencrypt/options-ssl-nginx.conf; # managed by Certbot
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem; # managed by Certbot
    location / {
        root /var/www/soonio.github.io/;
        index index.html;
    }
}

```

## notebook.iosoon.cn

```nginx configuration
server {
    listen 80 ;
    listen [::]:80 ;
    server_name notebook.iosoon.cn;

    return 301 https://$host$request_uri; # managed by Certbot
}
server {
    server_name notebook.iosoon.cn;

    listen [::]:443 ssl ipv6only=on; # managed by Certbot
    listen 443 ssl; # managed by Certbot

    ssl_certificate /etc/letsencrypt/live/notebook.iosoon.cn/fullchain.pem; # managed by Certbot
    ssl_certificate_key /etc/letsencrypt/live/notebook.iosoon.cn/privkey.pem; # managed by Certbot
    include /etc/letsencrypt/options-ssl-nginx.conf; # managed by Certbot
    ssl_dhparam /etc/letsencrypt/ssl-dhparams.pem; # managed by Certbot
    location / {
        root /var/www/notebook/;
        index index.html;
    }
}
```