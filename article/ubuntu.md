> 本机mac电脑年纪太大了，比较卡顿，正好有闲置的电脑主机作为服务器，把开发环境都搬上去。以下为操作流程：

## 制作U盘镜像
```bash
# 转换iso为dmg
hdiutil convert -format UDRW -o ubuntu-22.04.2-live-server-amd64.dmg ubuntu-22.04.2-live-server-amd64.iso

# 查看U盘是那个，找到U盘名称
diskutil list

# 卸载U盘
diskutil unmountDisk /dev/diskN

# 把dmg安装到u盘上(复制,时间比较久)
sudo dd if=./ubuntu-22.04.2-live-server-amd64.dmg of=/dev/disk2 bs=1m
```

## 安装 NGINX
```bash
sudo apt update
sudo apt install nginx

# 服务管理
service nginx status

# 服务管理
service nginx status
```

## 安装 MYSQL
```bash
wget https://repo.mysql.com/mysql-apt-config_0.8.25-1_all.deb
sudo dpkg -i mysql-apt-config_0.8.25-1_all.deb
sudo apt-get update
sudo apt-get install mysql-server
systemctl status mysql

# 服务管理
service mysql status

# 服务管理
service mysql status
```

> [下载地址](https://dev.mysql.com/downloads/repo/apt/)
> [安装说明](https://dev.mysql.com/doc/mysql-apt-repo-quick-guide/en/)

## 安装 PHP
```bash
sudo apt-cache policy php

sudo add-apt-repository ppa:ondrej/php --yes &> /dev/null

sudo apt update

sudo apt install php7.4

sudo apt install php7.4-simplexml php7.4-curl php7.4-dom php7.4-zip php7.4-swoole  php7.4-redis -y

wget https://github.com/composer/composer/releases/download/2.2.21/composer.phar
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer 
```

## 安装 Node

```bash
# 安装默认版本(v12)
sudo apt install nodejs build-essential -y

# 需要先完全卸载之前版本的nodejs，以及安装curl
sudo apt purge nodejs
sudo apt autoremove 
sudo apt update
sudo apt install -y curl
# 安装指定版本
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs build-essential -y

# 启用npm和yarn
sudo corepack enable npm
sudo corepack enable yarn
```

## 安装golang
```bash
# 安装 Go 的最新稳定版本
curl -SL https://dl.google.com/go/go1.20.6.linux-amd64.tar.gz -o go.tar.gz && sudo tar -C /usr/local -xzf go.tar.gz
echo "export PATH=\$PATH:/usr/local/go/bin" >> .profile
source .profile
go version
```
> `--classic` 是指让snap使用传统方式安装go，go可以访问系统资源  
> [golang安装](https://go.dev/doc/install)

## redis 安装参考文档

    [文档](https://redis.io/docs/getting-started/installation/install-redis-on-linux/)

## 基于 Snap 安装 redis
```bash
sudo snap install redis

# 服务管理
snap services redis
```
> 默认是`--strict`进行隔离

## 直接安装 redis
```bash
sudo apt install lsb-release curl gpg
curl -fsSL https://packages.redis.io/gpg | sudo gpg --dearmor -o /usr/share/keyrings/redis-archive-keyring.gpg

echo "deb [signed-by=/usr/share/keyrings/redis-archive-keyring.gpg] https://packages.redis.io/deb $(lsb_release -cs) main" | sudo tee /etc/apt/sources.list.d/redis.list

sudo apt-get update
sudo apt-get install redis
```

## 设置默认编辑器

```bash
sudo update-alternatives --config editor
```

## 直接使用remote development

- JetBrains Gateway
- JetBrains Fleet
- VScode remote development
