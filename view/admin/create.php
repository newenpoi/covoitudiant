<main class="content home">
	<header class="pad">
		<h1>Administration</h1>
		<p>
			Création d'un compte administrateur.
		</p>
		<p class="mt-2">
			Aucun administrateur ne figure dans votre base de données, vous devez créer un compte administrateur pour utiliser cette infrastructure.
		</p>
	</header>
	<section class="login d-flex flex-column pad align-items-center">
		<form method="post" action="/admin/register" class="login-form d-flex flex-column justify-content-center">
			<div class="form-group">
				<?php
					if (isset($this->data['errors']))
					{
						foreach ($this->data['errors'] as $error)
						{
							printf('<p><span class="badge badge-danger">ERREUR</span>%s</p>', $error);
						}
					}
				?>
			</div>
			<div class="form-group">
				<label for="mail">Adresse Mail</label>
				<input type="email" name="email" class="form-control" id="mail" aria-describedby="emailHelp" placeHolder="Entrez votre adresse email."/>
				<small class="form-text text-muted">Servira comme moyen de connexion au panneau de contrôle.</small>
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
				<label for="secret-question">Question Secrète</label>
				<select name="secret_question" class="form-control" id="secret-question">
					<option>Quel est le nom de votre matou ?</option>
					<option>Quel est le nom de votre chien ?</option>
					<option>Quel est le nom de votre première école ?</option>
					<option>Quel est le nom de votre plus grand crush ?</option>
				</select>
				<small class="form-text text-muted">En cas d'oubli de mot de passe.</small>
			</div>
			<div class="form-group">
				<label for="secret-answer">Réponse à la Question Secrète</label>
				<input type="text" name="secret_answer" class="form-control" id="secret-answer"/>
			</div>
			<div class="form-group">
				<button type="submit" name="register" class="btn btn-primary btn-block">Création</button>
			</div>
		</form>
	</section>
</main>