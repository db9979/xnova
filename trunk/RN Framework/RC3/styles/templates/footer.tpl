<script>
messageboxHeight=0;
errorboxHeight=0;
contentbox = document.getElementById('content');
</script>

<div id='messagebox'>
<center>
</center>
</div>
<div id='errorbox'>
<center>
</center>
</div>

<script>
headerHeight = 0;
document.getElementById('errorbox').style.top=parseInt(headerHeight+document.getElementById('errorbox').offsetHeight+5)+'px';
document.getElementById('content').style.top=parseInt(headerHeight+document.getElementById('errorbox').offsetHeight+document.getElementById('errorbox').offsetHeight+10)+'px';
if (navigator.appName=='Netscape'){if (window.innerWidth<1020){document.body.scroll='no';}   document.getElementById('content').style.height=parseInt(window.innerHeight)-document.getElementById('errorbox').offsetHeight-document.getElementById('errorbox').offsetHeight-headerHeight-20;
if(document.getElementById('resources')) {   document.getElementById('resources').style.width=(window.innerWidth*0.4);}}
 else {
if (document.body.offsetWidth<1020){document.body.scroll='no';}   document.getElementById('content').style.height=parseInt(document.body.offsetHeight)-document.getElementById('errorbox').offsetHeight-headerHeight-document.getElementById('errorbox').offsetHeight-20;document.getElementById('resources').style.width=(document.body.offsetWidth*0.4);
}for (var i = 0; i < document.links.length; ++i) {
  if (document.links[i].href.search(/.*redir\.php\?url=.*/) != -1) {
    document.links[i].target = "_blank";
  }
}

</script>
</body>
<html>