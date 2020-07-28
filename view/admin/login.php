<main class="content home">
	<header class="pad">
		<h1>Panneau de Contrôle</h1>
		<p>
			Vous entrez dans un espace protégé, pour des raisons de sécurité, veuillez vous identifier.
		</p>
	</header>
	<section class="login d-flex flex-column pad align-items-center">
		<form method="post" action="/admin/login" class="login-form d-flex flex-column justify-content-center">
			<div class="form-group">
				<label for="mail">Adresse Mail</label>
				<input type="email" name="email" class="form-control" id="mail" aria-describedby="emailHelp" placeHolder="Entrez votre adresse email."/>
			</div>
			<div class="form-group">
				<label for="pwd">Mot de Passe</label>
				<input type="password" name="passwd" class="form-control" id="pwd" placeHolder="Entrez votre mot de passe."/>
			</div>
			<div class="form-group">
				<button type="submit" name="login" class="btn btn-primary btn-block">Connexion</button>
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-secondary btn-block" id="forgotten">Mot de Passe Oublié</button>
			</div>
		</form>
		<form method="post" action="/admin/recover" class="login-form d-none flex-column justify-content-center" id="recover-password">
			<div class="form-group">
				<label for="mail">Adresse Mail</label>
				<input type="email" name="email" class="form-control" id="mail" aria-describedby="emailHelp" placeHolder="Entrez votre adresse email."/>
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
				<button type="submit" name="login" class="btn btn-primary btn-block">Récupérer</button>
			</div>
		</form>
	</section>
</main>