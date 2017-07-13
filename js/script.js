window.onload = goNow;

function goNow(){
    //alert("It works!");

    //Google Maps
        initializeMap(45.37831700, -75.66121100);

    function initializeMap(latitude, longitude){
        var library = {
            lat: latitude,
            lng: longitude
        };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 14,
            center: library
        });
        var marker = new google.maps.Marker({
            position: library,
            map: map
        });
    }

    //Show hours when library name is clicked

    $('.library').on('click', function(e) {
            var library_info = $(this).next('.hidden').html();
            $('.library-info').html(library_info);
            //console.log(library_info);

            e.preventDefault();
        });

    //When info for one library is displayed, hide pop-ups for other libraries

/*    $('.library').click(
        function(){
            $('.hidden').hide();
            $(this).next('.hidden').show();
        });*/

    //Show holiday closures when title is clicked
/*
    $('.holiday_hours').on('click', function(a) {
        $(this).next('.hidden2').toggleClass("show"); //Use find() instead of next() to grab the next matching child element
        //console.log($(this).find('.hidden2'));
        //return false;
        a.preventDefault();
    });
*/


    $('.location').on('click', function(e){
        //var latitude = $('.lat')[0].innerHTML;
        var latitude = parseFloat( $(this).find('.lat').html() ); //Find searches the children of an element
        var longitude = parseFloat( $(this).find('.long').html() );
        console.log(latitude);
        console.log(longitude);

        initializeMap(latitude, longitude);
    });

}//end of onload f(x)

