## 使用goctl把mysql表转换成go struct

```bash
#!/usr/bin/env bash

Script="import re,sys;f = open(sys.argv[1], mode='r+');res = f.read();print('package table\ntype '+re.compile(r'[a-zA-z]+\s(struct)\s\{\n(\t\t(?!conn).*\n)+\t\}').search(res).group());f.close()"
workdir=runtime/model
currdir=$(pwd)

mkdir -p ${workdir}

cd ${workdir} || exit 1

rm -rf ./*go
goctl model mysql datasource --url "root:password@tcp(127.0.0.1:3306)/database-name" \
  -t tablename1 \
  -t tablename2 \
  -t tablename3 \
  -t tablename4 \
  -t tablename5 \

rm -rf ./*model.go && rm -rf ./vars.go

for file in ./*; do
  python3 -c "$Script" "$file" > "${file%*model_gen.go}".go
done

rm -rf ./*_gen.go

go fmt

cd "$currdir" || exit 1


```