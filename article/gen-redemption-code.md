## 案例代码

```go
package coder

import (
	"math/rand"
	"strings"
	"time"
)

const KEY = "HIJKL8AB5P2XY9QGVCDZ7MNRE34FSTU6W1"

var chars []rune

func init() {
	chars = []rune(KEY)
}

func algorithm(arr []rune) rune {
	var total int
	for _, v := range arr {
		ord := int(v)
		total += ord * (ord % 10)
	}
	return chars[total%len(arr)]
}

func Generate(length int) string {
	var c = make([]rune, length)
	var r = rand.New(rand.NewSource(time.Now().UnixNano()))
	r.Shuffle(len(chars), func(i, j int) {
		chars[i], chars[j] = chars[j], chars[i]
	})
	for i := 0; i < length-1; i++ {
		c[i] = chars[r.Intn(length)]
	}
	c[length-1] = algorithm(c[0 : length-1])

	var b strings.Builder
	b.Grow(length)
	for _, s := range c {
		b.WriteString(string(s))
	}
	return b.String()
}

func Verify(code string, length int) bool {
	var c = []rune(code)

	if len(c) != length {
		return false
	}

	return algorithm(c[0:length-1]) == c[length-1]
}
```