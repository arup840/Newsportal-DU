<div class="w3-container">
  
</div>

<div class="w3-content" style="max-width:960px;margin:0 auto;">
  <img class="mySlides" src="images/slideshow/new/01.jpg">
  <img class="mySlides" src="images/slideshow/new/02.jpg">
  <img class="mySlides" src="images/slideshow/new/03.jpg">
</div>

<div class="w3-center" style="max-width:100px;margin:0 auto;">
  <div class="w3-section"style="width:960px;margin:0 auto;">
    <button class="w3-button w3-light-grey" onclick="plusDivs(-1)">❮ Prev</button>
    <button class="w3-button w3-light-grey" onclick="plusDivs(1)">Next ❯</button>
  </div>
  
</div>

<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
     dots[i].className = dots[i].className.replace(" w3-red", "");
  }
  x[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " w3-red";
}
</script>
