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
    
    root /var/www/soonio.github.io/;
    
    location / {
        alias /var/www/soonio.github.io/;
        index index.html;
    }

    location ^~ /octopus/ {
        alias /var/www/octopus/front/;
	index index.html;
	
    }

    location ^~ /api/ {
            rewrite ^/api(.*) $1 break;
            proxy_pass http://127.0.0.1:4321;
            proxy_read_timeout 180s;
            proxy_redirect off;
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header X-Forwarded-Proto $scheme;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
     }
}
```