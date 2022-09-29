#!/usr/bin/env bash

# 尝试从.deploy.env文件中读取远程服务器和密码
#if [ -f ".deploy.env" ]; then
#  while read -r row; do
#    if [ "${row:0:1}" != "#" ]; then
#      export "${row?}"
#    fi
#  done < .deploy.env
#else
#  echo -e "#请开启下面配置\n#ProdServer=username@192.168.1.110\n#请开启下面配置\n#ProdPassword=password-string" > .deploy.env
#fi

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
    exit 1
  fi
}

