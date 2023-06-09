
## 尝试自定义一个 rest-client
```bash
# domain=https://demo.iosoon.cn

domain=http://127.0.0.1:4321
TOKEN=""

function remove() {
  rm .request.sh.txt
}

function set_token() {
  if [ -f .request.sh.txt ]; then
    TOKEN=$(cat .request.sh.txt)
  else
    TOKEN="Bearer "$(curl -s -X 'POST' \
      "${domain}/admin/login" \
      -H 'accept: application/json' \
      -H 'Content-Type: application/json' \
      -d '{
    "password": "12345678",
    "username": "qingliu"
    }' | awk -F 'token":"' '{print $2}' | awk -F '"' '{print $1}')

    echo $TOKEN >.request.sh.txt
  fi
}

function vip() {
  curl -s -X 'GET' \
    "${domain}/vip?page=1&size=10" \
    -H 'accept: application/json' \
    -H "Authorization: $TOKEN" | python3 -m json.tool --no-ensure-ascii
}
function divine_record() {
  curl -s -g -X 'GET' \
    "${domain}/divine/record?type=6&page=1&size=10&lang=sc&sorter[field]=id&sorter[order]=descend" \
    -H 'accept: application/json' \
    -H "Authorization: $TOKEN" | python3 -m json.tool --no-ensure-ascii
}

while getopts "rw:" opt; do
  case $opt in
  r) # 删除
    remove
    ;;
  w)
    set_token
    $OPTARG
    ;;
  \?) # 参数无效
    echo "参数错误: -$OPTARG" >&2
    exit 1
    ;;
  :) # 需要参数却没填
    echo "参数 -$OPTARG 需要填写." >&2
    exit 1
    ;;
  esac
done

```