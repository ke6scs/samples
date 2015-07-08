
var uid = 0;
var uidx = 0;

var cx = -1;
var cy = 0;
var ctp = 0;
var cz = 0;
var nx = 0;
var ny = 0;
var gfl = 0;
var grid = new Array(10);
var pclm = new Array(10);

var dclick = 0;
var stm = 0;
var strx = 0;
var pnm = 0;
var pul = 0;

var hiscore = 0;
var lscore = 0;

var msudoku_friends = new Array();
var msudoku_friend_start = 0;
var msudoku_appusers = "";

//tsta = new Array();

function sdk_init()
{
    for( z = 0; z < 9; z++ )
    {
        grid[z] = new Array(10);
//        tsta[z] = new Array(10);
        pclm[z] = new Array(10);
        for( q = 0; q < 9; q++ )
        {
            pclm[z][q] = new Array();
            var idx = "r" + q + "c" + z;
            gq = document.getElementById(idx).innerHTML;
            if(isNaN(gq) || gq == "&nbsp;" || gq == "" || escape(gq) == "%A0"){
                gq = "0";
            }
            grid[z][q] = parseInt(gq);
//            tsta[z][q] = gq;
        }
    }
}

function sdk_start()
{
    sdk_init();
    dclick = 0;
    strx = -1;
    var cdt = new Date();
    stm = cdt.getTime();
    msudoku_myTick();
}
function iepu(obj)
{
    var idt = obj.id;
    ix = parseInt(idt.substr(3,1));
    iy = parseInt(idt.substr(1,1));
    pu(ix,iy);
}

function pu(x,y)
{
    if( dclick == 0 )
    {
        if (typeof(pclm[x][y]) != 'object' || pclm[x][y].length == 0) {
            for (iqx = 0;iqx < 9; iqx++){
                pclm[x][y][iqx] = 0;
            }
        }
        msudoku_closePopup();
        var ob = "r" + y + "c" + x;
        cx = x;
        cy = y;
//        ctp = 0;
        popup(ob, (ctp == 1) ? '#9999FF' : '#99FF99');
    }
}

function pupcl(x,y,z)
{
    if( dclick == 0 )
    {
//        alert(x + "," + y + "," + z);
        var ob = "r" + y + "c" + x + "i" + z;
        cx = x;
        cy = y;
        cz = z;
        ctp = 1;
        popup(ob, '#9999FF');
    }
}

function popup(onm,color)
{
    var cobj = document.getElementById(onm);
    var tobj = document.getElementById('t' + onm);
    var pobj = document.getElementById('puox');

    var curleft = curtop = 0;
    var obj = cobj;

    if (obj.offsetParent) {

        do {
                curleft += obj.offsetLeft;
                curtop += obj.offsetTop;

            } while (obj = obj.offsetParent);

        pobj.style.left = curleft + 55  ;
        pobj.style.top  = curtop  - 40 ;
        pobj.style.backgroundColor = color;
        tobj.style.backgroundColor = color;
        pobj.style.display = 'block';
        disableSelection(pobj);
        pul = 1;
    }
}

function puk(ev)
{
    if(pul == 1){
//        if(event){
//            kc = event.keyCode;
//            alert("event.keyCode: " + kc);
//        }
        if(ev){
            kc = ev.keyCode;
//            alert("ev.keyCode: " + kc);
        }
        var ex = 0;
        var xx = 0;
//        alert("puk");
        if(kc > 48 && kc < 58){
            cc = kc - 48;
            ex = 1;
        }
        if(kc > 96 && kc < 106){
            cc = kc - 96;
            ex = 1;
        }
        if(kc == 46 || kc == 110){
            cc = 0;
            ex = 1;
        }
        if(kc == 27){
            pul = 0;
			document.getElementById('puox').style.display = 'none';
		}
        if(ex == 1){
            puc(cc);
        }
    }
    return true;
}

function msudoku_closePopup() {
    if (cx > -1) {
        var onm = "tr" + cy + "c" + cx;
        document.getElementById(onm).style.backgroundColor = '';
    }
    document.getElementById('puox').style.display = 'none';
}

