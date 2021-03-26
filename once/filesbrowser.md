## 一键构建内网文件浏览共享

### 安装
```shell
curl -fsSL https://raw.githubusercontent.com/filebrowser/get/master/get.sh | bash
```

### 启动
```shell
mkdir -p /data/share/files

filebrowser --port 9800 --database /data/share/filebrowser.db  -r /data/share/files --log /data/share/f.log &
```
### 配置nginx

```nginx
server {
    listen 80;
    server_name  share.domain.com;
    client_max_body_size 50m;

    gzip  on;
    gzip_min_length  1k;
    gzip_buffers     4 16k;
    gzip_http_version 1.1;
    gzip_comp_level 7;
    gzip_types  text/plain text/css text/javascript application/javascript application/json;
    gzip_vary on;

    location / {
        proxy_pass http://127.0.0.1:9800;
        proxy_read_timeout 180s;
        proxy_redirect off;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    }
}
```
