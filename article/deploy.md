## 使用rsync同步文件

```bash
# 使用密钥
eval $(ssh-agent -s) \
&& ssh-add ~/my.pem \
&& /usr/bin/rsync -rzvt \
  --exclude "vendor" \
  --exclude "runtime" \
  /project/dir/* root@192.168.1.3:/data/api/unify/ \
&& kill $SSH_AGENT_PID

# 在免密模式下
rsync -rzvt \
  --exclude "vendor" \
  --exclude "runtime" \
  /project/dir/* root@192.168.1.3:/data/api/unify/
```

> 使用ssh-agent，会启动一个agent进程，在使用完成后，需要关闭。所以使用 `kill $SSH_AGENT_PID` 关闭。

## 使用ssh直接调用远程服务器命令

```bash
ssh -p22 root@192.168.1.3 "supervisorctl status"
```

## 联合使用ssh和rsync进行简便快捷的发布项目

### sync.sh

```shell
#!/usr/bin/env bash
cd `dirname $0`

echo "🚀 $(date "+%Y-%m-%d %H:%M:%S") 开始同步⛽️"

# 目标地址
REMOTE="root@192.168.1.1"
# 目标目录
REMOTE_DIR="/data/project/"

# 具体要执行的命令
eval $(ssh-agent -s) \
&& ssh-add ~/secret.pem \
&& /usr/bin/rsync -rzvt \
    --exclude "sync.sh" \
    --exclude "vendor" \
    --exclude "runtime" \
    `pwd`/* ${REMOTE}:${REMOTE_DIR} \
&& ssh -p22 ${REMOTE} "sed -i \"s/VERSION_PLACEHOLDER/updateAt \$(date \"+%Y-%m-%d %H:%M:%S\")/g\" ${REMOTE_DIR}config/config.php" \
&& ssh -p22 ${REMOTE} "docker restart unify" \
&& kill $SSH_AGENT_PID

echo "✅ $(date "+%Y-%m-%d %H:%M:%S") 同步结束 😂"
```

### deploy.sh

```shell
#!/usr/bin/env bash

# 判断是否有无修改
if [ -z "`git status -s`" ]
then
  echo "No Anything Changed.."
  echo "Do you want to continue[Y/N]?"
  read -r answer
  case ${answer} in
    Y | y)
      echo "continue"
    ;;
    N | n)
      echo "goodbye"
      exit 0
    ;;
    *)
      echo "Nothing input ~"
      exit 0
    ;;
  esac
else
  echo "🚀 $(date "+%Y-%m-%d %H:%M:%S") 提交代码⛽️"
  echo "Please input commit message: "
  read -r message
  git add . && git commit -m "${message}" && git push
fi

echo "🚀 $(date "+%Y-%m-%d %H:%M:%S") 开始同步⛽️"

# 目标地址
REMOTE="root@192.168.1.1."
# 目标目录
REMOTE_DIR="/data/www/web"

# 具体要执行的命令
eval $(ssh-agent -s) \
&& ssh-add ~/secret.pem \
&& ssh -p22 ${REMOTE} "cd $REMOTE_DIR && git reset --hard && git checkout develop && git pull" \
&& ssh -p22 ${REMOTE} "sed -i \"s/VERSION_PLACEHOLDER/updateAt \$(date \"+%Y-%m-%d %H:%M:%S\")/g\" ${REMOTE_DIR}/config/config.php" \
&& ssh -p22 ${REMOTE} "docker exec unify composer install --no-dev -o" \
&& ssh -p22 ${REMOTE} "docker exec unify php bin/hyperf.php migrate" \
&& ssh -p22 ${REMOTE} "cd /data/compose && docker-compose restart" \
&& kill $SSH_AGENT_PID

echo "✅ $(date "+%Y-%m-%d %H:%M:%S") 同步结束 😂"

```