<main class="content home">
	<header class="pad">
		<h1>Enregistrement</h1>
		<p>
			Dans la vie y'a rien de gratuit, même ce qui est gratuit n'est pas vraiment gratuit, nous on aime la gratuité et c'est gratuitement que vous allez créer votre compte n'est ce pas ?
		</p>
	</header>
	<section class="login d-flex flex-column pad align-items-center">
		<form method="post" action="/register/create" class="login-form d-flex flex-column justify-content-center">
			<?php
				if (isset($this->data))
				{
					echo "
						<div class=\"alert alert-danger\">
							Impossible d'utiliser cette adresse mail.
						</div>
					";
				}
			?>
			<div class="form-group">
				<label for="mail">Adresse Mail</label>
				<input type="email" name="email" class="form-control" id="mail" aria-describedby="emailHelp" placeHolder="Entrez votre adresse email."/>
				<small id="emailHelp" class="form-text text-muted">Vous pemettra de vous connecter une fois validé.</small>
			</div>
			<button type="submit" name="register" class="btn btn-primary btn-block btn-form">Création</button>
		</form>
	</section>
</main>