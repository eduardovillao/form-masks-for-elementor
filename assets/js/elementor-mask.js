(function($) {
	var fmeMasks = {
		'ev-tel': '0000-0000',
		'ev-tel-ddd': '(00) 0000-0000',
		'ev-tel-ddd9': '(00) 00000-0000',
		'ev-tel-us': '(000) 000-0000',
		'ev-cpf': '000.000.000-00',
		'ev-cnpj': '00.000.000/0000-00',
		'ev-money': '000.000.000.000.000,00',
		'ev-ccard': '0000-0000-0000-0000',
		'ev-ccard-valid': '00/00',
		'ev-cep': '00000-000',
		'ev-time': '00:00:00',
		'ev-date': '00/00/0000',
		'ev-date_time': '00/00/0000 00:00:00'
	};

    $(window).on( 'load', function() {
		"use strict";
        $('.fme-mask-input').each(function() {
			if($( this ).data('fme-mask') !== undefined) {
				var inputMask = $( this ).data("fme-mask");
				if(inputMask == 'ev-cpf' || inputMask == 'ev-cnpj' || inputMask == 'ev-money') {
					$( this ).mask( fmeMasks[inputMask], {reverse: true} );
				} else {
					$( this ).mask( fmeMasks[inputMask] );
				}
			}
		});
		jQuery(document).on( 'elementor/popup/show', () => {
			$('.fme-mask-input').each(function() {
				if($( this ).data("fme-mask") !== undefined) {
					var inputMask = $( this ).data("fme-mask");
					if(inputMask == 'ev-cpf' || inputMask == 'ev-cnpj' || inputMask == 'ev-money') {
						$( this ).mask( fmeMasks[inputMask], {reverse: true} );
					} else {
						$( this ).mask( fmeMasks[inputMask] );
					}
				}
			});
    	});
	});
})(jQuery);