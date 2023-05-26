## 相关文档

  - [swag](https://github.com/swaggo/swag) - 使用的是2.0-rc版本
  - [swagger-ui](https://github.com/soonio/swagger-ui)


## 具体使用方法
  - `main.go`

    ```go
    //	@title			某某结构文件
    //	@version		1.0
    //	@description	这是一个接口文档

    // @servers.url https://api-serve.domain.cn
    // @servers.description 测试环境

    // @securityDefinitions.apikey WithToken
    // @in header
    // @name Authorization
    // @description 设置一个全局的token,接口通过设置`@Security WithToken`来使用

    func main() {}

    ```
  - `api.go`
  
    ```go
    // List
    //
    //	@Tags		用户管理
    //	@Security	WithToken
    //	@Summary	用户列表
    //	@Param		enable		query		int				false	"启用1/禁用0"	Enums(0, 1)
    //	@Param		nickname	query		string			false	"姓名"
    //	@Param		username	query		string			false	"账户"
    //	@Param		page		query		int				false	"页码"	Minimum(0)	default(1)
    //	@Param		size		query		int				false	"分页数量"	Maximum(50)	default(10)
    //	@Success	200			{object}	[]model.Admin	"数据列表"
    //	@Router		/admin [get]
    func users() {}
    ```

## 生成文档的命令

  ```bash
  swag fmt --dir=app/api && swag init --md ./docs --ot=json --v3.1
  ```