var $ = jQuery.noConflict();

$(function(){
    var $ = jQuery.noConflict();
	setImages();
    setRes();

    $('.paginate').pagination({
        items: 100,
        itemsOnPage: 10,
        cssStyle: 'light-theme'
    });

    $('body').on('click', '.selectEle', function(){
        var t = $(this);
        t.find('select').focus();
    });

    $('body').on('click', '.reset', function(){
        var t = $(this);
        t.closest('form')[0].reset();
    }).on('click', '.desktopView', function(){
        changeView(1200, 750);
    }).on('click', '.tabletPort', function(){
        changeView(768, 1024);
    }).on('click', '.tabletLand', function(){
        changeView(1024, 768);
    }).on('click', '.phonePort', function(){
        changeView(320, 480);
    }).on('click', '.phoneLand', function(){
        changeView(568, 320);
    }).on('click', '.showPop', function(e){
        var t = $(this),
            v = t.attr('href'),
            p = t.attr('data-showimg'),
            title = t.attr('data-title'),
            dsc = t.attr('data-dsc'),
            ct = t.attr('data-cat'),
            logos = t.next('.logos').clone(true);
        $('body').addClass('noflow');
        $('#myIframe').css({
            width: '100%'
        });

        $('.frameHolder .header h3').text(title);
        $('.frameHolder .header h4').text(ct);
        $('.frameHolder .footer p').text(dsc);

        $('.imgFull').remove();
        if(v != undefined && v != ''){
            $('#myIframe').attr('src', v);
            $('.borderLeft').css({ 'border-color': '#ffffff' });
            $('.navIcons').fadeIn();
            $('#myIframe').fadeIn();
            
        }else{
            var sr = '<img class="imgFull" src="'+ p +'" >'
            $('#myIframe').hide();
            $('.webWrap').append(sr);
            $('.borderLeft').css({ 'border-color': 'transparent' });
            $('.navIcons').fadeOut();
        }

        //changeView(1200, 750);
        $('.frameHolder').fadeIn();
        $('.inCnt').addClass('zoomInRun');
        $('.inCnt .footer .col-lg-4 .logos').remove();
        $('.inCnt .footer .col-lg-4').html(logos);

        e.preventDefault();
    }).on('click', '.backto, .overlay', function(e){
        var t = $(this);
        $('body').removeClass('noflow');
        $('#myIframe').hide();
        $('.inCnt .footer .col-lg-4 .logos').remove();
        $('#myIframe').attr('src', 'javascript:;');
        $('.inCnt').removeClass('zoomInRun').addClass('zoomOutRun');
        $('.navIcons li').removeClass('active');
        $('.frameHolder').fadeOut(function(){
            $('.inCnt').removeClass('zoomOutRun');
        });
    }).on('click', '.navIcons li', function(e){
        $('.navIcons li').removeClass('active');
        $(this).addClass('active');
    });

    $('[data-popup]').each(function(){
        var t = $(this),
            atr = t.data('popup');
        $(t).lightGallery({
            download:false,
            autoplayControls:false,
            autoplay:false,
            selector: atr,
            download: false,
            enableDrag: true,
            enableSwipe: true,
            thumbnail:false,
            animateThumb: true,
            showThumbByDefault: true
        });
    });
    
});

function changeView(width, height){
    document.getElementById('myIframe').src += '';
    TweenLite.to(".webWrap iframe", 1, {
        width: width,
        height: height
    });
}

function gotoScroll(e){
    $('html, body').animate({
        scrollTop: $("."+e).offset().top
    }, 1000);   
}

function setImages() {
    var $ = jQuery.noConflict();
    $('[data-imgsrc]').each(function() {
        var t = $(this).data('imgsrc'),
        tag = $(this).attr('src');
        if(tag){
            $(this).attr('src', t);
            $(this).addClass('cC');
        }else{
            $(this).css({
                'background-image': 'url(' + t + ')'
            });
        }
    });
}

$(window).on('scroll', function(){
    var $ = jQuery.noConflict();
    var currentScrollPos = $(window).scrollTop();
    if(currentScrollPos > 600){
        $('.backToTop').addClass('on');
    }else{
        $('.backToTop').removeClass('on');
    }
});

$(window).load(function(){
    var $ = jQuery.noConflict();
    $('a[href^="#"]').on('click', function(event) {
        var target = $( $(this).attr('href') );
        if( target.length ) {
            event.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 1000);
        }
    });
    
    var wht = $(window).outerHeight(),
        hht = $('.frameHolder .header').outerHeight(),
        fht = $('.frameHolder .footer').outerHeight(),
        fht = wht - (hht - fht);
        console.log(wht, hht, fht);
    $('.frameHolder .webWrap').height(fht);

    $('.loader2').fadeOut();
});

$(window).resize(function(){
    setRes();
});

function setRes(){
    var $ = jQuery.noConflict();
    var wd = $(window).width();
    if(wd <= 1200 && wd > 1024){
        changeView(1200, 750);
    }else if(wd <= 1024 && wd > 768){
        changeView(1024, 768);
    }else if(wd <= 768 && wd > 568){
        changeView(768, 1024);
    }else if(wd <= 568 && wd > 320){
        changeView(568, 320);
    }else if(wd <= 320){
        changeView(320, 480);
    }
}

