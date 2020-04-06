```
server {
    listen 80;
    server_name g.fy.com;
    access_log  /var/log/nginx/g.fy.com;
    root  /home/qingliu/work/my/web;

    index index.html index.php;
    location / {
        if (!-e $request_filename) {
            rewrite ^/(.*)$ /index.php/$1 last;
        }
    }
    location ~ \.php {
        #fastcgi_pass   127.0.0.1:9000;
        fastcgi_pass    unix://run/php/php5.6-fpm.sock;
        fastcgi_index   index.php;
        fastcgi_split_path_info ^((?U).+\.php)(/?.+)$;
        fastcgi_param   SCRIPT_FILENAME  $document_root$fastcgi_script_name;
        fastcgi_param   PATH_INFO  $fastcgi_path_info;
        fastcgi_param   PATH_TRANSLATED  $document_root$fastcgi_path_info;
        include         fastcgi_params;
    }
    location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$ {
        expires      30d;
    }
    # js/css 缓存12小时
    location ~ .*\.(js|css)?$ {
        expires      12h;
    }
    location ~ /\. {
        deny all;
    }
}
```
