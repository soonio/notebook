# GitLab Runner

> 自己搭建的runner服务器，需要设置上电自启动、服务自启动，避免断电和重启造成服务未开启

## gitlab-runner安装

### 安装
```bash
# 下载二进制命令文件
sudo curl -L --output /usr/local/bin/gitlab-runner https://gitlab-runner-downloads.s3.amazonaws.com/latest/binaries/gitlab-runner-linux-amd64

# 给二进制命令添加可执行权限
sudo chmod +x /usr/local/bin/gitlab-runner

# 创建gitlab-runner用户
sudo useradd --comment 'GitLab Runner' --create-home gitlab-runner --shell /bin/bash

# 安装gitlab-runner服务到systemd(开机启动)
sudo gitlab-runner install --user=gitlab-runner --working-directory=/home/gitlab-runner

# 启动systemd服务
sudo gitlab-runner start
```

### gitlab-runner注册服务

  ```
  sudo gitlab-runner register  --url https://gitlab.demo.com  --token xxx
  ```

### shell executor

  ```bash
  sudo rm -rf /home/gitlab-runner/.bash_logout
  ```

  > shell executor 需要删除以上文件才能正常执行流水线 [参考内容](https://docs.gitlab.com/runner/shells/index.html#shell-profile-loading)

### 删除注册的服务

  ```bash
  sudo gitlab-runner verify --delete --name inside-apple
  ```

  > 其中 `inside-apple` 是注册时填写的名称


## 环境

### golang编译环境

    使用docker进行编译

    # 测试环境会使用使用服务内的配置
    rm -rf /home/web/app/etc && rm -f /home/web/app/app && tar zxvf /home/web/app/package.tgz  -C /home/web/app/ && systemctl restart supervisord

    # 生产环境仅替换二进制文件
    rm -f /home/web/app/app && tar zxvf /home/web/app/package.tgz  -C /home/web/app/

### 前端编译环境
    使用docker进行编译

### 上传

   容器环境
   使用scp、rsync命令
