## 模拟脚本

```go
package main

import "fmt"

func main() {
	callback()
}

func callback() {
	defer func() { fmt.Println("xx3") }()

	defer func() { fmt.Println("xx2") }()
	defer func() { fmt.Println("xx1") }()
	panic("xx4")
}

```

## 输出结果

```bash
work@imac demo % go run main02.go
xx1
xx2
xx3
panic: xx4

goroutine 1 [running]:
main.callback()
        /Users/work/study/demo/main02.go:14 +0x6b
main.main()
        /Users/work/study/demo/main02.go:6 +0x17
exit status 2
```

## 解析说明

 - 因为panic异常是先于三个defer执行的
 - 但是panic在当前函数callback中，callback中无recover()捕捉，会被抛到main函数中
 - 此时callback已经执行完毕，所以callback中的三个defer的输出会已经完成
 - 最后panic在main中寻找recover()，如果main函数中也无recover()，则panic触发整个协程终止