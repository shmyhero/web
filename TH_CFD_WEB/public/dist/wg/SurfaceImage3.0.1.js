/**
 * Created by Tony.Tan on 2014-08-19.
 */
function CreatSurface() {
    var Surface = {
        width: 562,
        height: 381,
        url: "",
        start_x: 0,
        start_y: 0,
        pos_x: 0,
        pos_y: 0,
        dx: 0,
        dy: 0,
        dlx: 0,
        dly: 0,
        clientX: 0,
        clientY: 0,
        image_w: 0,
        image_h: 0,
        Scale: 1,
        Last_Scale: 1,
        Rotate: 0,
        Last_Rotate: 0,
        exif_error: false,
        isScale: false,
        drag: true,
        mini_mirrorSurface: "",
        drawSurface: "",
        copySurface: "",
        shadeSurface: "",
        actualSurface:"",
        viewSurface:"",
        image_hat: "",
        image_lable: "",
        transX: 0,
        transY: 0,
        status:false,
        controlButton: {
            scaleAdd: "",
            scaleLess: "",
            rotateAdd: "",
            rotateLess:""
        },
        saveImage: "",
        logo: "",
        sface:"",
        init: function () {
            //拖动头像层
            Surface.canvas = document.getElementById(this.drawSurface);
            Surface.context = Surface.canvas.getContext('2d');

            //用于中转图片
            Surface.c_canvas = document.getElementById(this.copySurface);
            Surface.c_context = Surface.c_canvas.getContext('2d');

            Surface.canvas.width = this.width;
            Surface.canvas.height = this.height;

        },
        setTemplete: function () {

            //Surface.hatContext.clearRect(0, 0, Surface.width, Surface.height);
            Surface.v_context.clearRect(0, 0, Surface.width, Surface.height);

            Surface.hatContext.clearRect(0, 0, Surface.width, Surface.height);

            var image_h = new Image();
            image_h.src = Surface.image_hat;// tm.data[0].hat[0];
            image_h.onload = function () {
                Surface.hatContext.drawImage(image_h, 0, 0, Surface.width, Surface.height);

                Surface.v_context.drawImage(Surface.hatCanvas, 0, 0);
                Surface.v_context.drawImage(Surface.shadowCanvas, 0, 0);

            };
        },
        drawInitImage: function (url) {
            // alert(123);
            //console.log("drawInitImage");
            Surface.context.clearRect(0, 0, Surface.width, Surface.height);
            var image_d = new Image();
            if (url != null && url.length > 0)
                this.url = url;

            image_d.src = this.url;
            image_d.onload = function () {

                var temp_canvas = document.createElement('canvas');
                var temp_ctx = temp_canvas.getContext('2d');

                var factor = 0;
                var tempw = temph = 0;
                if (image_d.width > image_d.height) {
                    factor = image_d.height / Surface.canvas.height;
                    tempw = image_d.width / factor;
                    temph = Surface.canvas.height;
                }
                else {
                    factor = image_d.width / Surface.canvas.width;
                    tempw = Surface.canvas.width;
                    temph = image_d.height / factor;
                }


                Surface.c_canvas.width = temp_canvas.width = tempw;
                Surface.c_canvas.height = temp_canvas.height = temph; //2448/3264

                //alert(Surface.c_canvas.width);

                drawImageIOSFix(temp_ctx, image_d, 0, 0, image_d.width, image_d.height, 0, 0, tempw, temph);

                var temp_o = 0;
                if (Surface.exif_error == false) {
                    if (Surface.TagO != null && !!Surface.TagO['Orientation'])
                        temp_o = orientation(Surface.TagO['Orientation'].description);
                }

                transformCoordinate(Surface.c_canvas, Surface.c_canvas.width, Surface.c_canvas.height, temp_o);
                Surface.c_context.drawImage(temp_canvas, 0, 0);

                if (Surface.c_canvas.width > Surface.c_canvas.height) {
                    factor = Surface.c_canvas.height / Surface.canvas.height;
                    Surface.image_w = Surface.c_canvas.width / factor;
                    Surface.image_h = Surface.canvas.height;
                }
                else {
                    factor = Surface.c_canvas.width / Surface.canvas.width;
                    Surface.image_w = Surface.canvas.width;
                    Surface.image_h = Surface.c_canvas.height / factor;
                }

                Surface.context.drawImage(Surface.c_canvas, 0, 0, Surface.image_w, Surface.image_h);
                //Surface.v_context.drawImage(Surface.hatCanvas, 0, 0);
                //Surface.v_context.drawImage(Surface.shadowCanvas, 0, 0);


            }
        },
        dragImage: function () {

            //重置设置
            this.reset();


            var tempx = 0; // : dx + pos_x ;
            var tempy = 0; // : dx + pos_x ;

            var hammertime = Hammer(document.getElementById(this.shadeSurface), {
                transform_always_block: true,
                transform_min_scale: 1,
                drag_block_horizontal: true,
                drag_block_vertical: true,
                drag_min_distance: 0
            });

            hammertime.on('dragstart touch drag dragend transform transformstart transformend ', function (ev) {

                switch (ev.type) {
                    case 'dragstart':
                        break;
                    case 'touch':
                        Surface.drag = true;
                        Surface.Last_Rotate = Surface.Rotate;
                        Surface.Last_Scale = Surface.Scale;
                        break;
                    case 'drag':
                        if (Surface.drag == true) {
                            tempx = ev.gesture.deltaX + Surface.pos_x;
                            tempy = ev.gesture.deltaY + Surface.pos_y;
                        }
                        break;
                    case 'dragend':
                        Surface.pos_x = tempx;
                        Surface.pos_y = tempy;
                        break;
                    case 'transformstart':
                        Surface.drag = false;
                        break;
                    case 'transform':
                        Surface.Rotate = Surface.Last_Rotate + ev.gesture.rotation;
                        Surface.Scale = Math.max(0.2, Math.min(Surface.Last_Scale * ev.gesture.scale, 10));
                        break;
                    case 'transformend':
                        //Surface.drag = true;;
                        break;
                }


                Surface.drawImage(tempx, tempy);

            });
        },
        drawImage: function (tempx, tempy) {
            Surface.transX = tempx + Surface.canvas.width / 2;
            Surface.transY = tempy + Surface.canvas.height / 2;
            Surface.context.clearRect(0, 0, Surface.width, Surface.height);
            Surface.canvas.style.display = 'none';
            Surface.canvas.offsetHeight;
            Surface.canvas.style.display = 'inherit';

            Surface.context.save();
            Surface.context.translate(Surface.transX, Surface.transY);
            Surface.context.scale(Surface.Scale, Surface.Scale);
            Surface.context.rotate(Surface.Rotate * Math.PI / 180);
            Surface.context.translate(-(Surface.canvas.width / 2), -(Surface.canvas.height / 2));
            Surface.context.drawImage(Surface.c_canvas, 0, 0, Surface.image_w, Surface.image_h);
            Surface.context.restore();
        },
        drawMask: function (ctx) {

            var compute = ctx.getImageData(0, 0, Surface.width, Surface.width);

            ctx.drawImage(Surface.maskCanvas, 0, 0, Surface.width, Surface.height);

            var imgPixels = ctx.getImageData(0, 0, Surface.width, Surface.height);
            for (var y = 0; y < imgPixels.height; y++) {
                for (var x = 0; x < imgPixels.width; x++) {
                    var i = (y * 4) * imgPixels.width + x * 4;
                    var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
                    //r0g1b2a3
                    compute.data[i + 3] *= avg / 255;
                }
            }
            ctx.putImageData(compute, 0, 0);

        },
        reset: function () {
            //恢复默认设置
            this.transX = this.transY = 0;
            this.Scale = 1;
            this.Last_Scale = 1;
            this.Rotate = 0;
            this.Last_Rotate = 0;
            this.pos_x = 0;
            this.pos_y = 0;
        },
        toImage: function () {
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            canvas.width = 320;
            canvas.height = 240;
            ctx.drawImage(Surface.canvas, 0, 0, 320, 240);
            var Pic = canvas.toDataURL('image/png').replace('data:image/png;base64,', '');
            return Pic;

        },
        drawSmaillFace: function (url) {
            //Surface.sface = url;
            var imgFace = new Image();
            imgFace.src = url;//"../images/hat/big_face_cur.png"
            imgFace.onload = function () {
                Surface.cmm_context.drawImage(imgFace, 0, 0, 100, 100);
                Surface.cmm_context.drawImage(Surface.hatCanvas, 0, 0, 100, 100);
            }
        }
    }

    return Surface;
}

