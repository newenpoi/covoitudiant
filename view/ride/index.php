<main class="content home">
    <header class="pad">
        <h1>Mes Trajets</h1>
        <p>
            Retrouvez ci-dessous toutes les informations sur vos trajets ou ceux que vous avez sollicité.
        </p>
    </header>

    <?php
        // Si nous proposons un trajet.
        if ($this->data['ride'] !== false)
        {
            ?>
            <section>
                <form method="post" action="ride/delete/<?= $this->data['ride']['ID'] ?>" class="d-flex flex-column p-4">
                    <small id="depHelp" class="form-text text-muted mb-2">Départ</small>
                    <input type="text" name="depart" value="<?= $this->data['ride']['Point_Depart'] ?>" aria-describedby="depHelp" disabled/>

                    <small id="destHelp" class="form-text text-muted mb-2">Destination</small>
                    <input type="text" name="dest" value="<?= $this->data['ride']['Destination'] ?>" aria-describedby="destHelp" disabled/>

                    <input type="submit" value="Supprimer mon Trajet" class="btn btn-danger btn-form mt-4"/>
                </form>
            </section>
            <?php
        }

        // Si nous avons des étudiants en attente d'être validés sur le(s) trajet(s).
        if (count($this->data['pending']))
        {
            ?>
            <section class="pad">
                <h1>Pendant</h1>
                <p>
                    Retrouvez ici les étudiants sur vos trajets en attente de validation.
                </p>
            </section>
            <section>
                <?php
                    foreach ($this->data['pending'] as $reservation)
                    {
                        ?>
                        <form method="post" action="ride/accept/<?= $reservation['ID_User'] ?>:<?= $reservation['ID_Trajet'] ?>" class="d-flex flex-column p-4">
                            <small id="fnamehelp" class="form-text text-muted mb-2">Prénom</small>
                            <input type="text" name="dest" value="<?= $reservation['first_name'] ?>" aria-describedby="fnamehelp" disabled/>

                            <small id="locName" class="form-text text-muted mb-2">Lieu</small>
                            <input type="text" name="dest" value="<?= $reservation['Lieu_Recuperation'] ?>" aria-describedby="locName" disabled/>

                            <a href="profile/view/<?= $reservation['ID_User'] ?>" class="font-consolas p-2 mt-2">Voir le Profil</a>

                            <input type="submit" value="Accepter" class="btn btn-primary btn-form mt-2"/>
                        </form>
                        <?php
                    }
                ?>
            </section>
            <?php
        }

        // Pour les étudiants acceptés sur le(s) trajet(s).
        if (count($this->data['accepted']))
        {
            ?>
            <section class="pad">
                <h1>Passagers</h1>
                <p>
                    Retrouvez ici les étudiants pour lesquels vous avez accepté de covoiturer.
                </p>
            </section>
            <section>
                <?php
                    foreach ($this->data['accepted'] as $reservation)
                    {
                        ?>
                        <form method="post" action="ride/cancel/<?= $reservation['ID_User'] ?>:<?= $reservation['ID_Trajet'] ?>" class="d-flex flex-column p-4">
                            <small id="fnamehelp" class="form-text text-muted mb-2">Prénom</small>
                            <input type="text" name="dest" value="<?= $reservation['first_name'] ?>" aria-describedby="fnamehelp" disabled/>

                            <small id="locName" class="form-text text-muted mb-2">Lieu</small>
                            <input type="text" name="dest" value="<?= $reservation['Lieu_Recuperation'] ?>" aria-describedby="locName" disabled/>

                            <input type="submit" value="Annuler" class="btn btn-warning btn-info btn-form mt-4"/>
                        </form>
                        <?php
                    }
                ?>
            </section>
            <?php
        }

        // Pour nos demandes sur un ou plusieurs trajets.
        if ($this->data['demand'] !== false)
        {
            ?>
            <section>
                <?php
                    foreach ($this->data['demand'] as $demand)
                    {
                        ?>
                        <form method="post" action="ride/cancel/<?= $demand['ID_Trajet'] ?>" class="d-flex flex-column p-4">
                            <small id="fnameHelp" class="form-text text-muted mb-2">Covoitureur</small>
                            <input type="text" name="first_name" value="<?= $demand['first_name'] ?>" aria-describedby="fnameHelp" disabled/>

                            <small id="locHelp" class="form-text text-muted mb-2">Récupération</small>
                            <input type="text" name="depart" value="<?= $demand['Point_Depart'] ?>" aria-describedby="locHelp" disabled/>

                            <small id="destHelp" class="form-text text-muted mb-2">Destination</small>
                            <input type="text" name="dest" value="<?= $demand['Destination'] ?>" aria-describedby="destHelp" disabled/>

                            <small id="depHelp" class="form-text text-muted mb-2">Heure de Départ</small>
                            <input type="text" name="dest" value="<?= $demand['Depart'] ?>" aria-describedby="depHelp" disabled/>
                            
                            <small id="arrHelp" class="form-text text-muted mb-2">Arrivée</small>
                            <input type="text" name="dest" value="<?= $demand['Arrivee'] ?>" aria-describedby="arrHelp" disabled/>

                            <small id="retHelp" class="form-text text-muted mb-2">Heure de Retour</small>
                            <input type="text" name="dest" value="<?= $demand['Retour'] ?>" aria-describedby="retHelp" disabled/>

                            <input type="submit" value="Annuler" class="btn btn-danger btn-form mt-4"/>
                        </form>
                        <?php
                    }
                ?>
            </section>
            <?php
        }
    ?>
</main>