$(document).ready(function() {
	console.log('Global JS Ready (Access Level 0).');
	
	// Gestionnaire de deboggage.
	var special_container = $('#debug');

	$('pre').each(function() {
		special_container.append($(this));
	});

	$('#debug').click(function() {
		$(this).hide();
	});
	
	// Le container de la navigation mobile.
	var mobile_container = $('.nav-mobile-popup');
	
	// Ouverture du menu hamburger.
	$('#hamburger').click(function() {
		let mobile_nav = $('.nav-mobile-popup div');
		
		(mobile_container.hasClass('d-none') ? mobile_container.removeClass('d-none') : mobile_container.addClass('d-none'));
		
		// Mouvement de transition.
		mobile_nav.css('left', '100vh');
		mobile_nav.animate({left: '0vh'});
	});
	
	// En cas de redimensionnement.
	$(window).on('resize', function() {
		if (mobile_container.hasClass('d-none') == false)
			mobile_container.addClass('d-none');
	});

	// Ouverture / Fermeture de la récupération de Mot de Passe (Page User / Admin).
	$('#forgotten').click(function() {
		console.log('Okay');
		$('#recover-password').toggleClass('d-none');
	});
});