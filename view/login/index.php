<main class="content home">
	<header class="pad">
		<h1>Connexion</h1>
		<p>
			Vous devez vous connecter pour utiliser le service.
		</p>
	</header>
	<section class="login d-flex flex-column pad align-items-center">
		<form method="post" action="/login/connect" class="login-form d-flex flex-column justify-content-center">
			<div class="form-group">
				<?php
					if (isset($this->data['errors']))
					{
						foreach ($this->data['errors'] as $error)
						{
							echo '<p class="text-danger">' . $error . '</p>';
						}
					}
				?>
			</div>
			<div class="form-group">
				<label for="mail">Adresse Mail</label>
				<input type="email" name="email" class="form-control" id="mail" aria-describedby="emailHelp" placeHolder="Entrez votre adresse email."/>
				<small id="emailHelp" class="form-text text-muted">Utilisée lors de votre inscription.</small>
			</div>
			<div class="form-group">
				<label for="pwd">Mot de Passe</label>
				<input type="password" name="passwd" class="form-control" id="pwd" placeHolder="Entrez votre mot de passe."/>
			</div>
			<div class="form-group">
				<input type="checkbox" name="remember" class="form-check-input" id="remember"/>
				<label class="form-check-label" for="remember">Se Souvenir</label>
			</div>
			<div class="form-group">
				<button type="submit" name="login" class="btn btn-primary btn-block">Connexion</button>
			</div>
			<div class="form-group">
                <a href="/register" title="Nouvel Utilisateur" class="btn btn-info btn-block a-button">Nouvel Utilisateur</a>
			</div>
		</form>
	</section>
</main>