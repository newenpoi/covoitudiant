<main class="content home">
	<header class="pad">
		<h1><?php printf('%s %s', $this->data['infos']['first_name'], $this->data['infos']['last_name']) ?></h1>
		<p>
			Vous pouvez modifier votre avatar et ajouter un véhicule ou encore faire une demande de changement de fillière.
		</p>
	</header>
	<section class="d-flex flex-column pad align-items-center">
		<!-- Avatar -->
		<div class="d-flex pb-4 justify-content-center">
			<img src="<?= (isset($this->data['infos']['avatar']) ? AVA_PATH . $this->data['infos']['avatar'] : AVA_PATH . 'default.png') ?>" alt="Photo de Profil" class="avatar rounded-circle"/>
		</div>

		<!-- Formation -->
		<form method="post" action="profile/switch" class="login-form d-flex flex-column justify-content-center">
			<p class="py-3"><u>Modifier ma Fillière</u> :</p>
			<div class="form-group">
				<select class="form-control mb-2" name="id_formation" id="aff-formation" aria-describedby="switchHelp">
					<?php
						foreach ($this->data['formations'] as $formation)
						{
							printf('<option value="%s">%s</option>', $formation['id_formation'], $formation['formation_name']);
						}
					?>
				</select>
				<small id="switchHelp" class="form-text text-muted mb-2">Vous recevrez un email de confirmation une fois votre demande examinée.</small>
				<input type="submit" value="Changer" class="btn btn-primary btn-block btn-form" id="affect-user"/>
			</div>
		</form>

		<!-- Erreurs -->
		<div class="login-form pb-2 text-danger">
			<?php
				if (isset($this->data['error']))
				{
					foreach ($this->data['error'] as $error)
					{
						printf('<p><span class="badge badge-danger">ERREUR</span>%s</p>', $error);
					}
				}
			?>
		</div>

		<?php
			if (isset($this->data['vehicle']) && $this->data['vehicle'] !== false)
			{
				?>
				<!-- Véhicule -->
				<form method="post" action="profile/del_vehicle" class="login-form d-flex flex-column justify-content-center">
					<div class="form-group">
						<small id="markHelp" class="form-text text-muted mb-2">Marque de votre véhicule.</small>
						<select class="form-control mb-2" name="marque" aria-describedby="markHelp" disabled>
							<option value="<?= $this->data['vehicle']['Marque'] ?>"><?= $this->data['vehicle']['Marque'] ?></option>
						</select>
						
						<small id="colorHelp" class="form-text text-muted mb-2">Couleur de votre véhicule.</small>
						<select class="form-control mb-2" name="couleur" aria-describedby="colorHelp" disabled>
							<option value="<?= $this->data['vehicle']['Couleur'] ?>"><?= $this->data['vehicle']['Couleur'] ?></option>
						</select>

						<small id="nbPlacesHelp" class="form-text text-muted mb-2">Nombre de places proposées pour ce véhicule.</small>
						<input type="text" name="nb_places" value="<?= $this->data['vehicle']['Places'] ?>" placeHolder="Entrez le nombre de places proposées." aria-describedby="nbPlacesHelp" disabled/>

						<small id="immatHelp" class="form-text text-muted mb-2">Immatriculation du véhicule.</small>
						<input type="text" name="immat" value="<?= $this->data['vehicle']['Immatriculation'] ?>" placeHolder="Entrez votre plaque d'immatriculation." aria-describedby="immatHelp" disabled/>

						<input type="submit" value="Supprimer mon Véhicule" class="btn btn-primary btn-danger btn-form mt-4"/>
					</div>
				</form>
				<?php
			}
			else
			{
				?>
				<!-- Véhicule -->
				<form method="post" action="profile/add_vehicle" class="login-form d-flex flex-column justify-content-center">
					<p class="py-3"><u>Ajouter mon Véhicule</u> :</p>
					<div class="form-group">
						<small id="markHelp" class="form-text text-muted mb-2">Marque de votre véhicule.</small>
						<select class="form-control mb-2" name="marque" aria-describedby="markHelp">
							<option value="1">Volkswagen</option>
							<option value="2">Bugatti</option>
							<option value="3">Opel</option>
							<option value="4">Lamborghini</option>
							<option value="5">Ferrari</option>
							<option value="6">Mercedes</option>
							<option value="7">Renault</option>
							<option value="8">Peugeot</option>
						</select>
						
						<small id="colorHelp" class="form-text text-muted mb-2">Couleur de votre véhicule.</small>
						<select class="form-control mb-2" name="couleur" aria-describedby="colorHelp">
							<option value="1">Rouge</option>
							<option value="2">Vert</option>
							<option value="3">Bleu</option>
							<option value="4">Jaune</option>
							<option value="5">Rose</option>
							<option value="6">Gris Métalisé</option>
							<option value="7">Noir</option>
							<option value="8">Anthracite</option>
						</select>

						<small id="nbPlacesHelp" class="form-text text-muted mb-2">Nombre de places pour ce véhicule.</small>
						<input type="text" name="nb_places" placeHolder="Entrez le nombre de places proposées." aria-describedby="nbPlacesHelp"/>

						<small id="immatHelp" class="form-text text-muted mb-2">Immatriculation du véhicule.</small>
						<input type="text" name="immat" placeHolder="Entrez votre plaque d'immatriculation." aria-describedby="immatHelp"/>

						<input type="submit" value="Ajouter" class="btn btn-primary btn-block btn-form mt-4"/>
					</div>
				</form>
				<?php
			}
			?>

		<!-- Biographie -->
		<form method="post" action="profile/edit_bio" enctype="multipart/form-data" class="login-form d-flex flex-column justify-content-center">
			<p class="py-3"><u>Biographie</u> :</p>
			<textarea name="biographie" placeHolder="Que faites-vous dans la vie ?"><?= $this->data['infos']['biography'] ?></textarea>
			<input type="submit" value="Modifier" class="btn btn-primary btn-block btn-form mt-4"/>
		</form>

		<!-- Avatar -->
		<form method="post" action="profile/edit_avatar" enctype="multipart/form-data" class="login-form d-flex flex-column justify-content-center">
			<p class="py-3"><u>Autre(s)</u> :</p>
			<div class="custom-file">
				<input type="file" name="file" class="custom-file-input" id="avatar-upload" lang="fr">
				<label class="custom-file-label" for="avatar-upload">Avatar</label>
			</div>
			<input type="submit" value="Appliquer" class="btn btn-primary btn-block btn-form mt-4"/>
		</form>
	</section>
</main>