function puc(v)
{
    var onm = "r" + cy + "c" + cx;
	if (v == 'p') {
        ctp = 1- ctp;
        var bgc = (ctp == 1) ? '#9999FF' : '#99FF99';
		document.getElementById('puox').style.backgroundColor = bgc;
        document.getElementById('t' + onm).style.backgroundColor = bgc;
		return;
	}
	if (v == 'e') {
        msudoku_closePopup();
		return;
	}
    pul = 0;
    if ( dclick == 0 )
    {
        if ( ctp == 0 )
        {
            msudoku_closePopup();
            grid[cx][cy] = v;
            var cobj = document.getElementById(onm);
            var vt = v;
            if(v == 0){
                vt = '&nbsp;';
            }
            cobj.innerHTML = vt;
            showPcl(cx,cy);
            if(checkGrid()){
                dclick = 1;
                var cdt = new Date();
                fscore = Math.floor((cdt.getTime() - stm)/1000);
                getXHR('req=asc&uid=' + uid + '&scr=' + fscore + '&puz=' + pnm,false);
                lscore = fscore;
                document.getElementById("msudoku_btn_reset").disabled = true;

                document.getElementById("msudoku_r_container").innerHTML = '<center><br /><h1>Puzzle Complete<br /><br />Try Again?</h1><br /><button onClick="msudoku_reset();">Yes</button> <button onClick="msudoku_close_dialog();">No</button></center>';
                document.getElementById("msudoku_results").style.display = "block";

                if(fscore < hiscore){
                    hiscore = fscore;

                    var obj = {'method':'feed',
                                    'name':fname + ' got a personal best time of ' + format_time(fscore) + ' in Master Sudoku.',
                                    'picture':'http://msudoku.curtiscomp.com/img/btm.gif',
                                    'link':'http://apps.facebook.com/mastersudoku/',
                                    'caption':'Tell your friends about your best time!'
                              };
                    FB.ui(obj);
                    msudoku_friends[uidx]['hiscore'] = fscore;

                }
                msudoku_show_friends();
            }
            if (v > 0) {
				for(z in pclm[cx][cy])
				{
					document.getElementById(onm + 'i' + z).style.display = 'none';
				}
			}
        }
        if( ctp == 1 )
        {
            if(v == 0){
				for(i=0;i<9;i++){
                	pclm[cx][cy][i] = 0;
				}
            }else{
                pclm[cx][cy][v-1] = v - pclm[cx][cy][v-1];
            }
            showPcl(cx,cy);
        }
    }
}



function checkGrid()
{
    var ch = new Array(10);
    for( z = 0; z < 9; z++ )
    {
        ch[z] = new Array(10);
    }
    var ck = new Array();
    for( y = 0; y < 9; y++ )
    {
        for( x = 0; x < 9; x++ )
        {
            var idx = "r" + y + "c" + x;
            chq = document.getElementById(idx).innerHTML;
            if(isNaN(chq)){
                return false;
            }
            ch[x][y] = parseInt(chq);
        }
    }
//  alert('filled');
    for( y = 0; y < 9; y++ )
    {
        for( z = 1; z < 10; z++ )
        {
            ck[z] = 0;
        }
        for( x = 0; x < 9; x++ )
        {
            cnm = ch[x][y];
            if(ck[cnm] > 0){ return false; }
            ck[cnm] = 1;
        }
    }
//  alert('rows checked');
    for( x = 0; x < 9; x++ )
    {
        for( z = 1; z < 10; z++ )
        {
            ck[z] = 0;
        }
        for( y = 0; y < 9; y++ )
        {
            cnm = ch[x][y];
            if(ck[cnm] > 0){ return false; }
            ck[cnm] = 1;
        }
    }
//  alert('columns checked');
    for( a = 0; a < 9; a++ )
    {
        ax = (a % 3) * 3;
        ay = Math.floor(a / 3) * 3;
//      alert("checking block " + a + " at " + ax + "," + ay);
        for( z = 1; z < 10; z++ )
        {
            ck[z] = 0;
        }
        for( b = 0; b < 9; b++ )
        {
            bx = (b % 3) + ax;
            by = Math.floor(b / 3) + ay;
//          alert("checking " + a + "," + b + " at " + bx + "," + by);
            cnm = ch[bx][by];
//          alert("Retrieved " + cnm + " logic: " + ck[cnm]);
            if(ck[cnm] > 0){ return false; }
            ck[cnm] = 1;
        }
    }
    return true;
}

function showPcl(px,py)
{
    cpcl = pclm[px][py];
//    document.getElementById('tst').value = px + ',' + py + ":" + grid[px][py] + ',' + escape(tsta[px][py]);
    if(grid[px][py] == 0){
        hivl = 15;
        vivl = 15;
        if(isIE){
            hoff = 4;
            voff = 4;
        }else{
            hoff = 2;
            voff = 2;
        }
        bsx = bsy = 0;
        bobj = document.getElementById('r' + py + 'c' + px);
        do {
                bsx += bobj.offsetLeft;
                bsy += bobj.offsetTop;

            } while (bobj = bobj.offsetParent);
        bsy -= 3;
        for(z in cpcl)
        {
			cqt = cpcl[z];
            ct = z;
            idx = 'r' + py + 'c' + px + 'i' + z;
            cobj = document.getElementById(idx);
            cobj.className = 'p0';
            var lft = (bsx + ((ct % 3) * hivl) + hoff) + 'px';
            var tp =  (bsy + (Math.floor(ct / 3) * vivl) + voff) + 'px';
            cobj.style.left = lft;
            cobj.style.top = tp;
            if (cqt == 0) {
                cobj.style.display = 'none';
            } else {
                cobj.innerHTML = cqt;
                cobj.style.display = 'inline';
            }
            disableSelection(cobj);
        }
    }
}

