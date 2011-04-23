

var FadeIn_FadeInterval;

window.onload = FadeIn_FadeRotate

var FadeIn_Links;
var FadeIn_Titles;
var FadeIn_Cursor = 0;
var FadeIn_Max;


function FadeIn_FadeRotate() 
{
  FadeIn_FadeInterval = setInterval(FadeIn_Ontimer, 10);
  FadeIn_Links = new Array();
  FadeIn_Titles = new Array();
  FadeIn_SetFadeLinks();
  FadeIn_Max = FadeIn_Links.length-1;
  FadeIn_SetFadeLink();
}

function FadeIn_SetFadeLink() {
  var ilink = document.getElementById("FadeIn_Link");
  ilink.innerHTML = FadeIn_Titles[FadeIn_Cursor];
  ilink.href = FadeIn_Links[FadeIn_Cursor];
}

function FadeIn_Ontimer() {
  if (FadeIn_bFadeOutt) {
    FadeIn_Fade+=FadeIn_FadeStep;
    if (FadeIn_Fade>FadeIn_FadeOut) {
      FadeIn_Cursor++;
      if (FadeIn_Cursor>FadeIn_Max)
        FadeIn_Cursor=0;
      FadeIn_SetFadeLink();
      FadeIn_bFadeOutt = false;
    }
  } else {
    FadeIn_Fade-=FadeIn_FadeStep;
    if (FadeIn_Fade<FadeIn_FadeIn) {
      clearInterval(FadeIn_FadeInterval);
      setTimeout(Faderesume, FadeIn_FadeWait);
      FadeIn_bFadeOutt=true;
    }
  }
  var ilink = document.getElementById("FadeIn_Link");
  if ((FadeIn_Fade<FadeIn_FadeOut)&&(FadeIn_Fade>FadeIn_FadeIn))
    ilink.style.color = "#" + ToHex(FadeIn_Fade);
}

function Faderesume() {
  FadeIn_FadeInterval = setInterval(FadeIn_Ontimer, 10);
}

function ToHex(strValue) {
  try {
    var result= (parseInt(strValue).toString(16));

    while (result.length !=2)
            result= ("0" +result);
    result = result + result + result;
	//alert(result);
    return result.toUpperCase();
  }
  catch(e)
  {
  }
}