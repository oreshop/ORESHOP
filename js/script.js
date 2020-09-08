jQuery(document).ready(function($){

    var el = $('.circle'),
        inited = false;

    el.appear({ force_process: true });

    el.on('appear', function() {
        if (!inited) {
            var circle_1 = $('.first.circle');
            var circle_1_number = circle_1.data('number');
            var circle_1_number_echelle = circle_1.data('echelle');
            /* console.log((circle_1_number/100).toFixed(2));*/

            circle_1.circleProgress({
                value: (circle_1_number/circle_1_number_echelle).toFixed(2),
                fill: {
                    color: "#F1A9A8"
                }
            }).on('circle-animation-progress', function(event, progress) {
                $(this).find('span').html(Math.round( circle_1_number * progress) + '<i></i>');
            });


            var circle_2 = $('.second.circle');
            var circle_2_number = circle_2.data('number');
            var circle_2_number_echelle = circle_2.data('echelle');
 

            circle_2.circleProgress({
                value: (circle_2_number/circle_2_number_echelle).toFixed(2),
                fill: {
                    color: "#C5B2D2"
                }
            }).on('circle-animation-progress', function(event, progress) {
                $(this).find('span').html(Math.round( circle_2_number * progress) + '<i></i>');
            });




            var circle_3 = $('.third.circle');
            var circle_3_number = circle_3.data('number');
            var circle_3_number_echelle = circle_3.data('echelle');
  

            circle_3.circleProgress({
                value: (circle_3_number/circle_3_number_echelle).toFixed(2),
                fill: {
                    color: "#8DD6E3"
                }
            }).on('circle-animation-progress', function(event, progress) {
                $(this).find('span').html(Math.round( circle_3_number * progress) + '<i></i>');
            });




            var circle_4 = $('.fourth.circle');
            var circle_4_number = circle_4.data('number');
            var circle_4_number_echelle = circle_4.data('echelle');

            circle_4.circleProgress({
                value: (circle_4_number/circle_4_number_echelle).toFixed(2),
                fill: {
                    color: "#FFE0C7"
                }
            }).on('circle-animation-progress', function(event, progress) {
                $(this).find('span').html(Math.round( circle_4_number * progress) + '<i></i>');
            });



            var circle_5 = $('.fifth.circle');
            var circle_5_number = circle_5.data('number');
            var circle_5_number_echelle = circle_5.data('echelle');
  

            circle_5.circleProgress({
                value: (circle_5_number/circle_5_number_echelle).toFixed(2),
                fill: {
                    color: "#E9F1DE"
                }
            }).on('circle-animation-progress', function(event, progress) {
                $(this).find('span').html(Math.round( circle_5_number * progress) + '<i></i>');
            });
            inited = true;
        }
    });

    //end of circle progress


    //--------NOS ACTU HOME------//

    $(".actualite .inner").hover(
        function(){
            $(this).find(".description").animate({
                left:"50%"
            });
        },
        function(){
            $(this).find(".description").animate({
                left:"100%"
            });
        }

    );

    //--------NOUS SOMME FACE ANGESR LOIRE------//

    $('.local').each(function() {
        var local = $(this);
        var chevron_i = $(this).find("i");
        chevron_i.click(function(){
            local.toggleClass('active');
            //$(this).toggleClass('active');
        });
    });

    //--------ENTREPRISE ENGAGEE------//

    var time = 0;
    var block_number = $('.home .block-number');
    var number_content = block_number.find('.number');
    var total = block_number.data('number');
    setInterval(function(){

        if (time < total) {
            var val = time;
            number_content.html(val + 1);
            time = time + 1;
        }
    }, 100);



}); //$(document).ready(function(){

