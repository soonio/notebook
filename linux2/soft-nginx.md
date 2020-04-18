## 安装

```bash
yum install -y nginx
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

  