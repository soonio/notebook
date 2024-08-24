

```makefile
# 二进制文件名称
Binary=demo

# 版本信息
package="main"
VERSION=v3.0
DATETIME=$(shell TZ=Asia/Shanghai date "+%F %T")

ldflags="-s -w -X '${package}.Version=${VERSION}' -X '${package}.Datetime=${DATETIME}'"

prod:
	go clean

	CGO_ENABLED=0 GOOS=linux GOARCH=amd64 go build -ldflags ${ldflags} -trimpath -o $(Binary)
```

```go
package main

import "fmt"

var Version = "1.0"

var Datetime = "0000-00-00 00:00:00"

func main() {
	fmt.Printf("Version: %s\n", Version)
	fmt.Printf("Datetime: %s\n", Datetime)
}
```