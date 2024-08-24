## 安装

```bash
yum install -y nginx
sudo apt install -y nginx
```

## 设置开机重启

- 创建重启配置文件

  > 自己源码安装的需要这一步，yum安装的无需自定义nginx.service文件

  `vim /usr/lib/systemd/system/nginx.service`

  ```ini
  [Unit]
  Description=nginx
  After=network.target
    
  [Service]
  Type=forking
  ExecStart=/usr/sbin/nginx
  ExecReload=/usr/sbin/nginx -s reload
  ExecStop=//usr/sbin/nginx -s quit
  PrivateTmp=false
    
  [Install]
  WantedBy=multi-user.target
  ```


- 生效配置文件

  ```bash
  systemctl enable nginx.service
  ```


## 优化nginx

- 压缩静态资源
- Todo

## 配置虚拟主机

- 普通静态网站[非https]

  ```nginx
  server {
  	listen 80;
  	listen 81;
  	server_name iosoon.cn;
  	
  	access_log  /var/log/nginx/iosoon.cn.log;
  	
  	root  /data/web/ruoge3s.github.io;
    	
  	index index.html;
      
  	location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$ {
  		expires      30d;
  	}
  	location ~ .*\.(js|css)?$ {
  		expires      12h;
  	}
  	location ~ /\. {
  		deny all;
  	}
  }
  ```

- 普通静态资源网站[https]

  ```nginx
  server {
      listen 80;
      server_name  iosoon.cn;
      rewrite ^(.*)$ https://$host$1 permanent;
  }
  
  server {
      listen       443 ssl;
      server_name iosoon.cn;
  
      root /data/web/ruoge3s.github.io;
      index index.html index.htm;
  
      ssl_certificate  cert/iosoon.cn.pem;
      ssl_certificate_key  cert/iosoon.cn.key;
      ssl_session_timeout 10m;
      ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
      ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
      ssl_prefer_server_ciphers on;
  
      # ... 相关配置
  
      location ~ /\.(ht|svn|git) {
          deny all;
      }
  }
  ```

- 转发代理

  ```nginx
  server {
    listen       443 ssl;
    server_name iosoon.cn;
    
    # 设置证书
    ssl_certificate  cert/iosoon.cn.pem;
    ssl_certificate_key  cert/iosoon.cn.key;
    ssl_session_timeout 10m;
    ssl_ciphers ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;
  
  	# 设置默认静态资源的目录
  	root /data/web/demo;
  	
  	location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
  	{
  	  try_files $uri $uri/ /;
  	}
  	
  	# 重新路由domain/docs形式的静态资源请求
  	location ~/docs {
  	  try_files $uri $uri/ /;
  	}
  	
  	# 代理转发http请求
  	location / {
  	  proxy_set_header Host 							$http_host;
  	  proxy_set_header X-Real-IP 					$remote_addr;
  	  proxy_set_header X-Forwarded-For 		$proxy_add_x_forwarded_for;
      proxy_set_header X-Forwarded-Host   $host:$server_port;
      proxy_set_header Origin             $host:$server_port;
      proxy_set_header Referer            $host:$server_port;
  
      # 可以独立出来配置多个，实现负载均衡
      proxy_pass http://127.0.0.1:9501;
      
      # 设置跨域
      add_header Access-Control-Allow-Origin *;
      add_header Access-Control-Allow-Credentials true;
      add_header Access-Control-Allow-Methods 'GET, POST, OPTIONS';
      add_header Access-Control-Allow-Headers 'DNT,Keep-Alive,User-Agent,Cache-Control,Content-Type,Authorization';
      if ($request_method = 'OPTIONS') {
        return 204;
      }
    }
  
    # 代理转发websocket请求
    location ^~ /ws {
      proxy_pass http://127.0.0.1:9506;
      proxy_http_version 1.1;
      proxy_set_header Upgrade $http_upgrade;
      proxy_set_header Connection "upgrade";
      
    }
    
    location ~* \.(ini|sql|conf|bak)$ {
      return 404;
    }
    
    location ~ /\.(ht|svn|git) {
      deny all;
    }
  }
  ```


## 多服务共享单个域名

- 测试环境搭建

  - 修改本地hosts文件

    ```tex
    127.0.0.1 lo.p.com
    ```

  - 创建测试文件

    ```bash
    mkdir -p /Users/qingliu/temp/statis/s1
    mkdir -p /Users/qingliu/temp/statis/s2
    
    # 下面两个文件要想显示正常需要替换正常的文件
    touch /Users/qingliu/temp/statis/s1/a.jpg
    touch /Users/qingliu/temp/statis/s2/b.png
    ```

  - 创建服务文件

    ```php
    echo "<?php print_r(\$_SERVER);" > /Users/qingliu/temp/server.php
    php -S 127.0.0.1:8080 /Users/qingliu/temp/server.php
    php -S 127.0.0.1:8081 /Users/qingliu/temp/server.php
    ```

  - 创建nginx配置文件

    ```nginx
    server {
      listen      80;
      server_name lo.p.com;
    
      # 把所有项目的静态资源软连接到同一个目录中，使用不同的前缀分开
      location \.(jpg|png)$ {
        root /Users/qingliu/temp/statis;
        expires  30d;
      }
    
      # 把所有/s1/的请求转发到8080服务中
      location /s1/ {
        proxy_pass http://127.0.0.1:8080/;
      }
    
      # 把所有/s2/的请求转发到8081服务中
      location /s2/ {
          proxy_pass http://127.0.0.1:8081/;
        }
    }
    ```

- 重启nginx服务查看效果

  http://lo.p.com/s1/ 查看s1服务效果

  http://lo.p.com/s2/ 查看s2服务效果

  http://lo.p.com/s1/a.jpg 查看s1项目的资源

  http://lo.p.com/s2/b.png 查看s2项目的资源

## Nginx解析到docker中的php-fpm

```shell
server{
    listen  80 ;
    server_name     order.test.com;
    rewrite ^(.*)$ https://$host$1 permanent;
 }
server {
    listen       443 ssl;
    server_name  order.test.com;

    #charset koi8-r;
    access_log  /var/log/nginx/order.test.com.log main;
    error_log /var/log/nginx/order.test.com.error.log error;

    root    /Users/qingliu/workspace/cloud/order/Web;
    index   index.html index.htm index.php;

    ssl_certificate     order.test.com.pem;
    ssl_certificate_key order.test.com.key;
    ssl_session_timeout 5m;
    ssl_ciphers         ECDHE-RSA-AES128-GCM-SHA256:ECDHE:ECDH:AES:HIGH:!NULL:!aNULL:!MD5:!ADH:!RC4;
    ssl_protocols       TLSv1 TLSv1.1 TLSv1.2;
    ssl_prefer_server_ciphers on;

    location / {
        if (!-e $request_filename) {
            rewrite  ^/(.*)$  /index.php/$1  last;
            break;
        }
    }

    location ~ \.php {
        root /opt/order/Web;
        include fastcgi_params;
        fastcgi_split_path_info ^(.+\.php)(.*)$;
        fastcgi_param PATH_INFO $fastcgi_path_info;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_pass  127.0.0.1:9080;
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
