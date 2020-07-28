/*
	Pour le routing.
*/

function calculate_travel(map)
{
	departure   = $('#departure');
	destination = $('#destination');

	if (departure.attr('lat') && destination.attr('lat'))
	{
		var control = L.Routing.control({
			serviceUrl: 'http://router.project-osrm.org/route/v1',
			language: 'fr',
			waypoints: [
			L.latLng(departure.attr('lat'), departure.attr('lon')),
			L.latLng(destination.attr('lat'), destination.attr('lon'))
			]
		}).addTo(map);

		control.on('routesfound', function(e) {
			var routes = e.routes;
			var summary = routes[0].summary;

			$('#duration').val(Math.round(summary.totalTime % 3600 / 60));
			
			// KM.
			console.log(summary.totalDistance / 1000);
		});
	}
}

function close_completion()
{
	$('.autocomplete-items').remove();
}

$(document).ready(function() {
	
	// Carte ; Affichage par défaut.
	var map = L.map('maps').setView([43.834446, 5.783014], 13);
	
	// Calque d'Apparence (Tiles).
	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', {foo: 'bar', attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'}).addTo(map);

	/*
		Gère l'autocomplétion du départ et de la destination.
	*/

	$('#departure, #destination').bind('input', function() {
		// Si on a au moins un caractère.
		if ($(this).val().length > 1)
		{
			var conteneur = $(this);
			var text = $(this).val();
			
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

						// On ajoute les données Latitude et Longitude à la sélection.
						choice.attr('lat', donnees[i]['lat']);
						choice.attr('lon', donnees[i]['lon']);
						
						// Écouteur.
						$(choice).click(function() {
							// Ajoute la valeur et le texte à l'input.
							$(conteneur).val($(this).html());

							// Ajout des Coordonnées à l'input.
							$(conteneur).attr('lat', $(this).attr('lat'));
							$(conteneur).attr('lon', $(this).attr('lon'));
							
							// Détruit le conteneur.
							$('.autocomplete-items').remove();
							calculate_travel(map);
						});
						
						container.append(choice);
					}
				}
			});
		}
	});

	// Gère l'autocomplétion au clavier.
	$('input').keyup(function() {
		if ($(this).val().length == 0)
		{
			close_completion();
		}
	});
});