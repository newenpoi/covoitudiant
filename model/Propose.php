<?php
	namespace Covoitudiant\Model;
	
	use Covoitudiant\Lib\Model;
	
	class Propose extends Model
	{
		/*
			Vérifie que la ville de départ existe et renvoie son identifiant.
		*/

		public function find_city_id($ville)
		{
			$this->query('SELECT ville_id FROM ct_villes WHERE ville_nom_reel = :ville');

			$this->bind(':ville', $ville);

			return $this->single()['ville_id'];
		}

		/*
			Renvoie vrai si cet utilisateur possède un véhicule.
		*/

		public function has_vehicle()
		{
			$this->query('SELECT ID FROM ct_vehicle WHERE ID_User = :id_user');

			$this->bind(':id_user', $_SESSION['id']);

			return $this->single();
		}

		/*
			Renvoie vrai si cet utilisateur possède déjà un trajet.
		*/

		public function has_ride()
		{
			$this->query('SELECT ID FROM ct_trajets WHERE ID_User = :id_user');

			$this->bind(':id_user', $_SESSION['id']);

			return $this->single();
		}

		/*
			Ajoute une proposition de covoiturage.
		*/
		public function add_ride($id_depart, $id_destination, $places, $days, $depart, $arrivee, $retour)
		{
			$this->query('INSERT INTO ct_trajets (ID_User, ID_Depart, ID_Destination, Lun, Mar, Mer, Jeu, Ven, Depart, Arrivee, Retour) VALUES (:id_user, :id_dep, :id_dest, :lun, :mar, :mer, :jeu, :ven, :depart, :arrivee, :retour)');
			
			$this->bind(':id_user', $_SESSION['id']);

			$this->bind(':id_dep', $id_depart);
			$this->bind(':id_dest', $id_destination);

			$this->bind(':lun', $days['Lundi']);
			$this->bind(':mar', $days['Mardi']);
			$this->bind(':mer', $days['Mercredi']);
			$this->bind(':jeu', $days['Jeudi']);
			$this->bind(':ven', $days['Vendredi']);

			$this->bind(':depart', $depart);
			$this->bind(':arrivee', $arrivee);

			$this->bind(':retour', $retour);

			return $this->execute();
        }
    }