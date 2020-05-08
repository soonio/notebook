## 概述



## 环境说明

为了避免安装PHP及composer环境，本文档使用docker容器进行搭建

[satis私有composer开源项目](https://github.com/composer/satis)

## 环境构建

- 以下操作都在宿主机的`/home/pks`下进行

  ```bash
  mkdir /home/pks
  ```

- 拉取镜像

  ```bash
  docker pull composer/satis
  ```

- 下载composer命令

  ```bash
  wget -P /home/pks https://getcomposer.org/download/1.10.6/composer.phar \
  && mv composer.phar composer \
  && chmod u+x composer
  ```

  > 也可以从gitlab下载安装,手动放到指定位置

- 创建配置文件`touch /home/satis.json`

  ```json
  {
    "name": "io/soon",
    "homepage": "http://pks.iosoon.cn",
    "repositories": [
      { "type": "vcs", "url": "https://github.com/ruoge3s/silk-interface" }
    ],
    "require": {
      "ruoge3s/silk-interface": "*"
    }
  }
  ```

  - name 私有仓库的名称而已
  - homepage 私有composer仓库的地址
  - repositories 私有仓库的版本管理工具
  - require 私有仓库对应的包名

- 创建对应的授权文件`mkdit /home/pks/composer && touch /home/pks/composer/auth.json`

  ```json
  {
      "github-oauth": {
          "github.com": "ed34668322f4f2c42f5a353ecedb8c4d49882262"
      }
  }
  ```

  > 上面的gi thub.com的值，是从github中获取的token
  >
  > 也可以省略该步骤，在运行容器的时候手动天蝎Token

  

## 生成网站

  - 运行容器

  ```bash
  docker run --rm --init -it \
    --user $(id -u):$(id -g) \
    -v /home/pks:/build/ \
    -v /home/pks/composer:/composer \
    composer/satis build /build/satis.json /build/pks.iosoon.cn
  ```

  > 如果运行失败就多尝试几次，有时候github会抽风，拒绝链接

- 然后在宿主机器中查看输出的文件

  ```bash
  [root@demo pks]# ll
  total 12
  drwxr-xr-x 3 root root 4096 May  8 19:26 composer
  drwxr-xr-x 4 root root 4096 May  8 19:34 pks.iosoon.cn
  -rw-r--r-- 1 root root  215 May  8 19:05 satis.json
  ```

  > 其中pks.iosoon.cn就是我们的静态文件

- 创建nginx虚拟主机配置

  ```nginx
  server {
      listen 80;
      server_name pks.iosoon.cn;
  
      access_log  /var/log/nginx/pks.iosoon.cn.log;
      root  /home/pks/pks.iosoon.cn;
      index index.html;
    
      auth_basic  "please entey yours username and password"; 
      auth_basic_user_file /etc/nginx/conf.d/httppwd;
   
      location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$ {
          expires      30d;
      }
      location ~ .*\.(js|css)?$ {
          expires      12h;
      }
      location ~ /\. {
          deny all;
      }
  }
  ```

  > 文中`/etc/nginx/conf.d/httppwd` 可以使用命令生成
  >
  > `yum install httpd-tools -y && htpasswd -c -d `/etc/nginx/conf.d/httppwd` username`
  >
  > 需要手动生成输入密码,username和密码在直接访问pks.iosoon.cn或者composer require私有库的时候使用

  
## Composer 引入私有库

  - 在与composer.json同级目录下新增auth.json

    ```json
    {
        "http-basic": {
            "pks.iosoon.cn": {
                "username": "username",
                "password": "12345678"
            }
        }
    }
    ```

  - composer.json中增加

    ```json
    "repositories": [{
      "type": "composer",
      "url": "http://pks.iosoon.cn"
    }]
    ```

  - composer 安装

    ```bash
    composer reuiqre ruoge3s/silk-interface
    ```

    

