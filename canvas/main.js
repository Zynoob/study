let canvas = document.getElementById("drawing-board");
let ctx = canvas.getContext("2d");

let eraser = document.getElementById("eraser");
let brush = document.getElementById("brush");
let reSetCanvas = document.getElementById("clear");
let save = document.getElementById("save");
let undo = document.getElementById("undo");
let range = document.getElementById("range");

let btn1 = document.getElementById("btn1");
let btn2 = document.getElementById("btn2");
let changeBgColor = document.getElementById("bgcolor-input"); //输入背景色的input
let changeColor = document.getElementById("color-input"); //输入前景色的input
let one = document.getElementsByClassName("background-color")[0]; //背景色
let two = document.getElementsByClassName("brush-color")[0]; //前景色
let bgDiv = document.getElementsByClassName("bgcolor-input")[0];
let brushDiv = document.getElementsByClassName("color-input")[0];

let bgColor = 'ffffff';
let color = '000000';
let clear = false; //表示是否为橡皮擦状态下
let lWidth = 4; //线宽度
let onestatu = false; //对应bgDiv的显示状态
let twostatu = false; //对应brushDiv的显示状态
let historyData = [];
let firstDot; //保存画布图像数据变量

autoSetSize(canvas);

listenToUser(canvas);

window.onbeforeunload = function () {
    return "Reload site?";
};

/**
 *当窗口初始化以及变化时，重设画布大小
 * @param {*} canvas
 */
function autoSetSize(canvas) {
    canvasSetSize();
    setCanvasBg(bgColor);
    setBrushColor(color);

    function canvasSetSize() {
        let pageWidth = document.documentElement.clientWidth;
        let pageHeight = document.documentElement.clientHeight;

        canvas.width = pageWidth;
        canvas.height = pageHeight;
    }

    let state = true;
    window.onresize = function () {//函数节流，1s内只执行一次
        if (!state) {
            return;
        }
        state = false;
        setTimeout(function () {
            state = true;
            canvasSetSize();
            setCanvasBg(bgColor);
            setBrushColor(color);
        }, 1000);
    }
}

/**
 *
 *修改前景色
 * @param {String} color
 */
function setBrushColor(color) {
    ctx.fillStyle = '#' + color;
    ctx.strokeStyle = '#' + color;
    two.style.backgroundColor = '#' + color;
}

/**
 *修改画布背景色
 * @param {String} bgColor
 */
function setCanvasBg(bgColor) {
    ctx.fillStyle = '#' + bgColor;
    ctx.fillRect(0, 0, canvas.width, canvas.height);
}

function listenToUser(canvas) {
    let painting = false;
    let lastPoint = {
        x: undefined,
        y: undefined
    };

    if (document.body.ontouchstart !== undefined) {
        canvas.ontouchstart = function (e) {
            this.firstDot = ctx.getImageData(0, 0, canvas.width, canvas.height); //在这里储存绘图表面
            saveData(this.firstDot);
            painting = true;
            let x = e.touches[0].clientX;
            let y = e.touches[0].clientY;
            lastPoint = {
                "x": x,
                "y": y
            };
            ctx.save();
            drawCircle(x, y);
        };
        canvas.ontouchmove = function (e) {
            if (painting) {
                let x = e.touches[0].clientX;
                let y = e.touches[0].clientY;
                e.preventDefault();
                let newPoint = {
                    "x": x,
                    "y": y
                };
                drawLine(lastPoint.x, lastPoint.y, newPoint.x, newPoint.y);
                lastPoint = newPoint;
            }
        };

        canvas.ontouchend = function () {
            painting = false;
        }
    } else {
        canvas.onmousedown = function (e) {
            firstDot = ctx.getImageData(0, 0, canvas.width, canvas.height); //在这里储存绘图表面
            saveData(firstDot);
            painting = true;
            let x = e.clientX;
            let y = e.clientY;
            lastPoint = {
                "x": x,
                "y": y
            };
            ctx.save();
            drawCircle(x, y);
        };
        canvas.onmousemove = function (e) {
            if (painting) {
                let x = e.clientX;
                let y = e.clientY;
                let newPoint = {
                    "x": x,
                    "y": y
                };
                drawLine(lastPoint.x, lastPoint.y, newPoint.x, newPoint.y);
                lastPoint = newPoint;
            }
        };

        canvas.onmouseup = function () {
            painting = false;
        };

        canvas.onmouseleave = function () {
            painting = false;
        }
    }
}