function msudoku_myTick()
{
    var cdt = new Date();
    var dtm = (cdt.getTime()-stm);
    var ctm = Math.floor(dtm/1000);
    if(ctm == strx){
    }else{
        strx = ctm;
        if(dclick == 0) msudoku_showTime(ctm);
    }
    if(dclick == 0) setTimeout('msudoku_myTick()',200);
}

function msudoku_showTime(shtm)
{
    ttsh = format_time(shtm);
    document.getElementById("msudoku_timer").innerHTML = ttsh;
}

var isIE = false;
var isNS = false;
var browserVersion = "";

function getBrowser()
{
    ua = navigator.userAgent;
    s = "MSIE";
    if ((i = ua.indexOf(s)) >= 0) {
        isIE = true;
        browserVersion = parseFloat(ua.substr(i + s.length));
        return;
    }
    s = "Netscape6/";
    if ((i = ua.indexOf(s)) >= 0) {
        isNS = true;
        browserVersion = parseFloat(ua.substr(i + s.length));
        return;
    }
    s = "Gecko";
    if ((i = ua.indexOf(s)) >= 0) {
        this.isNS = true;
        this.version = 6.1;
        return;
    }
}

getBrowser();

function set_grid(txt)
{
    getXHR('req=ghs&uids=' + msudoku_appusers + ',' + uid,'set_hi_scores');
//    alert('ajax grid: ' + txt);

//if(isIE){ alert("IE detected"); }


    txa  = txt.split('|');
    pdat = txa[1];
    pnm  = txa[0];
    var gct=0;
    if(pdat === undefined){
//        alert('ajax grid: ' + txt);
    }

//    document.getElementById('tst').value = txt;
    for(gy = 0; gy < 9; gy++)
    {
        for(gx = 0; gx < 9; gx++)
        {
            var ch = parseInt(pdat.substr(gct,1));
            var cobj = document.getElementById('r' + gy + 'c' + gx);
            var tobj = document.getElementById('tr' + gy + 'c' + gx);
            if(ch > 0)
            {
                cobj.innerHTML = ch;
                tobj.style.backgroundColor = '#EEEEEE';
                if(isIE){
                    cobj.onclick = function(){};
                }else{
                    cobj.setAttribute("onClick","");
                }
            }else{
                cobj.innerHTML = '&nbsp;';
                tobj.style.backgroundColor = '#FFFFFF';
                if(isIE){
                    cobj.onclick = function(){iepu(this);};
                }else{
                    cobj.setAttribute('onClick','pu(' + gx + ',' + gy + ');');
                }
            }
			for(i=0;i<9;i++){
				pclm[gx][gy][i] = 0;
			}

            disableSelection(cobj);
//            showPcl(gx,gy);
            gct++;
        }
    }
    sdk_start();
//    document.getElementById("msudoku_dflA").innerHTML = "X";
}


function set_hi_scores(txt)
{
    getXHR('req=gls&uids=' + uid,'set_last_score');
//    alert("hi score data: " + txt);
    txa = txt.split('|');
    var hsc = new Array();
    for (idx in txa){
        pra = txa[idx].split(',');
        id = pra[0];
        sc = pra[1];
        hsc[id] = sc;
    }
    for (idx in msudoku_friends){
        msudoku_friends[idx]['hiscore'] = hsc[msudoku_friends[idx]['uid']];
    }
    hiscore = hsc[uid];
    msudoku_show_friends();
//    document.getElementById("msudoku_dflB").innerHTML = "X";
}

function set_last_score(txt)
{
    txa = txt.split('|');
    var lsc = new Array();
    for (idx in txa){
        pra = txa[idx].split(',');
        id = pra[0];
        sc = pra[1];
        lsc[id] = sc;
    }
    lscore = lsc[uid];
    msudoku_show_friends();
//    document.getElementById("msudoku_dflC").innerHTML = "X";
}

var api_key = 'a119a05d0239f15bf8ca03aaf4897c05';
var channel_path = '/xd_receiver.htm';

