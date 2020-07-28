$(document).ready(function() {

	console.log('Profile JS Ready (Access Level 1).');
	
	var refusal = new Audio('http://localhost/covoitudiant/public/snd/refuse.ogg');
	
	refusal.volume = 0.2;
	
	$('#refuse').click(function(event) {
		refusal.play();
	});
	
	function close_completion()
	{
		$('.autocomplete-items').remove();
	}
	
	$('#location').bind('input', function() {
		// Si on a au moins un caractère.
		if ($(this).val().length > 1)
		{
			var conteneur = $(this);
			var text = $(this).val();
			
			// Interrogeons le serveur.
			$.ajax({
				type: 'GET',
				url: '/ajax/autocomplete/' + text,
				timeout: 4096,
				beforeSend()
				{
					close_completion();
				},
				success: function(data)
				{
					var donnees = JSON.parse(data);
					
					var container = $('<div></div>');
					container.attr('class', 'autocomplete-items');
					
					conteneur.parent().append(container);
					
					for (i = 0; i < donnees.length; i++)
					{
						// On crée un conteneur.
						var choice = $('<div></div>');
						
						// On réecrit le contenu de notre conteneur.
						choice.html(donnees[i]['city'].substr(0, text.length));
						
						// On append le résultat.
						choice.append(donnees[i]['city'].substr(text.length));
						
						// Écouteur.
						$(choice).click(function() {
							// Ajoute la valeur et le texte à l'input.
							$(conteneur).val($(this).html());
							
							// Détruit le conteneur.
							close_completion();
						});
						
						container.append(choice);
					}
				}
			});
		}
	});
	
	// Evidemment.
	$('input').keyup(function() {
		if ($(this).val().length == 0)
		{
			close_completion();
		}
	});
});