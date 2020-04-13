## runner安装

```bash
# 使用docker景象安装
git pull gitlab/gitlab-runner-helper
# 启动
docker run -d \
	--name=gitlab-runner \
	--restart=always \
	-v /data/prod/gitlab-runner/config:/etc/gitlab-runner \
  -v /var/run/docker.sock:/var/run/docker.sock \
  gitlab/gitlab-runner
# 注册，会要求输入gitlab的地址，和token，以及选定执行器
docker exec -it gitlab-runner gitlab-ci-multi-runner register
```



## runner应用

- 自定义docker

```dockerfile
FROM node:13-alpine

LABEL maintainer="ruoge3s@qq.com" version="1.0" license="MIT"

COPY ./ssh /root/.ssh

# ---------- 编译时所用参数 ----------
# 默认 Asia/Shanghai
ARG timezone
# 默认 prod
ARG appenv

ENV TIMEZONE=${timezone:-"Asia/Shanghai"} \
    APP_ENV=${appenv:-"prod"}

RUN set -ex \
    && sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories \
    && apk update \
    && apk add openssh rsync \
    && ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    # ---------- clear works ----------
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man \
    && echo -e "\033[42;37m Build Completed :).\033[0m\n"

WORKDIR /home
```

- ssh文件创建

  - 需要提前使用ssh-keygen生成密钥文件
  - 需要提前使用免密登录生成konw_host

  ```bash
  /home # ls -al /root/.ssh/
  total 12
  drwxr-xr-x    2 root     root            57 Apr 13 12:24 .
  drwx------    1 root     root            26 Apr 13 12:25 ..
  -rw-------    1 root     root          2602 Apr 13 12:12 id_rsa
  -rw-r--r--    1 root     root           571 Apr 13 12:13 id_rsa.pub
  -rw-r--r--    1 root     root           176 Apr 13 12:13 known_hosts
  ```

  - **文件权限要对应上，不然新创建的容器会打开失败**

- 使用本地镜像

  ```toml
  concurrent = 1
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

  > 重点在最后一句`pull_policy="if-not-present"`,可以使用本地镜像