//var msudoku_session;

window.fbAsyncInit = function() {
    // init the FB JS SDK
    FB.init({
      appId      : '10150153407000223', // App ID from the App Dashboard
      channelUrl : '//www.curtiscomp.com/msudoku/channel.html', // Channel File for x-domain communication
      status     : true, // check the login status upon init?
      cookie     : true, // set sessions cookies to allow your server to access the session?
      xfbml      : true  // parse XFBML tags on this page?
    });
    sdk_init();

    // require user to login
    FB.getLoginStatus(function(response) {
//            msudoku_session = response.session;
//            uid = msudoku_session['uid'];
        if (!(response.status === 'connected' && response.authResponse)) {
            if (response.status === 'not_authorized') {
                document.getElementById("msudoku_btn_reset").disabled = true;

                document.getElementById("msudoku_r_container").innerHTML = '<center><br /><h1>Welcome to Master Sudoku</h1><br /><br /><button onClick="msudoku_startAuth();">Play</button></center>';
                document.getElementById("msudoku_results").style.display = "block";
            } else {
                alert('You must be logged in to play this game.');
            }
        } else {
            uid = response.authResponse.userID;
            msudoku_startGame();
        }
    });
}

function msudoku_startAuth() {
    FB.login(function(response){
        if (response.authResponse) {
            uid = response.authResponse.userID;
            msudoku_startGame();
        }
    });
}

function msudoku_startGame() {
    // Get friends list
    getXHR('req=gls&uids=' + uid,'set_last_score');
//            msudoku_showGAS();
    FB.api( {
            method: 'friends.getAppUsers'
        },
        function(result, exception){
            msudoku_appusers = result + ',' + uid;
            if(result == ""){
                msudoku_appusers = uid;
            }
            rr = true;
            FB.api( {
                    method: 'users.getInfo',
                    uids: msudoku_appusers,
                    fields: 'uid,first_name,pic_square,profile_url'
                },
                function(res_obj, exception){
                    msudoku_friends = res_obj;
                    msudoku_reset();
                    fr = true;
                });
        });
}


function msudoku_reset()
{
//            alert("uid: " + uid);
    dclick = 1;
    clearPcl();
    cx = -1;
    msudoku_close_dialog();
//alert("Resetting game");
    msudoku_closePopup();
    document.getElementById("msudoku_timer").innerHTML = "&nbsp;";
//    document.getElementById("msudoku_dflA").innerHTML = "0";
//    document.getElementById("msudoku_dflB").innerHTML = "0";
//    document.getElementById("msudoku_dflC").innerHTML = "0";
    getXHR('req=ggd&uid=' + uid,'set_grid');
}

function func_null(){
    return;
}

function msudoku_show_friends()
{
    msudoku_friends.sort(hiscore_sortcomp);
    list_length = 5;
    for (idx in msudoku_friends){
        if(msudoku_friends[idx]['uid'] == uid){
            fname = msudoku_friends[idx]['first_name'];
            uidx = idx;
        }
    }
    var msudoku_friend_html = '';
    var f_end = msudoku_friend_start + list_length;
    if(msudoku_friend_start > 0){
        msudoku_friend_html = '<div class="scr"><img src="img/la.gif"></div>';
    }
    ct = 0;
    for(ix in msudoku_friends.slice(msudoku_friend_start,f_end)){
        friend_data = msudoku_friends[ix];
        var hs = friend_data['hiscore'];
        var fsc;
        if(hs === undefined){
            fsc = "No score";
        }else{
            fsc = format_time(hs);
        }
        msudoku_friend_html += '<div class="scr"><img src="'+friend_data['pic_square']+'" class="pic"><div class="frt">'+friend_data['first_name']+'<br />'+fsc+'</div></div>';
//        alert("Hi Score: " + friend_data['hiscore']);
        ct++;
    }
    for(ix=ct;ix<list_length;ix++){
        msudoku_friend_html += '<div class="scr"><img src="img/q_silhouette.gif" class="pic"></div>';
    }
    if(msudoku_friend_start < msudoku_friends.count - list_length){
        msudoku_friend_html = '<div class="scr"><img src="img/da.gif"></div>';
    }
    document.getElementById("msudoku_friend_div").innerHTML = msudoku_friend_html;
//    document.getElementById("msudoku_friend_div").style.background = "#666600";
    score_html = '';
    if(lscore > 0){
        score_html += '<span style="text-align:center; font-size:16px;">Last Time: ' + format_time(lscore) + '</span><br />';
    }
    if(hiscore > 0){
        score_html += '<span style="text-align:center; font-size:16px;">Best Time: ' + format_time(hiscore) + '</span>';
    }
    document.getElementById("msudoku_score_div").innerHTML = score_html;
}

