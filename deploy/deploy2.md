## linux命令

| 命令        | 作用          | 备注             |
|-----------|-------------|----------------|
| `source`  | 引入其他shell文件 | 组织脚本           |
| `export`  | 导入环境变量      | 从.env文件中导入环境变量 |
| `scp`     | 文件复制        |                |
| `curl`    | 发起http请求    | 发送飞书消息         |
| `ssh`     | 登录远程服务器     | 在目标服务器上执行发布流程  |
| `mkdir`   | 目录管理        | 创建仓库目录等        |
| `git`     | 代码管理        |                |  
| `ln`      | 创建软连接       | 前端代码使用软链模式     |
| `declare` | 设置变量的属性     | 别名`typeset`    |


## .env

```dotenv
# 配置_tips.sh文件中的_token
_tips.sh._token=abcdefghi-abcdefghi-abcdefghi-abcdefghi
```

> 配置文件中的键名为 "使用调用者的文件名.变量名"  
> 在调用方上，使用`export "$(cat < .env | grep _tips.sh | sed s"/_tips.sh.//g")"`  
> 恢复变量本身，用于覆盖


## _tips.sh 

```shell
#!/usr/bin/env bash

# 飞书通知
function tips() {
  local _token="feishu-token-string"
  export "$(cat < .env | grep _tips.sh | sed s"/_tips.sh.//g")"

  text="[$(date +'%m-%d %H:%M:%S')] ${1}"
  response=$(
    curl -s --location --request \
        POST "https://open.feishu.cn/open-apis/bot/v2/hook/${_token}" \
        --header 'Content-Type: application/json' \
        --data-raw "{\"content\": \"{\\\"text\\\":\\\"${text}\\\"}\",\"msg_type\": \"text\"}"
  )
  if [ "${response}" != "{\"StatusCode\":0,\"StatusMessage\":\"success\"}" ] ; then
    echo "############### 飞书消息发送失败 ###############"
    echo "$response"
    echo "##############################################"
    exit
  fi
}
```

