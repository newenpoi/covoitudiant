<main class="content home">
    <header class="pad">
        <h1>Résultats de Recherche</h1>
        <p>
            Voici la liste des trajets correspondants à vos critères.
        </p>
    </header>
    <section class="pad-x pb-4">
        <h1><?= $this->data['ville_depart'] ?> vers <?= $this->data['ville_dest'] ?></h1>
    </section>
    <section class="d-flex flex-column">
        <?php
            foreach ($this->data['result'] as $result)
            {
                ?>
                <article class="article-result bg-light border-info p-4">
                    <div class="d-flex justify-content-around align-items-center">
                        <div>
                            <img src="<?= (isset($result['avatar']) ? AVA_PATH . $result['avatar'] : AVA_PATH . 'default.png') ?>" alt="Photo de Profil" class="avatar rounded-circle mr-2"/>
                        </div>
                        <ul class="icons d-flex justify-content-around">
                            <li>
                                <a href="profile/view/<?= $result['id'] ?>" title="" class="pr-3"><?= strtoupper($result['first_name']) ?></a>
                            </li>
                            <li>
                                <a href="mailto:<?= $result['email'] ?>" title="Contacter" class="icon icon-contact"></a>
                                <span class="helper-contacter d-none">Contacter</span>
                            </li>
                            <li>
                                <b class="icon icon-like mr-2"></b>
                                <span>15</span>
                            </li>
                            <li>
                                <a href="accept/<?= $result['ID_Trajet'] ?>:<?= $result['first_name'] ?>" title="Réserver" class="btn btn-info btn-reserver">Réserver</a>
                            </li>
                        </ul>
                    </div>
                    <hr/>
                    <div class="d-flex align-items-center justify-content-around my-2">
                        <div class="d-flex justify-content-center">
                            <span class="font-consolas">Départ <?= $result['Depart'] ?> Arrivée <?= $result['Arrivee'] ?></span>
                        </div>
                        <address class="d-flex justify-content-center align-items-center">
                            <span class="icon icon-left icon-arrow-down"></span>
                            <span class="location">Correspondance</span>
                        </address>
                    </div>
                </article>
                <?php
            }
            ?>
    </section>
</main>