	$(document).ready
	(
	function()
	{
	$('.view_360').each(
	function()
	{
		 var fancyBoxOptions = {} ;
		 if (window.ScanCubePresta360Settings.prestashopVersion.localeCompare("1.5.5.0") !== -1)
		 {   //fancyBox version 2
		     fancyBoxOptions =  {
			        'openEffect' : 'elastic' ,
				'closeEffect': 'elastic' ,
				'autoCenter' : true,
				'scrolling'  : false,
				'hideOnContentClick': false,
				'autoSize': false,
				'width': ScanCubePresta360Settings.ldImageWidth,
				'height': ScanCubePresta360Settings.ldImageHeight,
				'beforeClose': function()
				{
				    $('#scancube_jzspin').clearJzSpin();
				}
			    } ;
		}
		else//fancybox version 1
		{
		    fancyBoxOptions={
				'transitionIn'	: 'elastic',
				'transitionOut'	: 'elastic',
				'hideOnContentClick' : false,
                                'autoDimensions':false,
				'width' :ScanCubePresta360Settings.ldImageWidth,
				'height' :ScanCubePresta360Settings.ldImageHeight,
				'onClosed' : function()
				{
				 $("#scancube_jzspin").clearJzSpin() ;
				}
			} ;
		}
		 $(this).fancybox(fancyBoxOptions );

		$(this).bind('click', function()
		{
		    $('#scancube_jzspin').jzSpin
			    (
				    {
					ldImageWidth: ScanCubePresta360Settings.ldImageWidth,
					ldImageHeight: ScanCubePresta360Settings.ldImageHeight,
					isZoomable: ScanCubePresta360Settings.isZoomable,
					hdImageWidth: ScanCubePresta360Settings.hdImageWidth,
					hdImageHeight: ScanCubePresta360Settings.hdImageHeight,
					numberOfImages: ScanCubePresta360Settings.numberOfImages,
					rotationSpeed: ScanCubePresta360Settings.rotationSpeed,
					autoSpinAfter: ScanCubePresta360Settings.autoSpinAfter,
					style: ScanCubePresta360Settings.style,
					magnifierSize: ScanCubePresta360Settings.magnifierSize,
					direction: ScanCubePresta360Settings.direction, //ckw = 0 , antickw = 1
					ldImageBaseName: ScanCubePresta360Settings.ldImageBaseName,
					hdImageBaseName: ScanCubePresta360Settings.hdImageBaseName
				    }
			    );
		});
	}
	);
	}
	);
