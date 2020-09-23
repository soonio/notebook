## runner安装

- 使用docker安装

  ```bash
  # 使用docker景象安装
  git pull gitlab/gitlab-runner-helper
  # 启动
  docker run -d \
  	--name=gr1 \
  	--restart=always \
  	-v /data/gitlab-runner/gr1/config:/etc/gitlab-runner \
    -v /var/run/docker.sock:/var/run/docker.sock \
    gitlab/gitlab-runner
  # 注册，会要求输入gitlab的地址，和token，以及选定执行器
  docker exec -it gr1 gitlab-ci-multi-runner register
  ```

- 使用宿主机安装

  ```bash
  yum install -y gitlab-runner
  # 下面注册的时候使用宿主机的用户，避免权限不够用
  gitlab-runner install --working-directory /home/gitlab-runner --user root
  ```

- 容器执行器-使用本地镜像
  ```bash
  vim /data/gitlab-runner/gr1/config/config.toml
  docker restart gr1
  ```

  > 重点在最后一句`pull_policy="if-not-present"`,可以使用本地镜像；修改concurrent的数量，可以提高并发数量

  ```toml
    concurrent = 3
    check_interval = 0

    [session_server]
      session_timeout = 1800

    [[runners]]
      name = "vue buidler"
      url = "http://gitlab.guyinmedia.net/"
      token = "ByotyRyepsR-X2sDsUsx"
      executor = "docker"
      [runners.custom_build_dir]
      [runners.cache]
        [runners.cache.s3]
        [runners.cache.gcs]
      [runners.docker]
        tls_verify = false
        image = "node:13-alpine"
        privileged = false
        disable_entrypoint_overwrite = false
        oom_kill_disable = false
        disable_cache = false
        volumes = ["/cache"]
        shm_size = 0
        pull_policy="if-not-present"
  ```

- 在gitlab中检查runner是否已经正常链接

- 在gitlab中给runner关联项目

## runner应用

- 自定义docker

  ```dockerfile
  FROM node:13-alpine
  
  LABEL maintainer="ruoge3s@qq.com" version="1.0" license="MIT"
  
  COPY ./ssh /root/.ssh
  
  # ---------- 编译时所用参数 ----------
  # 默认 Asia/Shanghai
  ARG timezone
  
  ENV TIMEZONE=${timezone:-"Asia/Shanghai"}
  
  RUN set -ex \
      && sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories \
      && apk update \
      && apk add openssh rsync python \
      && ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
      && echo "${TIMEZONE}" > /etc/timezone \
      # ---------- clear works ----------
      && npm config set registry https://registry.npm.taobao.org \
      && npm install -g node-sass --unsafe-perm=true --allow-root \
      && rm -rf /var/cache/apk/* /tmp/* /usr/share/man \
      && echo -e "\033[42;37m Build Completed :).\033[0m\n"
  
  WORKDIR /home
  ```
  
  > Dockerfile 同级目录需要有ssh文件夹
  
- 创建免密登录条件

  - 构建临时用的容器上(tmp image)

    ```bash
    docker build -t ti .
    ```

  - 创建临时的容器，并进入容器

    ```bash
    docker run -it \
    	--rm \
    	-v $(pwd)/ssh:/root/.ssh \
    	ti sh
    ```

  - 在容器中生成免密登录所需要的密钥(ssh-keygen一路回车就好)

    ```bash
    /home # ssh-keygen
    /home # ls /root/.ssh/
    id_rsa      id_rsa.pub
    ```
    > 只需要在第一次的时候生成公钥私钥生成，后面追加要免密登录的服务器的时候，无需再次生成

  - 设置要免密登录的服务器

    ```bash
    /home # ssh-copy-id root@192.168.1.7
    # .... 输出内容忽略，中间需要输入一次yes和一次密码
    ```

  - 核验免密登录的情况 可以看到设置了三台服务器的免密登录及其对应的ip

    ```
    /home # cat /root/.ssh/known_hosts 
    192.168.1.7 ecdsa-sha2-nistp256 xxxx
    192.168.1.8 ecdsa-sha2-nistp256 xxxx
    192.168.1.9 ecdsa-sha2-nistp256 xxx
    ```

  - 退出当前容器，检查本地免密登录信息生成情况

    ```bash
    [root@localhost runner]# tree
    .
    ├── Dockerfile
    └── ssh
        ├── id_rsa
        ├── id_rsa.pub
        └── known_hosts
    
    1 directory, 4 files
    ```

    > 可以看到已经生成了用于免密登录的信息

- 构建用于发布vue项目的镜像

  - 构建镜像

    ```bash
    docker build -t vue-release:1.0 .
    ```

  - 最后在项目中的.gitlab-ci.yml中

    ```yml
    image: vue-release:1.0
    
    stages:
      - build
    job2:
      stage: build
      script:
        - node -v
        - npm config set registry https://registry.npm.taobao.org
        - npm install
        - npm run build:prod
        - rsync -rzvt $(pwd)/dist/* root@192.168.1.8:/home/release-dir
      only:
        - master
      tags:
        - vuebuidler
    
    ```

    





Update At : {docsify-updated}