function drawCircle(x, y) {
    ctx.save();
    ctx.beginPath();
    ctx.arc(x, y, 0, 0, Math.PI * 2);
    ctx.fill();
    if (clear) {
        ctx.strokeStyle = "#" + bgColor;
        ctx.clip();
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.restore();
        ctx.strokeStyle = '#' + color;
    }
}

function drawLine(x1, y1, x2, y2) {
    ctx.lineWidth = lWidth;
    ctx.lineCap = "round";
    ctx.lineJoin = "round";
    if (clear) {
        ctx.save();
        ctx.globalCompositeOperation = "source-atop";
        ctx.moveTo(x1, y1);
        ctx.lineTo(x2, y2);
        ctx.strokeStyle = "#" + bgColor; //使橡皮擦颜色为背景色
        ctx.stroke();
        ctx.closePath();
        ctx.clip();
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.restore();
        ctx.strokeStyle = '#' + color;
    } else {
        ctx.moveTo(x1, y1);
        ctx.lineTo(x2, y2);
        ctx.stroke();
        ctx.closePath();
    }
}


/**
 *
 *判断颜色字符串的合法性
 * @param {String} verificationColor
 * @returns {Boolean}  
 */
function colorVerification(verificationColor) {
    let regex3 = /^[0-9a-f]{3}$/i;
    let regex6 = /^[0-9a-f]{6}$/i;
    let r3 = regex3.test(verificationColor.value);
    let r6 = regex6.test(verificationColor.value);
    return r3 || r6;
}

btn1.onclick = function () {
    let istrue = colorVerification(changeBgColor);
    if (istrue) {
        bgColor = changeBgColor.value;
        setCanvasBg(bgColor);
        changeBgColor.value = '';
    } else {
        alert('数据不合法,范围为‘000000~ffffff或者000~fff’');
        changeBgColor.value = '';
    }
}
btn2.onclick = function () {
    let istrue = colorVerification(changeColor);
    if (istrue) {
        color = changeColor.value;
        setBrushColor(color);
        changeColor.value = '';
    } else {
        alert('数据不合法,范围为‘000000~ffffff或者000~fff’');
        changeColor.value = '';
    }
}
one.onclick = function () {
    onestatu = !onestatu;
    if (onestatu) {
        bgDiv.style.display = "block";
    } else {
        bgDiv.style.display = "none";
    }
}
two.onclick = function () {
    twostatu = !twostatu;
    if (twostatu) {
        brushDiv.style.display = "block";
    } else {
        brushDiv.style.display = "none";
    }
}
range.onchange = function () {
    lWidth = this.value;
};

eraser.onclick = function () {
    clear = true;
    this.classList.add("active");
    brush.classList.remove("active");
};

brush.onclick = function () {
    clear = false;
    this.classList.add("active");
    eraser.classList.remove("active");
};

reSetCanvas.onclick = function () {
    firstDot = ctx.getImageData(0, 0, canvas.width, canvas.height); //在这里储存绘图表面
    saveData(firstDot);
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    setCanvasBg(bgColor);
};

save.onclick = function () {
    let imgUrl = canvas.toDataURL("image/png");
    let saveA = document.createElement("a");
    document.body.appendChild(saveA);
    saveA.href = imgUrl;
    saveA.download = "zypic" + (new Date).getTime();
    saveA.target = "_blank";
    var confirmDownload = confirm("是否下载图像？");
    if (confirmDownload) {
        saveA.click();
    } else {
        return;
    }
};

undo.onclick = function () {
    if (historyData.length < 1) return false;
    ctx.putImageData(historyData[historyData.length - 1], 0, 0);
    historyData.pop()
};



function saveData(data) {
    (historyData.length === 10) && (historyData.shift()); // 上限为储存10步，左边不成立，右边不执行。
    historyData.push(data);
}