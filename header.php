<!DOCTYPE HTML>
<HTML lang="en">
<?php
include "style.css"
?>
    <head>
        
        <title>Benjamin Gelb .</title>
        <meta charset="utf-8">
        <meta name="author" content="Benjamin Gelb">
        <link rel="shortcut icon" href="/images/llama.ico" type="image/x-icon" />
        <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
        <meta name="description" content="A sample of my sitemap">
       

<div id="scroll-animate">
  <div id="scroll-animate-main">
    <div class="wrapper-parallax">
      <header>
        <h1>Header</h1>
      </header>

      <section class="content">
        <h1>Content</h1>
      </section>

      <footer>
        <h1>Footer</h1>
      </footer>
    </div>
  </div>
</div>
<script>
function scrollFooter(scrollY, heightFooter)
{
    console.log(scrollY);
    console.log(heightFooter);

    if(scrollY >= heightFooter)
    {
        $('footer').css({
            'bottom' : '0px'
        });
    }
    else
    {
        $('footer').css({
            'bottom' : '-' + heightFooter + 'px'
        });
    }
}

$(window).load(function(){
    var windowHeight        = $(window).height(),
        footerHeight        = $('footer').height(),
        heightDocument      = (windowHeight) + ($('.content').height()) + ($('footer').height()) - 20;

    // Definindo o tamanho do elemento pra animar
    $('#scroll-animate, #scroll-animate-main').css({
        'height' :  heightDocument + 'px'
    });

    // Definindo o tamanho dos elementos header e conteúdo
    $('header').css({
        'height' : windowHeight + 'px',
        'line-height' : windowHeight + 'px'
    });

    $('.wrapper-parallax').css({
        'margin-top' : windowHeight + 'px'
    });

    scrollFooter(window.scrollY, footerHeight);

    // ao dar rolagem
    window.onscroll = function(){
        var scroll = window.scrollY;

        $('#scroll-animate-main').css({
            'top' : '-' + scroll + 'px'
        });
        
        $('header').css({
            'background-position-y' : 50 - (scroll * 100 / heightDocument) + '%'
        });

        scrollFooter(scroll, footerHeight);
    }
});
</script> 