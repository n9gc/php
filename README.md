# ScpoPHP

**简体中文** | [English](README-en.md)

ScpoPHP 是一个包含很多有用函数的 PHP 函数库，主要语言为中文。目前由幻想私社维护。

## 目前包含的功能

标有 * 的表示仍有功能未开发完成

- Api: API 相关实用函数
- Cache: 缓存相关实用函数
- Cookie: cookie 相关实用函数
- Db: SQL 数据库增删改查实用函数
- Email: PHPMailer 实用函数
- Errpage: HTTP 错误相关函数
- Str: 字符串、十六进制和二进制之间相互转换的函数
- Url: URL 重写对应实用函数
- *User: 用户系统相关函数

## 如何使用

1. 将 git 库克隆到本地
2. 复制`config.default.php`为`config.php`
3. 修改`config.php`的配置
4. 在依赖本库的项目中修改或添加语句`require 'scpo-php/xxx.php'`
5. 使用`ScpoPHP\Xxx::function()`来愉快的调用函数
