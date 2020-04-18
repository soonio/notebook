## 安装


```bash
sudo yum install -y yum-utils   device-mapper-persistent-data   lvm2
sudo yum-config-manager     --add-repo     https://download.docker.com/linux/centos/docker-ce.repo
sudo yum-config-manager --enable docker-ce-nightly
sudo yum install docker-ce docker-ce-cli containerd.io -y
sudo systemctl start docker
```

注意事项,在centos8上，需要手动安装符合条件的containerd.io

```bash
sudo dnf install https://download.docker.com/linux/centos/7/x86_64/stable/Packages/containerd.io-1.2.6-3.3.el7.x86_64.rpm
```



## 安装docker-compose

```
sudo curl -L "https://github.com/docker/compose/releases/download/1.24.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose

sudo chmod +x /usr/local/bin/docker-compose
```

## 设置docker开机启动
```
systemctl enable docker
```

## 修改镜像源
/etc/sysconfig/docker
```config
OPTIONS='--selinux-enabled --log-driver=journald --registry-mirror=http://hub-mirror.c.163.com'
```
> 上面使用了网易云的镜像 http://hub-mirror.c.163.com  其他的自行百度

