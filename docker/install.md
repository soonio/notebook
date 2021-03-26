## 安装docker

[官方文档](https://docs.docker.com/engine/install/centos/)


  ```bash
  yum install -y yum-utils
  yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
  yum-config-manager --disable docker-ce-nightly
  yum install -y docker-ce docker-ce-cli containerd.io
  systemctl start docker
  systemctl enable docker
  ```


## 安装docker-compose

  ```shell
curl -L \
    "https://github.com/docker/compose/releases/download/1.24.0/docker-compose-$(uname -s)-$(uname -m)" \
    -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
  ```

## 修改镜像源
/etc/sysconfig/docker
```config
OPTIONS='--selinux-enabled --log-driver=journald --registry-mirror=http://hub-mirror.c.163.com'
```
> 上面使用了网易云的镜像 http://hub-mirror.c.163.com  其他的自行百度

## 日志配置

  - 创建日志文件
  ```shell
  touch /etc/docker/daemon.json
  ```
  > [配置参考地址](https://docs.docker.com/config/containers/logging/json-file/)

  - 设置配置
  ```json
    {
      "log-driver": "json-file",
      "log-opts": {
        "max-size": "10m",
        "max-file": "7"
      }
    }
  ```
  - 查询日志
  ```bash
  #!/bin/sh
  
  logs=$(find /var/lib/docker/containers/ -name *-json.log)  
  
  for log in $logs
    do
      ls -lh $log
    done
  ```
  - 日志删除
  ```bash
  #!/bin/sh
  logs=$(find /var/lib/docker/containers/ -name *-json.log)
  for log in $logs
	do
		echo "clean logs : $log"
		cat /dev/null > $log
	done
  ```

## laydocker

  [GIT地址](https://github.com/jesseduffield/lazydocker)



