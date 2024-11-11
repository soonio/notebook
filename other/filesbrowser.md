
### 需求说明

  在公司内部，建立简单的文件共享平台，便于管理一些内部资料文件等需要归档的东西

### 安装
```shell
curl -fsSL https://raw.githubusercontent.com/filebrowser/get/master/get.sh | bash
```

### 启动
```shell
mkdir -p /var/www/share/workdir
cd /var/www/share/workdir
filebrowser config init
filebrowser config set -a 0.0.0.0 -r /var/www/share/workdir/ -p 9800 -l /var/www/share/f.log  --branding.name=文件共享服务
filebrowser config set  --branding.name=文件管理平台
filebrowser users add root fb123
filebrowser config cat
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

### 配置进程守护
  - systemd 
  - /lib/systemd/system/filebrowse.service
```
[Unit]
Description=filebrowse service

[Service]
User=root
Type=simple
Restart=always
RestartSec=5s
ExecStart=/usr/local/bin/filebrowser
ExecReload=/bin/kill -s HUP
WorkingDirectory=/var/www/share
KillMode=process
Delegate=yes

[Install]
WantedBy=multi-user.target
```
  - sudo systemctl daemon-reload
  - sudo systemctl start filebrowse


### 更多

  [filebrowser](https://github.com/filebrowser/filebrowser)
