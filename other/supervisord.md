# supervirsord基本应用

## 下载安装

参考众多网络教程

## 软件配置

### 创建配置目录

```bash
mkdir -p /etc/supervisor/conf.d/
```

### 生成默认配置到配置目录

```bash
echo_supervisord_conf > /etc/supervisor/supervisord.conf
```

### 修改默认生成的配置

```bash
vim /etc/supervisor/supervisord.conf
```

```ini
;修改前
;[include]
;files = relative/directory/*.ini
;修改后
[include]
files = conf.d/*.ini
```

### 创建应用配置

```bash
vim /etc/supervisor/conf.d/app.ini
```

```ini
[program:appname]
process_name=%(program_name)s_%(process_num)02d
command=/usr/local/php/bin/php /data/web/member/artisan queue:work --queue=default --sleep=3 --tries=3
autostart=true
autorestart=true
user=root
numprocs=5
redirect_stderr=true
stderr_logfile=/var/log/supervisor/err.log
stdout_logfile=/var/log/supervisor/out.log
```

## 服务启动

```bash
supervisord -c /etc/supervisor/supervisord.conf
```

## 重载全部用用

```bash
cd /etc/supervisor/ && /usr/local/bin/supervisorctl reload
```

## 重启gname的所有的进程
```bash
/usr/local/bin/supervisorctl restart gname:*
```

## 查看帮助

```bash
cd /etc/supervisor/ && /usr/local/bin/supervisorctl status
```

