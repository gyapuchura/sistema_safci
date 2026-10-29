/*
 * Quita el fondo (papel) de la foto de un sello y firma y deja solo la tinta.
 *
 * 1. Estima el color del papel zona por zona (corrige sombras y luz desigual).
 * 2. Mide la "fuerza de tinta" de cada pixel respecto al papel de su zona.
 * 3. Convierte esa fuerza en transparencia según el nivel de limpieza.
 * 4. Recupera el color real de la tinta en los bordes (sin halo grisáceo).
 * 5. Elimina puntos sueltos y restos del borde de la foto, y recorta al contenido.
 *
 * Uso:
 *   var prep = SelloSinFondo.preparar(imageData);   // una vez por foto
 *   prep.nivelAuto                                   // nivel sugerido (0-100)
 *   prep.fondoOscuro                                 // true si la foto no es sobre papel claro
 *   var res = SelloSinFondo.generar(prep, nivel);    // cada vez que cambia el nivel
 *   res.imageData (ya recortado) o null si no se detectó tinta
 */
(function (global) {

    function percentilHistograma(hist, total, p) {
        var limite = total * p, acum = 0;
        for (var v = 0; v < hist.length; v++) {
            acum += hist[v];
            if (acum >= limite) return v;
        }
        return hist.length - 1;
    }

    /* color del papel por bloques: promedio de los pixeles más claros de cada bloque */
    function estimarPapel(d, w, h) {
        var B = Math.max(8, Math.round(Math.max(w, h) / 48));
        var nx = Math.ceil(w / B), ny = Math.ceil(h / B);
        var bloques = new Float32Array(nx * ny * 3);
        var hist = new Uint32Array(256);

        for (var by = 0; by < ny; by++) {
            for (var bx = 0; bx < nx; bx++) {
                var x0 = bx * B, y0 = by * B;
                var x1 = Math.min(w, x0 + B), y1 = Math.min(h, y0 + B);
                hist.fill(0);
                var total = 0, x, y, p, l;
                for (y = y0; y < y1; y++) {
                    for (x = x0; x < x1; x++) {
                        p = (y * w + x) * 4;
                        l = (d[p] * 77 + d[p + 1] * 150 + d[p + 2] * 29) >> 8;
                        hist[l]++; total++;
                    }
                }
                var umbral = percentilHistograma(hist, total, 0.9);
                var sr = 0, sg = 0, sb = 0, n = 0;
                for (y = y0; y < y1; y++) {
                    for (x = x0; x < x1; x++) {
                        p = (y * w + x) * 4;
                        l = (d[p] * 77 + d[p + 1] * 150 + d[p + 2] * 29) >> 8;
                        if (l >= umbral) { sr += d[p]; sg += d[p + 1]; sb += d[p + 2]; n++; }
                    }
                }
                var k = (by * nx + bx) * 3;
                bloques[k] = sr / n; bloques[k + 1] = sg / n; bloques[k + 2] = sb / n;
            }
        }

        /* máximo con los vecinos: cubre bloques tapados por completo por tinta */
        var maximo = new Float32Array(bloques.length);
        for (by = 0; by < ny; by++) {
            for (bx = 0; bx < nx; bx++) {
                var mejor = -1, km = 0;
                for (var dy = -1; dy <= 1; dy++) {
                    for (var dx = -1; dx <= 1; dx++) {
                        var vx = bx + dx, vy = by + dy;
                        if (vx < 0 || vy < 0 || vx >= nx || vy >= ny) continue;
                        var kv = (vy * nx + vx) * 3;
                        var lv = bloques[kv] * 0.3 + bloques[kv + 1] * 0.59 + bloques[kv + 2] * 0.11;
                        if (lv > mejor) { mejor = lv; km = kv; }
                    }
                }
                var kd = (by * nx + bx) * 3;
                maximo[kd] = bloques[km]; maximo[kd + 1] = bloques[km + 1]; maximo[kd + 2] = bloques[km + 2];
            }
        }

        /* suavizado (promedio 3x3, dos pasadas) para que la luz cambie de forma gradual */
        var a = maximo, b = new Float32Array(maximo.length);
        for (var pasada = 0; pasada < 2; pasada++) {
            for (by = 0; by < ny; by++) {
                for (bx = 0; bx < nx; bx++) {
                    var s0 = 0, s1 = 0, s2 = 0, c = 0;
                    for (dy = -1; dy <= 1; dy++) {
                        for (dx = -1; dx <= 1; dx++) {
                            vx = bx + dx; vy = by + dy;
                            if (vx < 0 || vy < 0 || vx >= nx || vy >= ny) continue;
                            kv = (vy * nx + vx) * 3;
                            s0 += a[kv]; s1 += a[kv + 1]; s2 += a[kv + 2]; c++;
                        }
                    }
                    kd = (by * nx + bx) * 3;
                    b[kd] = s0 / c; b[kd + 1] = s1 / c; b[kd + 2] = s2 / c;
                }
            }
            var t = a; a = b; b = t;
        }

        return { malla: a, nx: nx, ny: ny, B: B };
    }

    /* color del papel en un pixel (interpolación bilineal entre centros de bloque) */
    function papelEn(papel, x, y, salida) {
        var fx = (x + 0.5) / papel.B - 0.5, fy = (y + 0.5) / papel.B - 0.5;
        var x0 = Math.max(0, Math.min(papel.nx - 1, Math.floor(fx)));
        var y0 = Math.max(0, Math.min(papel.ny - 1, Math.floor(fy)));
        var x1 = Math.min(papel.nx - 1, x0 + 1), y1 = Math.min(papel.ny - 1, y0 + 1);
        var tx = Math.max(0, Math.min(1, fx - x0)), ty = Math.max(0, Math.min(1, fy - y0));
        var m = papel.malla, nx = papel.nx;
        for (var c = 0; c < 3; c++) {
            var a = m[(y0 * nx + x0) * 3 + c], b = m[(y0 * nx + x1) * 3 + c];
            var e = m[(y1 * nx + x0) * 3 + c], f = m[(y1 * nx + x1) * 3 + c];
            salida[c] = (a * (1 - tx) + b * tx) * (1 - ty) + (e * (1 - tx) + f * tx) * ty;
        }
    }

    /* umbral de Otsu sobre el histograma de fuerza de tinta */
    function otsu(hist, total) {
        var suma = 0, i;
        for (i = 0; i < 256; i++) suma += i * hist[i];
        var sumaB = 0, wB = 0, mejor = 0, umbral = 0;
        for (i = 0; i < 256; i++) {
            wB += hist[i];
            if (wB === 0) continue;
            var wF = total - wB;
            if (wF === 0) break;
            sumaB += i * hist[i];
            var mB = sumaB / wB, mF = (suma - sumaB) / wF;
            var entre = wB * wF * (mB - mF) * (mB - mF);
            if (entre > mejor) { mejor = entre; umbral = i; }
        }
        return umbral;
    }

    function preparar(imageData) {
        var w = imageData.width, h = imageData.height, d = imageData.data;
        var papel = estimarPapel(d, w, h);
        var tinta = new Uint8Array(w * h);         // fuerza de tinta 0-255
        var normal = new Uint8ClampedArray(w * h * 3); // color relativo al papel (papel = blanco)
        var hist = new Uint32Array(256);
        var pc = [0, 0, 0];

        for (var y = 0; y < h; y++) {
            for (var x = 0; x < w; x++) {
                papelEn(papel, x, y, pc);
                var i = y * w + x, p = i * 4;
                var r = Math.min(1, d[p] / Math.max(pc[0], 1));
                var g = Math.min(1, d[p + 1] / Math.max(pc[1], 1));
                var b = Math.min(1, d[p + 2] / Math.max(pc[2], 1));
                var s = Math.round((1 - Math.min(r, g, b)) * 255);
                tinta[i] = s;
                normal[i * 3] = r * 255; normal[i * 3 + 1] = g * 255; normal[i * 3 + 2] = b * 255;
                hist[s]++;
            }
        }

        /* nivel sugerido: entre el ruido del papel y la tinta */
        var total = w * h;
        var ruido = percentilHistograma(hist, total, 0.5);
        var corte = otsu(hist, total);
        var inicio = Math.max(ruido + 12, Math.round(corte * 0.5));

        /* papel claro esperado; si el fondo es oscuro el resultado no será confiable */
        var hl = new Uint32Array(256), m = papel.malla;
        for (var k = 0; k < m.length; k += 3) hl[Math.round(m[k] * 0.3 + m[k + 1] * 0.59 + m[k + 2] * 0.11)]++;
        var luzPapel = percentilHistograma(hl, m.length / 3, 0.5);

        return {
            w: w, h: h, tinta: tinta, normal: normal,
            nivelAuto: Math.max(0, Math.min(100, Math.round(inicio / 255 / 0.6 * 100))),
            fondoOscuro: luzPapel < 110
        };
    }

    function generar(prep, nivel) {
        var w = prep.w, h = prep.h, n = w * h;
        var lo = nivel / 100 * 0.6 * 255;
        var hi = Math.min(250, lo * 1.8 + 20);
        var alfa = new Uint8Array(n);
        var i;

        for (i = 0; i < n; i++) {
            var s = prep.tinta[i];
            alfa[i] = s <= lo ? 0 : (s >= hi ? 255 : Math.round((s - lo) / (hi - lo) * 255));
        }

        /* componentes conectados: quitar puntos sueltos y restos pegados al borde de la foto */
        var etiqueta = new Int32Array(n), pila = new Int32Array(n);
        var minArea = Math.max(6, Math.round(n / 150000));
        var margen = Math.max(3, Math.round(Math.min(w, h) * 0.03));
        var minX = w, minY = h, maxX = -1, maxY = -1, actual = 0;

        for (i = 0; i < n; i++) {
            if (alfa[i] === 0 || etiqueta[i] !== 0) continue;
            actual++;
            var tope = 0, area = 0, enMargen = 0, peso = 0;
            var cx0 = w, cy0 = h, cx1 = -1, cy1 = -1;
            pila[tope++] = i; etiqueta[i] = actual;
            var miembros = [];
            while (tope > 0) {
                var q = pila[--tope];
                miembros.push(q);
                var qx = q % w, qy = (q - qx) / w;
                area++; peso += alfa[q];
                if (qx < margen || qy < margen || qx >= w - margen || qy >= h - margen) enMargen++;
                if (qx < cx0) cx0 = qx; if (qx > cx1) cx1 = qx;
                if (qy < cy0) cy0 = qy; if (qy > cy1) cy1 = qy;
                if (qx > 0 && alfa[q - 1] && !etiqueta[q - 1]) { etiqueta[q - 1] = actual; pila[tope++] = q - 1; }
                if (qx < w - 1 && alfa[q + 1] && !etiqueta[q + 1]) { etiqueta[q + 1] = actual; pila[tope++] = q + 1; }
                if (qy > 0 && alfa[q - w] && !etiqueta[q - w]) { etiqueta[q - w] = actual; pila[tope++] = q - w; }
                if (qy < h - 1 && alfa[q + w] && !etiqueta[q + w]) { etiqueta[q + w] = actual; pila[tope++] = q + w; }
            }
            var quitar = area < minArea || peso < minArea * 255 * 0.4 || enMargen > area * 0.6;
            if (quitar) {
                for (var j = 0; j < miembros.length; j++) alfa[miembros[j]] = 0;
            } else {
                if (cx0 < minX) minX = cx0; if (cx1 > maxX) maxX = cx1;
                if (cy0 < minY) minY = cy0; if (cy1 > maxY) maxY = cy1;
            }
        }

        if (maxX < 0) return null;

        /* recorte con un pequeño margen */
        var borde = 10;
        minX = Math.max(0, minX - borde); minY = Math.max(0, minY - borde);
        maxX = Math.min(w - 1, maxX + borde); maxY = Math.min(h - 1, maxY + borde);
        var cw = maxX - minX + 1, ch = maxY - minY + 1;
        var salida = new ImageData(cw, ch), o = salida.data;

        /* realce leve del color: al blanquear el papel la tinta también se aclara */
        var realce = new Uint8Array(256);
        for (i = 0; i < 256; i++) realce[i] = Math.round(Math.pow(i / 255, 1.5) * 255);

        for (var y = 0; y < ch; y++) {
            for (var x = 0; x < cw; x++) {
                i = (y + minY) * w + (x + minX);
                var a = alfa[i], p = (y * cw + x) * 4;
                if (a === 0) continue;
                /* color de la tinta sin la mezcla con el papel: c = (n - (1 - a)) / a */
                var fa = a / 255;
                for (var c = 0; c < 3; c++) {
                    var nc = prep.normal[i * 3 + c] / 255;
                    o[p + c] = realce[Math.round(Math.max(0, Math.min(1, (nc - (1 - fa)) / fa)) * 255)];
                }
                o[p + 3] = a;
            }
        }

        return { imageData: salida, x: minX, y: minY };
    }

    global.SelloSinFondo = { preparar: preparar, generar: generar };

})(window);