//left-bottom 8 right-top 5 bottom-right 3
function orientation(orientation) {
    var o = 0;

    switch (orientation) {
        case "left-bottom":
            o = 8;
            break;
        case "right-top":
            o = 5;
            break;
        case "bottom-right":
            o = 3;
            break;
        default:
            o = 0;
    }

    return o;
}


function transformCoordinate(canvas, width, height, orientation) {
    switch (orientation) {
        case 5:
            canvas.width = height;
            canvas.height = width;
            break;
        case 8:
            canvas.width = height;
            canvas.height = width;
            break;
        default:
            canvas.width = width;
            canvas.height = height;
    }
    var ctx = canvas.getContext('2d');
    switch (orientation) {
        case 3:
            // 180 rotate left
            ctx.translate(width, height);
            ctx.rotate(Math.PI);
            break;
        case 5:
            // vertical flip + 90 rotate right right-top
//            ctx.rotate(0.5 * Math.PI);
            //            ctx.scale(1, -1);
            ctx.rotate(0.5 * Math.PI);
            ctx.translate(0, -height);
            break;
            break;
        case 8:
            // 90 rotate left
            ctx.rotate(-0.5 * Math.PI);
            ctx.translate(-width, 0);
            break;
        default:
            break;
    }
}


function detectVerticalSquash(img) {
    var iw = img.naturalWidth, ih = img.naturalHeight;
    var canvas = document.createElement('canvas');
    canvas.width = 1;
    canvas.height = ih;
    var ctx = canvas.getContext('2d');
    ctx.drawImage(img, 0, 0);
    var data = ctx.getImageData(0, 0, 1, ih).data;
    // search image edge pixel position in case it is squashed vertically.
    var sy = 0;
    var ey = ih;
    var py = ih;
    while (py > sy) {
        var alpha = data[(py - 1) * 4 + 3];
        if (alpha === 0) {
            ey = py;
        } else {
            sy = py;
        }
        py = (ey + sy) >> 1;
    }
    var ratio = (py / ih);
    return (ratio === 0) ? 1 : ratio;
}

function drawImageIOSFix(ctx, img, sx, sy, sw, sh, dx, dy, dw, dh) {
    var vertSquashRatio = detectVerticalSquash(img);
    // Works only if whole image is displayed:
    // ctx.drawImage(img, sx, sy, sw, sh, dx, dy, dw, dh / vertSquashRatio);
    // The following works correct also when only a part of the image is displayed:
    ctx.drawImage(img, sx * vertSquashRatio, sy * vertSquashRatio,
            sw * vertSquashRatio, sh * vertSquashRatio,
        dx, dy, dw, dh);
}


