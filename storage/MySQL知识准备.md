
## 1. 几种inner join、left join、right join的区别

    inner join  
        -- 多个表都有信息的时候才能显示某条查询结果  
    
    left join & right join  
        -- 查询结果以主表为标准，带上left(right)表的信息  

## MySQL中的链接查询

ON a.colunmu = b.column 可以使用USING (column_name)代替 
INNER JIOIN 强制类型条件,会过滤左表或者右表中不相匹配的数据
OUTER JOIN 可选择性条件,无论匹配与否都不过该表滤任何数据行

不仅在select中可以使用join语法,在update和delete也可以使用

## MySQL合并查询(UNION)
UNION语句主要用来为某SQL查询合并多个SELECT语句的结果.
ALL和DISTINCT 前者列出所有,后者自动去重,若不写,默认DISTINCT

```
SELECT f.country
FROM flags as f
INNER JOIN colors as c USING (color)
WHERE c.is_dark = 1
UNION (ALL/DISTINCT)
SELECT f.country
FROM flags as f
INNER JOIN colors as c USING (color)
WHERE c.is_primary = 1
```


## MySQL查询的GROUP BY
GROUP BY对选择的数据进行聚合,并且可以使用标量函数
GROUP_CONCAT(column) 连接成一行

WITH ROLLUP 是GROUP UP的额外关键字
        --使查询结果中的数据行将包含每个GROUP BY列的聚合的行
HAVING
        --可以针对标量函数限制聚合数据行列表

## MySQL中的逻辑运算符和流程控制
MySQL所有逻辑只有三种状态 即 TRUE FALSE NULL
运算符运算结果也将是以上三种状态

逻辑运算符
        --逻辑运算符AND OR XOR 是双目运算符 NOT 是单目预算符
流程控制
        --四个用于流程控制的函数 IF() CASE IFNULL() NULLIF()
