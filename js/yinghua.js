/**
 * 樱花飘落特效
 */
(function() {
    // 创建樱花画布
    const canvas = document.createElement('canvas');
    canvas.id = 'canvas_sakura';
    document.body.appendChild(canvas);
    
    const ctx = canvas.getContext('2d');
    const width = window.innerWidth;
    const height = window.innerHeight;
    
    canvas.width = width;
    canvas.height = height;
    
    // 樱花粒子数量
    const SAKURA_COUNT = 50;
    // 樱花颜色
    const SAKURA_COLORS = [
        'rgba(255, 183, 197, 0.9)',
        'rgba(255, 197, 208, 0.9)',
        'rgba(255, 209, 220, 0.9)',
        'rgba(255, 221, 228, 0.9)',
        'rgba(255, 183, 197, 0.7)'
    ];
    
    // 樱花类
    class Sakura {
        constructor() {
            this.x = Math.random() * width;
            this.y = Math.random() * height * 2 - height;
            this.size = Math.random() * 15 + 5;
            this.color = SAKURA_COLORS[Math.floor(Math.random() * SAKURA_COLORS.length)];
            this.speed = Math.random() * 2 + 0.5;
            this.alpha = Math.random() * 0.5 + 0.5;
            this.rotation = Math.random() * 360;
            this.rotationSpeed = Math.random() * 2 - 1;
            this.oscillationSpeed = Math.random() * 0.2 + 0.1;
            this.oscillationDistance = Math.random() * 5 + 2;
            this.angleX = 0;
            this.angleY = 0;
            this.wave = Math.random() * Math.PI * 2;
        }
        
        update() {
            this.y += this.speed;
            this.x += Math.sin(this.angleX) * this.oscillationDistance;
            
            this.angleX += this.oscillationSpeed;
            this.angleY += this.oscillationSpeed;
            this.rotation += this.rotationSpeed;
            this.wave += 0.01;
            
            // 重置超出边界的樱花
            if (this.y > height + this.size) {
                this.y = -this.size;
                this.x = Math.random() * width;
            }
        }
        
        draw() {
            ctx.save();
            ctx.translate(this.x, this.y);
            ctx.rotate(this.rotation * Math.PI / 180);
            
            // 绘制樱花花瓣
            ctx.beginPath();
            ctx.fillStyle = this.color;
            ctx.globalAlpha = this.alpha;
            
            // 樱花花瓣形状
            ctx.moveTo(0, 0);
            ctx.bezierCurveTo(
                -this.size / 2, -this.size / 2,
                -this.size, 0,
                0, this.size
            );
            ctx.bezierCurveTo(
                this.size, 0,
                this.size / 2, -this.size / 2,
                0, 0
            );
            
            ctx.fill();
            ctx.restore();
        }
    }
    
    // 创建樱花数组
    const sakuras = [];
    for (let i = 0; i < SAKURA_COUNT; i++) {
        sakuras.push(new Sakura());
    }
    
    // 动画循环
    function animate() {
        ctx.clearRect(0, 0, width, height);
        
        sakuras.forEach(sakura => {
            sakura.update();
            sakura.draw();
        });
        
        requestAnimationFrame(animate);
    }
    
    // 窗口大小变化时重新设置画布尺寸
    window.addEventListener('resize', () => {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    });
    
    // 开始动画
    animate();
})();

