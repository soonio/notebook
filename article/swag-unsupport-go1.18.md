
## 示例文件

- pkg/utils/util.go

```go
//118STA

func Or[v any](assert bool, yes, no v) v {
	if assert {
		return yes
	} else {
		return no
	}
}

//118END
```

## 处理脚本

```shell
#!/usr/bin/env zsh

# env=linux
# sed -i "s/a/b/g" "$1"
# env=macos
# sed -i "" "s/a/b/g" "$1"

disappear() {
    sed -i "" "s/\/\/118STA/\/**118STA/g" "$1"
    sed -i "" "s/\/\/118END/118END**\//g" "$1"
}

recovery() {
  sed -i "" "s/\/\*\*118STA/\/\/118STA/g" "$1"
  sed -i "" "s/118END\*\*\//\/\/118END/g" "$1"
}

disappear pkg/utils/util.go

swag fmt && swag init --md ./docs

recovery pkg/utils/util.go
```

## 原理

  在执行swag命令前，使用sed命令把对应的代码注释掉，然后在swag文档生成后，再取消注释