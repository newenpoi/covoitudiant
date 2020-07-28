<main class="content home">
	<header class="pad">
		<h1>Panneau de Contrôle</h1>
		<p>
			Vous pouvez gérer cette plate-forme facilement.
			<br/>
			En théorie oui.
		</p>
	</header>
	<section class="login d-flex flex-column pad align-items-center">

		<!-- Créer une Fillière -->
		<form method="post" action="" class="login-form d-flex flex-column justify-content-center py-2">
            <div class="form-group">
            </div>
			<div class="form-group">
				<label for="formation">Fillière.</label>
				<input type="text" name="formation" class="form-control" id="input-formation" aria-describedby="formHelp" placeHolder="Entrez la fillière."/>
				<small id="formHelp" class="form-text text-muted">Vous pemettra d'y affecter des utilisateurs.</small>
			</div>
			<button class="btn btn-primary btn-block btn-form" id="add-formation">Créer une Fillière</button>
		</form>

		<!-- Supprimer une Fillière -->
		<form method="post" action="" class="login-form d-flex flex-column justify-content-center py-2">
			<div class="form-group">
				<select class="form-control mb-2" name="formation" id="del-formation-option">
					<?php
						foreach ($this->data['formations'] as $formation)
						{
							printf('<option value="%s">%s</option>', $formation['id_formation'], $formation['formation_name']);
						}
					?>
				</select>
				<button class="btn btn-warning btn-block btn-form" id="del-formation">Supprimer la Fillière</button>
			</div>
		</form>

		<!-- Affecter des Utilisateurs -->
		<form method="post" action="" class="login-form d-flex flex-column justify-content-center py-2">
			<?php
				if ($this->data['pending'])
				{
					?>
					<div class="form-group d-flex flex-column" id="aff-users">
						<label for="aff-email">En attente d'affectation.</label>
						<select class="form-control mb-2" name="email" id="aff-email">
							<?php
								foreach ($this->data['pending'] as $user)
								{
									printf('<option value="%s">%s</option>', $user['email'], $user['email']);
								}
							?>
						</select>
						<select class="form-control mb-2" name="id_formation" id="aff-formation">
							<?php
								foreach ($this->data['formations'] as $formation)
								{
									printf('<option value="%s">%s</option>', $formation['id_formation'], $formation['formation_name']);
								}
							?>
						</select>
						<input type="button" value="Affecter" class="btn btn-primary btn-block btn-form" id="affect-user"/>
					</div>
					<?php
				}
			?>
		</form>

		<!-- Réaffecter des Utilisateurs -->
		<form method="post" action="" class="login-form d-flex flex-column justify-content-center py-2">
			<?php
				if ($this->data['switch'])
				{
					?>
					<div class="form-group d-flex flex-column" id="reaff-users">
						<label for="reaff-email">En attente de réaffectation vers la formation.</label>
						<select class="form-control mb-2" name="email" id="reaff-email" disabled>
							<?php
								foreach ($this->data['switch'] as $user)
								{
									printf('<option value="%s">%s %s</option>', $user['email'], $user['first_name'], $user['last_name']);
								}
							?>
						</select>
						<select class="form-control mb-2" name="id_formation" id="reaff-formation" disabled>
							<?php
								foreach ($this->data['switch'] as $user)
								{
									printf('<option value="%s">%s</option>', $user['id_formation'], $user['formation_name']);
								}
							?>
						</select>
						<button class="btn btn-primary btn-block btn-form" id="reaff-validate">Autoriser</button>
						<button class="btn btn-warning btn-block btn-form" id="reaff-refuse">Refuser</button>
					</div>
					<?php
				}
			?>
		</form>

		<form method="post" action="/panel/logout" class="login-form d-flex flex-column justify-content-center">
			<input type="submit" value="Déconnexion" class="btn btn-danger btn-block btn-form"/>
		</form>
	</section>
</main>