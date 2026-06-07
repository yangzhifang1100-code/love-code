<?php
// 检查文件名是否传递
if (!isset($_POST['file'])) {
    echo "错误：未指定文件";
    exit;
}

$file = $_POST['file'];

// 安全检查：确保文件名合法
if (!preg_match('/^g[0-9]*.html$/', $file) || !file_exists($file)) {
    echo "错误：文件不存在或文件名不合法";
    exit;
}

// 读取文件内容
$content = file_get_contents($file);

// 根据不同文件提取文本内容
if ($file === 'g.html') {
    // 提取g.html中的文本
    if (preg_match('/<div class="title">(.*?)<\/div>/', $content, $matches)) {
        echo $matches[1];
    }
} else if ($file === 'g1.html') {
    // 提取g1.html中的文本
    if (preg_match('/ctx\.fillText\(\s*"(.*?)",\s*this\.x - this\.width \* 0\.5,/', $content, $matches)) {
        echo $matches[1];
    }
} else if ($file === 'g2.html') {
    // 提取g2.html中的文本
    if (preg_match('/<h4>💗(.*?)<\/h4>/', $content, $matches)) {
        echo $matches[1];
    }
} else if ($file === 'g3.html') {
    // 提取g3.html中的文本
    if (preg_match('/<div class="title">(.*?)<\/div>/', $content, $matches)) {
        echo $matches[1];
    }
} else {
    echo "未知文件类型";
}
?> 