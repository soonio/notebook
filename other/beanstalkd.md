

### beanstalkd

```bash

```

### 进程守护

```uint
[Unit]
Description=beanstalkd queue 1
After=network.target

[Service]
User=beanstalkd
Group=beanstalkd
ExecStart=/usr/bin/beanstalkd -l 0.0.0.0 -p 7771 -b /var/lib/beanstalkd/1

[Install]
WantedBy=multi-user.target
```

### beanstool

```bash
wget https://github.com/src-d/beanstool/releases/download/v0.2.0/beanstool_v0.2.0_linux_amd64.tar.gz
tar -xvf beanstool_v0.2.0_linux_amd64.tar.gz 
mv beanstool_v0.2.0_linux_amd64/beanstool /usr/local/bin/beanstool
rm -rf beanstool_v0.2.0_linux_amd64
rm -rf beanstool_v0.2.0_linux_amd64.tar.gz
beanstool  stats --host 139.196.109.38:7772

```

> 其中 waiting 为客户端连接的数量
