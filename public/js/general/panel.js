/*
    Gestion des appels Ajax.
*/
function ajax(action, data)
{
    $('.form-group').first().empty();

    return $.ajax({
        type: 'POST',
        url: 'ajax/' + action,
        data: data,
        timeout: 4096,
        beforeSend: function()
        {
            console.log('Calling...');
        },
        statusCode:
        {
            404: function() {
                console.log('Introuvable.');
            }
        },
        success: function(data)
        {
            if (0 === data.length)
                return false;
            return true;
        }
    });
}

$(document).ready(function() {
    console.log('Panel JS Ready (Access Level 2).');
    
    /*
        Attention les appels Ajax sont asynchrones.
        l'Utilisation de sync: true, est fortement déconseillée.
    */
    
    /*
        Pour l'ajout de formations.
    */
    $('#add-formation').click(function(event) {
        event.preventDefault();
        
        var input = $('#input-formation').val();

        ajax('addFormation', {'input': input}).done(function(data)
        {
            if (data)
            {
                var dummy = '<p><span class="badge badge-success">GG</span>Vous venez de créer la filière ' + input + '.</p>';
            }
            else
            {
                var dummy = '<p><span class="badge badge-danger">ERREUR</span>Impossible de créer la filière ' + input + '.</p>';
            }

            $('.form-group').first().append(dummy);
        });
    });

    /*
        Pour l'affectation des utilisateurs.
    */
    $('#affect-user').click(function(event) {
        event.preventDefault();

        var email = $("#aff-email option:selected").val();
        var id_formation = $("#aff-formation option:selected").val();

        ajax('affUser', {'email': email, 'id_formation': id_formation}).done(function(data)
        {
            if (data)
            {
                var dummy = '<p><span class="badge badge-success">GG</span>Utilisateur affecté avec succès.</p>';
    
                if ($('#aff-email option').length == 1)
                {
                    $('#aff-users').remove();
                }
            }
            else
            {
                var dummy = '<p><span class="badge badge-danger">ERREUR</span>Impossible d\'affecter l\'utilisateur.</p>';
            }

            $('.form-group').first().append(dummy);
        });
    });

    /*
        Pour la réaffectation des utilisateurs.
    */
    $('#reaff-validate, reaff-refuse').click(function(event) {
        event.preventDefault();

        var email = $("#reaff-email option:selected").val();
        var id_formation = $("#reaff-formation option:selected").val();

        ajax('reaffUser', {'email': email, 'id_formation': id_formation}).done(function(data)
        {
            if (data)
            {
                var dummy = '<p><span class="badge badge-success">GG</span>Utilisateur réaffecté avec succès.</p>';
    
                if ($('#reaff-email option').length == 1)
                {
                    $('#reaff-users').remove();
                }
                else
                {
                    // Supprimer la paire.
                    $("#reaff-email option:selected").remove();
                    $("#reaff-formation option:selected").remove();
                }
            }
            else
            {
                var dummy = '<p><span class="badge badge-danger">ERREUR</span>Impossible de réaffecter l\'utilisateur.</p>';
            }

            // Afficher l'indicateur de traitement.
            $('.form-group').first().append(dummy);
        });
    });
});