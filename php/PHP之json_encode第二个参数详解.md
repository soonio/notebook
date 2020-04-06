
预定义常量
下列常量由此扩展定义，且仅在此扩展编译入 PHP 或在运行时动态载入时可用。

以下常量表示了 json_last_error() 所返回的错误类型。

JSON_ERROR_NONE (integer)
没有错误发生。自 PHP 5.3.0 起生效。
JSON_ERROR_DEPTH (integer)
到达了最大堆栈深度。自 PHP 5.3.0 起生效。
JSON_ERROR_STATE_MISMATCH (integer)
出现了下溢（underflow）或者模式不匹配。自 PHP 5.3.0 起生效。
JSON_ERROR_CTRL_CHAR (integer)
控制字符错误，可能是编码不对。自 PHP 5.3.0 起生效。
JSON_ERROR_SYNTAX (integer)
语法错误。 自 PHP 5.3.0 起生效。
JSON_ERROR_UTF8 (integer)
异常的 UTF-8 字符，也许是因为不正确的编码。 此常量自 PHP 5.3.1 起生效。
下面的常量可以和 json_encode() 的 form 选项结合使用。

JSON_HEX_TAG (integer)
所有的 < 和 > 转换成 \u003C 和 \u003E。 自 PHP 5.3.0 起生效。
JSON_HEX_AMP (integer)
所有的 & 转换成 \u0026。 自 PHP 5.3.0 起生效。
JSON_HEX_APOS (integer)
所有的 ' 转换成 \u0027。 自 PHP 5.3.0 起生效。
JSON_HEX_QUOT (integer)
所有的 " 转换成 \u0022。 自 PHP 5.3.0 起生效。
JSON_FORCE_OBJECT (integer)
使一个非关联数组输出一个类（Object）而非数组。 在数组为空而接受者需要一个类（Object）的时候尤其有用。 自 PHP 5.3.0 起生效。
JSON_NUMERIC_CHECK (integer)
将所有数字字符串编码成数字（numbers）。 自 PHP 5.3.3 起生效。
JSON_BIGINT_AS_STRING (integer)
将大数字编码成原始字符原来的值。 自 PHP 5.4.0 起生效。
JSON_PRETTY_PRINT (integer)
用空白字符格式化返回的数据。 自 PHP 5.4.0 起生效。
JSON_UNESCAPED_SLASHES (integer)
不要编码 /。 自 PHP 5.4.0 起生效。
JSON_UNESCAPED_UNICODE (integer)
以字面编码多字节 Unicode 字符（默认是编码成 \uXXXX）。 自 PHP 5.4.0 起生效。