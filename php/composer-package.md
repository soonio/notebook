## 环境说明

为了避免安装PHP及composer环境，本文档使用docker容器进行搭建

[satis私有composer开源项目](https://github.com/composer/satis)

## 环境构建

  ```bash
  docker pull composer/satis \
  && mkdir -p /data/www/satis && cd /data/www/satis \
  && wget https://getcomposer.org/download/1.10.6/composer.phar \
  && mv composer.phar composer \
  && chmod u+x composer \
  && touch satis.json \
  && touch auth.json 
  ```
  ```json
  # satis.json
  {
    "name": "io/soon",
    "homepage": "http://pks.iosoon.cn",
    "repositories": [
      { "type": "vcs", "url": "https://username:password@gitee.com/soonio/pks" }
    ],
    "require": {
      "soonio/pks": "*"
    }
  }
  ```
  ```json
  # auth.json
  { "github-oauth": { "github.com": "a secret key" } }
  ```

## 生成网站

  - 运行容器

    ```bash
    # 其中composer是缓存目录，也可以不映射，不保留缓存
    docker run --rm --init -it \
      --user $(id -u):$(id -g) \
      -v /data/www/satis:/build/ \
      -v /data/www/satis/composer:/composer \
      composer/satis build /build/satis.json /build/dist
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
      listen 81;
      server_name pks.iosoon.cn;
  
      access_log  /var/log/nginx/pks.iosoon.cn.log;
      root  /data/www/satis/dist;
      index index.html;
    
      auth_basic  "please entey yours username and password."; 
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
  `yum install httpd-tools -y && htpasswd -c -d /etc/nginx/conf.d/httppwd username`  
  需要手动生成输入密码,username和密码在直接访问pks.iosoon.cn或者composer require私有库的时候使用  


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
```

  - composer.json中增加

    ```json
    "repositories": [{
      "type": "composer",
      "url": "http://pks.iosoon.cn"
    }]
```

    !> 注意，上文使用的是基于http的私有库，需要添加composer配置
    
    ```json
    "config": {
        "secure-http": false
    }
    ```

  - composer 安装

    ```bash
    composer require soonio/pks
    ```

    

