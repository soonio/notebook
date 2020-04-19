## 安装[centos8]

```bash
yum install -y supervisor
# 设置开机自启
systemctl enable supervisord.service 
```



## 配置

- 默认配置

  ```bash
  vim /etc/supervisord.conf
  ```

- 扩展配置

  ```bash
  ls /etc/supervisord.d/
  ```

  > 扩展配置的文件以.ini结尾，具体参考/etc/supervisord.conf中的扩展配置

## 实践

- 创建测试脚本

  `cd /data/web/demo && touch cli.sh && chmod +x cli.sh && vim cli.sh`

  ```shell
  #!/bin/bash
  while true
  do
      echo `date "+%Y-%m-%d %H:%M:%S"`
      sleep 3
  done
  ```

- 创建任务配置

  ```bash
  vim /etc/supervisord.d/app.ini
  ```

  ```ini
  # 新建一个应用并设置一个名称，这里设置为 demo
  [program:demo]
  # 设置命令在指定的目录内执行
  directory=/data/web/demo
  # 这里为您要管理的项目的启动命令
  command=./cli.sh 
  # 以哪个用户来运行该进程
  user=root
  # supervisor 启动时自动该应用
  autostart=true
  # 进程退出后自动重启进程
  autorestart=true
  # 进程持续运行多久才认为是启动成功
  startsecs=1
  # 重试次数
  startretries=3
  # stderr 日志输出位置
  stderr_logfile=/var/log/supervisor/demo-stderr.log
  # stdout 日志输出位置
  stdout_logfile=/var/log/supervisor/demo-stdout.log
  ```

- 相关命令

  ```bash
  # 启动(如果使用自定义的配置，可以使用-c xxx.conf使用指定配置)
  supervisord
  
  # 重启supervisord服务(在修改配置后，需要重启)
  # 保险起见，还是停止所有服务后，在重启
  supervisorctl stop all
  supervisorctl shutdown && supervisord
  
  # 查看状态
  supervisorctl status
  
  # 重启demo服务(在修改项目代码是重启)
  supervisorctl start demo
  supervisorctl stop demo
  supervisorctl restart demo
  
  # 可以看到在持续输出日期时间
  tail -f /var/log/supervisor/demo-stdout.log 
  ```

Update At : {docsify-updated}