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
    exit 1
  fi
}

