<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>后台管理</title>
    <link rel="stylesheet" href="admin.css">
    <style>
        /* 新增样式或覆盖原有样式 */
        body {
            background: linear-gradient(45deg, #fff5f7 0%, #ffebef 100%);
            transition: all 0.3s ease;
        }
        
        /* 圆形头像样式 */
        .avatar-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ff9eb6;
            box-shadow: 0 5px 15px rgba(255, 107, 157, 0.3);
            transition: transform 0.3s ease;
        }
        
        .avatar:hover {
            transform: scale(1.1);
        }
        
        /* 登录状态显示 */
        .login-status {
            background-color: #f0fff4;
            color: #38a169;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            margin-right: 10px;
        }
        
        .login-status::before {
            content: '•';
            color: #38a169;
            font-size: 24px;
            margin-right: 5px;
        }
        
        /* 扁平化表单样式 */
        .form-group input, .form-group select {
            border-radius: 8px;
            border: 1px solid #ffd1e0;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus, .form-group select:focus {
            border-color: #ff6b9d;
            box-shadow: 0 0 0 3px rgba(255, 107, 157, 0.1);
        }
        
        /* 按钮动画效果 */
        .submit-btn, .login-btn {
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover, .login-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 7px 15px rgba(255, 107, 157, 0.4);
        }
        
        /* 文件选择样式 */
        .file-option {
            margin-bottom: 5px;
        }
        
        .file-option-label {
            display: inline-block;
            margin-left: 5px;
            color: #ff6b9d;
            font-weight: normal;
        }
        
        /* 樱花特效容器样式 */
        #canvas_sakura {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        /* 页面头部区域右侧布局 */
        .header-right {
            display: flex;
            align-items: center;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .admin-header .avatar-container {
            margin-bottom: 0;
            margin-right: 15px;
        }
        
        .header-left {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
<?php
session_start();

// 定义密码
$password = "123456";

// 处理登录请求
if (isset($_POST['password'])) {
    if ($_POST['password'] === $password) {
        $_SESSION['logged_in'] = true;
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    } else {
        $error = "密码错误，请重试！";
    }
}

// 处理登出请求
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

// 处理文本更新请求
if (isset($_POST['update_text']) && isset($_SESSION['logged_in'])) {
    $file = $_POST['file'];
    $text = $_POST['text'];
    
    // 检查文件名是否合法（以g开头，.html结尾）
    if (preg_match('/^g[0-9]*.html$/', $file)) {
        // 更新文件内容
        if ($file === 'g.html') {
            // 处理g.html的更新
            $content = file_get_contents($file);
            $content = preg_replace('/<div class="title">(.*?)<\/div>/', '<div class="title">'.$text.'</div>', $content);
            file_put_contents($file, $content);
        } else if ($file === 'g1.html') {
            // 处理g1.html的更新
            $content = file_get_contents($file);
            $content = preg_replace('/ctx\.fillText\(\s*"(.*?)",\s*this\.x - this\.width \* 0\.5,/', 'ctx.fillText("'.$text.'", this.x - this.width * 0.5,', $content);
            file_put_contents($file, $content);
        } else if ($file === 'g2.html') {
            // 处理g2.html的更新
            $content = file_get_contents($file);
            $content = preg_replace('/<h4>💗(.*?)<\/h4>/', '<h4>💗'.$text.'</h4>', $content);
            file_put_contents($file, $content);
        } else if ($file === 'g3.html') {
            // 处理g3.html的更新
            $content = file_get_contents($file);
            $content = preg_replace('/<div class="title">(.*?)<\/div>/', '<div class="title">'.$text.'</div>', $content);
            file_put_contents($file, $content);
        }
        
        $success = "文本内容已成功更新！";
    }
}

// 处理首页设置请求
if (isset($_POST['set_index']) && isset($_SESSION['logged_in'])) {
    $index_file = $_POST['index_file'];
    
    // 检查文件是否存在
    if (file_exists($index_file)) {
        // 创建或更新.htaccess文件来设置默认索引页
        $htaccess = "DirectoryIndex " . $index_file . "\n";
        file_put_contents(".htaccess", $htaccess);
        $success = "首页已成功设置为 " . $index_file;
    } else {
        $error = "文件不存在，无法设置为首页";
    }
}

// 显示登录表单或管理界面
if (!isset($_SESSION['logged_in'])) {
    // 显示登录界面
?>
    <div class="login-container">
        <div class="login-box">
            <div class="avatar-container">
                <img src="q.jpg" alt="头像" class="avatar">
            </div>
            <?php if (isset($error)) { ?>
                <div class="error"><?php echo $error; ?></div>
            <?php } ?>
            <form method="post" action="">
                <div class="form-group">
                    <input type="password" name="password" placeholder="请输入管理密码" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="login-btn">登 录</button>
                </div>
            </form>
        </div>
    </div>
<?php
} else {
    // 显示管理界面
?>
    <div class="admin-container">
        <div class="admin-header">
            <div class="header-left">
                <div class="avatar-container">
                    <img src="q.jpg" alt="头像" class="avatar">
                </div>
            </div>
            <div class="header-right">
                <span class="login-status">已登录</span>
                <a href="?logout=1" class="logout-btn">退出登录</a>
            </div>
        </div>
        
        <?php if (isset($success)) { ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php } ?>
        
        <?php if (isset($error)) { ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php } ?>
        
        <div class="admin-content">
            <!-- 设置网站首页界面（放在前面） -->
            <div class="admin-section">
                <h2>设置网站首页</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label>选择作为首页的文件：</label>
                        <select name="index_file">
                            <option value="g.html">第一个界面 - 普通爱心</option>
                            <option value="g1.html">第二个界面 - 漂浮爱心</option>
                            <option value="g2.html">第三个界面 - 粒子爱心</option>
                            <option value="g3.html">第四个界面 - 纪念日爱心</option>
                            <option value="love.html">经典爱心样式</option>
                            <option value="love2.html">简约爱心样式</option>
                            <option value="love6.html">多彩爱心样式</option>
                            <option value="love-add3.html">特效爱心样式</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="set_index" class="submit-btn">设置为首页</button>
                    </div>
                </form>
            </div>
            
            <div class="admin-section">
                <h2>爱心文件预览</h2>
                <div class="preview-container">
                    <div class="preview-links">
                        <a href="g.html" target="_blank" class="preview-link">第一个界面</a>
                        <a href="g1.html" target="_blank" class="preview-link">第二个界面</a>
                        <a href="g2.html" target="_blank" class="preview-link">第三个界面</a>
                        <a href="g3.html" target="_blank" class="preview-link">第四个界面</a>
                        <a href="love.html" target="_blank" class="preview-link">经典爱心</a>
                        <a href="love2.html" target="_blank" class="preview-link">简约爱心</a>
                        <a href="love6.html" target="_blank" class="preview-link">多彩爱心</a>
                        <a href="love-add3.html" target="_blank" class="preview-link">特效爱心</a>
                    </div>
                </div>
            </div>
            
            <!-- 修改爱心文字内容界面（放在后面） -->
            <div class="admin-section">
                <h2>修改爱心文字内容</h2>
                <form method="post" action="">
                    <div class="form-group">
                        <label>选择要修改的文件：</label>
                        <select name="file" id="file-select">
                            <option value="g.html">第一个界面 - 普通爱心</option>
                            <option value="g1.html">第二个界面 - 漂浮爱心</option>
                            <option value="g2.html">第三个界面 - 粒子爱心</option>
                            <option value="g3.html">第四个界面 - 纪念日爱心</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>爱心文字内容：</label>
                        <input type="text" name="text" id="text-input" placeholder="请输入要显示的文字">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="update_text" class="submit-btn">更新文字</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // 获取当前文件内容，用于自动填充文本输入框
        document.getElementById('file-select').addEventListener('change', function() {
            var file = this.value;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_text.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('text-input').value = this.responseText;
                }
            };
            xhr.send('file=' + file);
        });
        
        // 页面加载时触发一次，获取默认选中文件的文本
        window.onload = function() {
            var event = new Event('change');
            document.getElementById('file-select').dispatchEvent(event);
        };
    </script>
    
    <!-- 引入樱花飘落效果 -->
    <script src="js/yinghua.js"></script>
<?php
}
?>
</body>
</html> 