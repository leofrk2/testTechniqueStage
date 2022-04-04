function drawRectangles() {
    const canvas = document.querySelector('#canvas');
    const canvas2 = document.querySelector('#canvas2');

    if (!canvas.getContext) {
        return;
    }
    if (!canvas2.getContext) {
        return;
    }


    const ctx = canvas.getContext('2d');
    const ctx2 = canvas2.getContext('2d');
    const id = setInterval(() => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx2.clearRect(0, 0, canvas2.width, canvas2.height);
        ctx.fillStyle = '#d74242';
        ctx2.fillStyle = '#d74242';
        ctx.fillRect(0, 0, 100, 100);
        ctx2.fillRect(0, 0, 100, 100);
        randomFace(ctx);
        randomFace(ctx2);
    }, 50)


}

function randomFace(ctx) {
    let a = randomInt(1, 6);
    if (a === 1)
        face1(ctx);
    else if (a === 2)
        face2(ctx);
    else if (a === 3)
        face3(ctx);
    else if (a === 4)
        face4(ctx);
    else if (a === 5)
        face5(ctx);
    else if (a === 6)
        face6(ctx);
}

function randomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function face1(ctx) {
    ctx.fillStyle = '#d7bebe';
    drawCircle(ctx, canvas.width / 2, canvas.height / 2, 10, true);
}

function face2(ctx) {
    ctx.fillStyle = '#d7bebe';
    drawCircle(ctx, canvas.width / 4, canvas.height / 4, 10, true);
    drawCircle(ctx, (canvas.width / 4) * 3, (canvas.height / 4) * 3, 10, true);
}

function face3(ctx) {
    ctx.fillStyle = '#d7bebe';
    drawCircle(ctx, canvas.width / 4, canvas.height / 4, 10, true);
    drawCircle(ctx, (canvas.width / 4) * 3, (canvas.height / 4) * 3, 10, true);
    drawCircle(ctx, canvas.width / 2, canvas.height / 2, 10, true);
}

function face4(ctx) {
    ctx.fillStyle = '#d7bebe';
    drawCircle(ctx, canvas.width / 4, canvas.height / 4, 10, true);
    drawCircle(ctx, (canvas.width / 4) * 3, (canvas.height / 4) * 3, 10, true);
    drawCircle(ctx, canvas.width / 4, (canvas.height / 4) * 3, 10, true);
    drawCircle(ctx, (canvas.width / 4) * 3, (canvas.height / 4), 10, true);
}

function face5(ctx) {
    ctx.fillStyle = '#d7bebe';
    drawCircle(ctx, canvas.width / 4, canvas.height / 4, 10, true);
    drawCircle(ctx, (canvas.width / 4) * 3, (canvas.height / 4) * 3, 10, true);
    drawCircle(ctx, canvas.width / 4, (canvas.height / 4) * 3, 10, true);
    drawCircle(ctx, (canvas.width / 4) * 3, (canvas.height / 4), 10, true);
    drawCircle(ctx, canvas.width / 2, canvas.height / 2, 10, true);
}

function face6(ctx) {
    ctx.fillStyle = '#d7bebe';
    drawCircle(ctx, canvas.width / 4, canvas.height / 4, 10, true);
    drawCircle(ctx, (canvas.width / 4) * 3, (canvas.height / 4) * 3, 10, true);
    drawCircle(ctx, canvas.width / 4, (canvas.height / 4) * 3, 10, true);
    drawCircle(ctx, (canvas.width / 4) * 3, (canvas.height / 4), 10, true);
    drawCircle(ctx, canvas.width / 4, canvas.height / 2, 10, true);
    drawCircle(ctx, (canvas.width / 4) * 3, canvas.height / 2, 10, true);

}


function drawCircle(ctx, x, y, radius, fill, stroke, strokeWidth) {
    ctx.beginPath()
    ctx.arc(x, y, radius, 0, 2 * Math.PI, false)
    if (fill) {
        ctx.fillStyle = fill
        ctx.fill()
    }
    if (stroke) {
        ctx.lineWidth = strokeWidth
        ctx.strokeStyle = stroke
        ctx.stroke()
    }
}