function format_time(tsec)
{
    sec = tsec % 60;
    tmin = Math.floor(tsec / 60);
    min = tmin % 60;
    hr = Math.floor(tmin / 60);
    tms = "";
    if(hr > 0){
        tms = hr + ":";
    }
    tms += double_digit(min) + ":" + double_digit(sec);
    return tms;
}

function double_digit(inp)
{
    o = inp % 10;
    t = Math.floor(inp / 10);
    return t + "" + o;
}

function digit_grouping(nStr){
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function hiscore_sortcomp(a, b)
{
    var rtn;
    if(a['hiscore'] === undefined){
        if(b['hiscore'] === undefined){
            rtn = 0;
        }else{
            rtn = 1;
        }
    }else{
        if(b['hiscore'] === undefined){
            rtn = -1;
        }else{
            rtn = a['hiscore'] - b['hiscore'];
        }
    }
    return rtn;
}

function clearPcl()
{
    for(x=0;x<9;x++)
    {
        for(y=0;y<9;y++)
        {
            for(i=0;i<9;i++)
            {
                idx = 'r' + y + 'c' + x + 'i' + i;
                ele = document.getElementById(idx);
                if(ele){ ele.style.display = 'none'; }
            }
        }
    }
}

function disableSelection(target){
    if (typeof target.onselectstart!="undefined") //IE route
    {
        target.onselectstart=function(){return false}
        return "IE";
    }
    else if (typeof target.style.MozUserSelect!="undefined") //Firefox route
    {
        target.style.MozUserSelect="none"
        return "Moz";
    }
    else //All other route (ie: Opera)
    {
        target.onmousedown=function(){return false}
        return "Other";
    }
  //  target.style.cursor = "default";
}

function msudoku_close_dialog()
{
    document.getElementById("msudoku_results").style.display = "none";
    document.getElementById("msudoku_btn_reset").disabled = false;
}

function msudoku_bookmark_callback()
{
    return true;
}

function msudoku_showGAS() {
//    var cr = '\n';
//    var adCode = '<script type="text/javascript"><!--' + cr +
//                 'google_ad_client = "pub-1135248087036728";' + cr +
//                 '/* Master Sudoku Leaderboard */' + cr +
//                 'google_ad_slot = "2200050702";' + cr +
//                 'google_ad_width = 728;' + cr +
//                 'google_ad_height = 90;' + cr +
//                 '//-->' + cr +
//                 '</script>';
//                 + cr +
//                 '<script type="text/javascript" src="//pagead2.googlesyndication.com/pagead/show_ads.js">' + cr +
//                 '</script>';
//    document.getElementById('lowerAd').innerHTML = adCode;
//    document.getElementById('upperAd').innerHTML = adCode;
//    setTimeout("msudoku_addGAStoDiv('lowerAd');",1000);
    msudoku_addGAStoDiv('upperAd');
}

function msudoku_addGAStoDiv(tDiv) {
//    document.domain = 'facebook.com';
    google_ad_client = "pub-1135248087036728";
    google_ad_slot = "2200050702";
    google_ad_width = 728;
    google_ad_height = 90;
    var target = document.getElementById(tDiv);
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = prot + '://pagead2.googlesyndication.com/pagead/show_ads.js';
    target.appendChild(script); 
}

var xmlhttp = [];
var XHRidx = 0;
var XHRcb = [];

function getXHR(query,callback)
{
    var cbidx = XHRidx++;
    if (window.ActiveXObject)   // ActiveX version
    {
        xmlhttp[cbidx] = new ActiveXObject("Msxml2.XMLHTTP");
    } else
    if (window.XMLHttpRequest)     // Object of the current windows
    {
        xmlhttp[cbidx] = new XMLHttpRequest();     // Firefox, Safari, ...
    } else return false;

    XHRcb[cbidx] = callback;
    xmlhttp[cbidx].onreadystatechange  = function() {XHRcallback(cbidx)};
    xmlhttp[cbidx].open('GET','ajax.php?' + query + '&r=' + Math.random(), true);
    xmlhttp[cbidx].send(null);
    return true;
}

function XHRcallback(cbi){
    var t = xmlhttp[cbi];
    if(t.readyState  == 4){
        cb = XHRcb[cbi];
        if (cb) {
            var r = xmlhttp[cbi].responseText;
            clearXHR(cbi);
            window[cb](r);
        } else {
            clearXHR(cbi);
        }
    }
}

function clearXHR(ix) {
    delete XHRcb[ix];
    delete xmlhttp[ix];
}

