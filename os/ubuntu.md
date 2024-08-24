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

### 安装swoole-cli版本的PHP
```bash
wget https://github.com/jingjingxyk/swoole-cli/releases/download/build-native-php-v0.1.1/php-cli-v7.4.33-linux-x64.tar.xz -O php.tar.xz
tar -xvf php.tar.xz
sudo mv php /usr/local/bin


wget https://github.com/composer/composer/releases/download/2.6.5/composer.phar -O composer
sudo chmod +x composer
sudo mv composer /usr/local/bin
```

### 编译安装
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
sudo apt-get update
sudo apt-get install -y ca-certificates curl gnupg
sudo mkdir -p /etc/apt/keyrings
curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | sudo gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg

NODE_MAJOR=20
echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | sudo tee /etc/apt/sources.list.d/nodesource.list

sudo apt-get update
sudo apt-get install nodejs -y

# 启用npm和yarn
sudo corepack enable npm
sudo corepack enable yarn
```
> [参考文档](https://github.com/nodesource/distributions)


## 安装Golang
```bash
# 安装 Go 的最新稳定版本
curl -SL https://dl.google.com/go/go1.20.6.linux-amd64.tar.gz -o go.tar.gz && sudo tar -C /usr/local -xzf go.tar.gz
echo "export PATH=\$PATH:/usr/local/go/bin" >> .profile
source .profile
go version
```
> `--classic` 是指让snap使用传统方式安装go，go可以访问系统资源  
> [golang安装](https://go.dev/doc/install)

## 直接安装 redis
```bash
sudo apt install lsb-release curl gpg
curl -fsSL https://packages.redis.io/gpg | sudo gpg --dearmor -o /usr/share/keyrings/redis-archive-keyring.gpg

echo "deb [signed-by=/usr/share/keyrings/redis-archive-keyring.gpg] https://packages.redis.io/deb $(lsb_release -cs) main" | sudo tee /etc/apt/sources.list.d/redis.list

sudo apt-get update
sudo apt-get install redis

# 服务管理(service || systemctl)
sudo service redis-server start
sudo systemctl status redis-server

# 开机自启动
sudo update-rc.d redis-server defaults

```

> [文档](https://redis.io/docs/getting-started/installation/install-redis-on-linux/)

## 设置默认编辑器

```bash
sudo update-alternatives --config editor
```

## 直接使用remote development

- JetBrains Gateway
- JetBrains Fleet
- VScode remote development
