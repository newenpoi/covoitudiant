<main class="content home">
    <header class="pad">
        <h1>
            <?php printf('Profil de %s %s', $this->data['infos']['first_name'], $this->data['infos']['last_name']) ?>
        </h1>
        <p>
            Laissez un avis, consulter les avis, ou signaler un problème.
        </p>
    </header>
    <section class="d-flex justify-content-center">
        <img class="avatar rounded-circle pr-2" src="<?= (isset($this->data['infos']['avatar']) ? AVA_PATH . $this->data['infos']['avatar'] : AVA_PATH . 'default.png') ?>" alt="Avatar Photo de Profil"/>
        <ul class="icons d-flex">
            <li>
                <b class="icon icon-like"></b>
                <span>22</span>
            </li>
            <li>
                <b class="icon icon-comment"></b>
                <span><?= ($this->data['comments'] ? count($this->data['comments']) : 0) ?></span>
            </li>
            <li>
                <b class="icon icon-ride"></b>
                <span>8</span>
            </li>
        </ul>
    </section>
    <section class="pad">
        <h2>Biographie</h1>
        <p>
            <?= $this->data['infos']['biography'] ?>
        </p>
    </section>
    <section class="pad">
        <h2>Commentaires</h1>
        <?php
            foreach ($this->data['comments'] as $comment)
            {
                ?>
                <div class="d-flex py-4">
                    <img class="avatar-s rounded-circle" src="<?= (isset($comment['avatar']) ? AVA_PATH . $comment['avatar'] : AVA_PATH . 'default.png') ?>" alt="Avatar Photo de Profil"/>
                    <div class="px-4">
                        <p class="font-weight-bold"><?= $comment['first_name'] ?></p>
                        <p class="comment">
                            <?= $comment['Content'] ?>
                        </p>
                    </div>
                </div>
                <?php
            }
        ?>
    </section>
</main>