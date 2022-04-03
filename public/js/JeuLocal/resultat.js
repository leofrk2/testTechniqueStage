window.onload = function() {
    afficheResultat();
}

function afficheResultat(){
    const canvas = document.querySelector('#canvas');
    const canvas2 = document.querySelector('#canvas2');

    if (!canvas.getContext) {
        return;
    }
    if(!canvas2.getContext) {
        return;
    }
    const ctx = canvas.getContext('2d');
    const ctx2 = canvas2.getContext('2d');
    ctx.fillStyle = '#d74242';
    ctx2.fillStyle = '#d74242';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx2.fillRect(0, 0, canvas2.width, canvas2.height);
    switch(resultat1){
        case 1 : face1(ctx);
            break;
        case 2 : face2(ctx);
            break;
        case 3 : face3(ctx);
            break;
        case 4 : face4(ctx);
            break;
        case 5 : face5(ctx);
            break;
        case 6 : face6(ctx);
            break;
        default:
            break;
    }

    switch(resultat2){
        case 1 : face1(ctx2);
            break;
        case 2 : face2(ctx2);
            break;
        case 3 : face3(ctx2);
            break;
        case 4 : face4(ctx2);
            break;
        case 5 : face5(ctx2);
            break;
        case 6 : face6(ctx2);
            break;
        default:
            break;
    }

}
