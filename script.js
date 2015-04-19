function init() {
  window.addEventListener('scroll', function(e){
    var distanceY = window.pageYOffset || document.documentElement.scrollTop,
        shrinkOn = 200,
        header = document.querySelector("header");
    if (distanceY > shrinkOn) {
      header.setAttribute("class","smaller");
    } else {
        header.removeAttribute("class");
    }
  });
}
window.onload = init();
