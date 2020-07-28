<main class="content home">
    <header class="pad">
        <h1>Rechercher un Trajet</h1>
        <p>
            Choisissez votre point de récupérage, votre destination, les jours et l'heure à laquelle vous souhaiteriez être covoituré(e).
        </p>
    </header>
    <form method="post" action="/search/find" class="d-flex flex-column p-4" >
        <?php
            if (isset($this->data['status']))
            {
                ?>
                    <div class="form-group">
                        <p><span class="badge badge-success">GG</span>Jettez un oeil aux résultats.</p>
                    </div>
                <?php
            }
        ?>
        <div class="form-group autocomplete">
            <input type="text" name="departure" placeHolder="Départ" id="departure" autocomplete="off"/>
        </div>
        <div class="form-group autocomplete">
            <input type="text" name="destination" placeHolder="Destination" id="destination" class="mt-2" autocomplete="off"/>
        </div>

        <!-- Carte LeafLet -->
        <div id="maps"></div>

        <p class="pt-2 pl-2">Saisissez votre planning :</p>

        <div class="d-flex justify-content-between weekdays-selector mt-2">
            <input type="checkbox" name="days[]" value="Lundi" id="mon" class="weekday">
            <label for="mon">Lundi</label>
            
            <input type="checkbox" name="days[]" value="Mardi" id="tue" class="weekday">
            <label for="tue">Mardi</label>
            
            <input type="checkbox" name="days[]" value="Mercredi" id="wed" class="weekday">
            <label for="wed">Mercredi</label>
            
            <input type="checkbox" name="days[]" value="Jeudi" id="thu" class="weekday">
            <label for="thu">Jeudi</label>
            
            <input type="checkbox" name="days[]" value="Vendredi" id="fri" class="weekday">
            <label for="fri">Vendredi</label>
        </div>
        
        <p class="pt-2 pl-2">Indiquez l'heure de départ :</p>
        
        <input type="time" name="dep_time" min="06:00" max="20:00" value="07:00" class="mt-2" required/>
        <input type="hidden" name="duration" value="" id="duration"/>

        <p class="pt-2 pl-2">Indiquez l'heure de retour :</p>

        <input type="time" name="ret_time" min="06:00" max="20:00" value="17:00" class="mt-2" required/>
        
        <input type="submit" name="validate" value="Rechercher" class="btn-cta rounded mt-2"/>
    </form>
</main>