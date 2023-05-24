> 本机mac电脑年纪太大了，比较卡顿，正好有闲置的电脑主机作为服务器，把开发环境都搬上去。以下为操作流程：

## 制作U盘景象
```bash
# 转换iso为dmg
hdiutil convert -format UDRW -o ubuntu-22.04.2-live-server-amd64.dmg ubuntu-22.04.2-live-server-amd64.iso

# 查看U盘是那个，找到U盘名称
diskutil list

# 卸载U盘
diskutil unmountDisk /dev/diskN

# 把dmg安装到u盘上(复制)
sudo dd if=./ubuntu-22.04.2-live-server-amd64.dmg of=/dev/disk2 bs=1m
```

## 安装PHP
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

## 安装Node

```bash
# 安装默认版本(v12)
sudo apt install nodejs build-essential -y

# 安装指定版本
sudo apt purge nodejs
sudo apt autoremove 
sudo apt update
sudo apt install -y curl
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt install nodejs build-essential -y

# 启用npm和yarn
sudo corepack enable npm
sudo corepack enable yarn
```

## 安装golang
```bash
# 安装 Snap 包管理器
sudo apt update
sudo apt install snapd

# 安装 Go 的最新稳定版本
sudo snap install go --classic
```

## 设置默认编辑器

```bash
sudo update-alternatives --config editor
```

## 直接使用remote development

- JetBrains Gateway
- JetBrains Fleet
- VScode remote development
