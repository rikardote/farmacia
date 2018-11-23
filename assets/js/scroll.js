var tWidth = '900px'; // width (in pixels)
var tHeight = '60px'; // height (in pixels)
var tcolour = '#ffffcc'; // background colour:
var moStop = true; // pause on mouseover (true or false)
var fontfamily = 'arial,sans-serif'; // font for content
var tSpeed = 3; // scroll speed (1 = slow, 5 = fast)
// enter your ticker content here (use \/ and \' in place of / and ' respectively)
var content = 'ALPRAZOLAM, ENALAPRIL, RIVOTRIL';

var cps = -tSpeed;
var aw, mq;
var fsz = parseInt(tHeight) - 4;

function scrollticker() {
    mq.style.left = (parseInt(mq.style.left) > (-10 - aw)) ? mq.style.left = parseInt(mq.style.left) + cps + "px" : parseInt(tWidth) + 10 + "px";
}

function startticker() {
    if (document.getElementById) {
        var tick = '<div style="position:relative;width:' + tWidth + ';height:' + tHeight + ';overflow:hidden;background-color:' + tcolour + '"';
        if (moStop) tick += ' onmouseover="cps=0" onmouseout="cps=-tSpeed"';
        tick += '><div id="mq" style="position:absolute;right:0px;top:0px;font-family:' + fontfamily + ';font-size:' + fsz + 'px;white-space:nowrap;"><\/div><\/div>';
        document.getElementById('ticker').innerHTML = tick;
        mq = document.getElementById("mq");
        mq.style.left = (10 + parseInt(tWidth)) + "px";
        mq.innerHTML = '<span id="tx">' + content + '<\/span>';
        aw = document.getElementById("tx").offsetWidth;
        lefttime = setInterval(scrollticker, 50);
    }
}
startticker();
window.onload = startticker;