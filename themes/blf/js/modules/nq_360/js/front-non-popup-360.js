  $(document).ready(function ()
   {
        $('#scancube_jzspin').jzSpin
        (
            {
                ldImageWidth:   465,
                ldImageHeight:  575,
                isZoomable:     ScanCubePresta360Settings.isZoomable,
                hdImageWidth:   ScanCubePresta360Settings.hdImageWidth,
                hdImageHeight:  ScanCubePresta360Settings.hdImageHeight,
                numberOfImages: ScanCubePresta360Settings.numberOfImages,
                rotationSpeed : ScanCubePresta360Settings.rotationSpeed,
                autoSpinAfter : ScanCubePresta360Settings.autoSpinAfter,
                style :ScanCubePresta360Settings.style,
                magnifierSize :ScanCubePresta360Settings.magnifierSize,
                direction:ScanCubePresta360Settings.direction, //ckw = 0 , antickw = 1 
                ldImageBaseName :ScanCubePresta360Settings.ldImageBaseName,
                hdImageBaseName :ScanCubePresta360Settings.hdImageBaseName 
            }
        ) ;

        /* Added by Olivier */
        $('#thumbnail_scancube360').hover(function() {
            $("#thumbs_list li a").removeClass('shown');
            $("#thumbnail_scancube360").addClass('shown');
            $("#scancube-360").fadeIn()();
        }, function() {

        });

        $("#thumbs_list li:not(#thumbnail_scancube360)").hover(function() {
            $("#scancube-360").fadeOut();
            $("#thumbnail_scancube360").removeClass('shown');
        }, function() {});
   } 
   );
