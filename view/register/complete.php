<main class="content home">
	<header class="pad">
		<h1>Enregistrement</h1>
		<p>
			Finaliser mon inscription.
		</p>
		<p class="mt-2">
			Vous devez compléter votre profil avant de pouvoir utiliser le service, vous avez également le choix de refuser celui-ci, dans ce cas nous effacerons votre existence de notre base de données (seulement de notre base de données bien entendu).
		</p>
	</header>
	<section class="login d-flex flex-column pad align-items-center">
		<form method="post" action="/register/complete" class="login-form d-flex flex-column justify-content-center">
			<div class="form-group">
				<input type="hidden" name="email" value="<?= $this->data['email'] ?>"/>
				<input type="hidden" name="token" value="<?= $this->data['token'] ?>"/>
			</div>
			<div class="form-group">
				<label for="pwd">Mot de Passe</label>
				<input type="password" name="passwd" class="form-control" id="pwd" placeHolder="Entrez votre mot de passe."/>
				<small class="form-text text-muted">Doit contenir au moins une majuscule, un caractère spécial et un chiffre.</small>
			</div>
			<div class="form-group">
				<label for="pwd_rpt">Confirmez Mot de Passe</label>
				<input type="password" name="passwd_repeat" class="form-control" id="pwd_rpt" placeHolder="Répétez votre mot de passe."/>
			</div>
			<div class="form-group">
				<label for="name">Nom</label>
				<input type="text" name="name" class="form-control" id="name" placeHolder="Entrez votre nom de famille."/>
                <small class="form-text text-muted">Pourra être caché dans votre profil.</small>
			</div>
			<div class="form-group">
				<label for="forename">Prénom</label>
				<input type="text" name="forename" class="form-control" id="forename" placeHolder="Entrez votre prénom."/>
			</div>
			<div class="form-group autocomplete">
				<label for="location">Lieu de Départ</label>
				<input type="text" name="location" class="form-control" id="location" placeHolder="Entrez votre lieu de départ."/>
                <small class="form-text text-muted">Votre lieu de départ est obligatoire pour utiliser le service.</small>
			</div>
			<div class="form-group">
				<label for="secret-question">Question Secrète</label>
				<select name="secret_question" class="form-control" id="secret-question">
					<option>Quel est le nom de votre matou ?</option>
					<option>Quel est le nom de votre cleps ?</option>
					<option>Quel est le nom de votre première école ?</option>
					<option>Quel est le nom de votre plus grand crush ?</option>
				</select>
			</div>
			<div class="form-group">
				<label for="secret-answer">Réponse à la Question Secrète</label>
				<input type="text" name="secret_answer" class="form-control" id="secret-answer"/>
			</div>
            <div class="form-group">
                <label for="avatar">Transférer un Avatar</label>
                <input type="file" name="avatar" id="avatar"/>
            </div>
			<div class="form-group">
				<button type="submit" name="register" class="btn btn-primary btn-block">Finaliser</button>
			</div>
		</form>
		<div class="login-form d-flex flex-column justify-content-center">
			<button class="btn btn-danger btn-block btn-form" id="refuse">Refuser</button>
		</div>
	</section>
</main>