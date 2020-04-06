
# 1. 添加cookie
> js添加/修改cookie的一些方法

```
function setCookie(name,value,expires)
{
    var date = new Date();
    
    date.setTime(date.getTime() + expires*1000);
    
    var kv  = name + "="+ escape (value);
    var exp = "expires=" + date.toGMTString();
    
    document.cookie = kv + ';' + exp;
}
```

# 2. 读取cookie

```
function getCookie(name)
{
	var arr;
	var reg = new RegExp("(^| )"+name+"=([^;]*)(;|$)");

	if(arr=document.cookie.match(reg)) {
		return unescape(arr[2]);
	} else {
		return null;
	}
}
```

# 3. 删除cookie

```
function delCookie(name)
{
	var exp = new Date();
	exp.setTime(exp.getTime() - 1);
	var cval = getCookie(name);
	if(cval != null) {
		document.cookie= name + "="+cval+";expires="+exp.toGMTString();
	}
}

```