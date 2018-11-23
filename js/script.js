window.addEventListener("load",init);

function init() {
    //loadJSON("themes.json",null,null);
    CKEDITOR.replace("idInhoud");
   
}

// Json laden en parsen
function loadJSON(path, success, error) {
    var request = new XMLHttpRequest();
    request.onreadystatechange = function()
    {
        if (request.readyState === XMLHttpRequest.DONE) {
            if (request.status === 200) {
                if (success)
                    success(JSON.parse(request.responseText));
                    console.log("succes");
            } else {
                if (error)
                    error(request);
            }
        }
    };
    request.open("GET", path, true);
    request.send();
}

/**
 *  CSS bestand vervangen
 *  @param cssFile: pad naar nieuw css bestand
 *  @param cssLinkIndex: index in de head van de te vervangen link
 * */

function changeCSS(cssFile, cssLinkIndex) {

  var oldlink = document.getElementsByTagName("link").item(cssLinkIndex);

  var newlink = document.createElement("link");
  newlink.setAttribute("rel", "stylesheet");
  newlink.setAttribute("type", "text/css");
  newlink.setAttribute("href", cssFile);

  document.getElementsByTagName("head").item(0).replaceChild(newlink, oldlink);
}
