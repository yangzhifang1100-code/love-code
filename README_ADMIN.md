# 爱心网站管理后台使用说明

## 简介

爱心网站管理后台是一个简洁美观的管理系统，用于修改爱心HTML文件中的文本内容，以及设置网站首页显示文件。

## 文件说明

- `admin_index.php` - 主管理界面文件 (推荐使用)
- `admin.css` - 样式文件
- `get_text.php` - 获取当前文本内容的辅助脚本
- `index.html` - 网站首页文件 (会被自动修改)

## 安装步骤

1. 将以下文件上传到网站根目录：
   - admin_index.php
   - admin.css
   - get_text.php
   - index.html
   - README_ADMIN.md (可选)

2. 确保PHP环境已经配置好，并且PHP版本不低于7.0

3. 确保所有g开头的HTML文件 (g.html, g1.html, g2.html, g3.html) 与上述文件位于同一目录

4. 确保web服务器对上述文件有读写权限

## 首页设置方法说明

本系统使用了两种设置首页的方法，建议使用 `admin_index.php`：

1. **首选方法（admin_index.php）**：直接将您选择的文件内容复制到 index.html 文件中。这种方法不依赖于服务器配置，在任何环境下都能正常工作。

   - 优点：不依赖于服务器配置，兼容性好
   - 使用：访问 `http://你的域名/admin_index.php`

2. **备选方法（admin.php）**：通过修改 .htaccess 文件设置默认首页。这种方法依赖于 Apache 服务器并且需要启用 mod_rewrite 模块。

   - 优点：不需要创建额外的文件
   - 局限：只在 Apache 服务器上工作
   - 使用：访问 `http://你的域名/admin.php`

## 使用方法

1. 在浏览器中访问 `http://你的域名/admin_index.php`

2. 输入默认密码 `123456` 登录系统

3. 在管理界面，您可以：
   - 修改各个爱心HTML文件中的文本内容
   - 设置网站默认首页（系统会自动复制所选文件内容到 index.html）

## 在Nginx服务器上的配置

如果您使用的是Nginx服务器，确保在网站配置中添加：

```nginx
server {
    # 其他配置...
    
    # 设置默认首页
    index index.html index.php g.html;
    
    # 确保PHP文件能够正常执行
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php7.4-fpm.sock; # 根据您的PHP版本调整
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

## 修改密码（可选）

如需修改管理后台登录密码，请编辑 `admin_index.php` 文件，找到以下代码行：

```php
// 定义密码
$password = "123456";
```

将 `123456` 修改为您想要的新密码。

## 兼容性说明

本系统已在以下环境中测试通过：
- PHP 7.0+
- Apache/Nginx
- 现代浏览器（Chrome, Firefox, Safari, Edge等）

## 安全说明

为了保障网站安全，建议：
1. 更改默认登录密码
2. 定期备份网站文件
3. 对PHP文件设置适当的访问权限
4. 如果可能，添加IP访问限制，仅允许特定IP访问管理后台 