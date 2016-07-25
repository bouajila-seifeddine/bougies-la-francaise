  $(document).ready(function ()
   {
        $('#scancube_jzspin').jzSpin
         (
            {
              ldImageWidth:   ScanCubePresta360Settings.ldImageWidth,
              ldImageHeight:  ScanCubePresta360Settings.ldImageHeight,
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
   } 
   );
