<?php
	namespace Covoitudiant\Model;
	
	use Covoitudiant\Lib\Model;
	
	class Search extends Model
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
        
        public function find($id_depart, $id_dest, $days, $dep_time, $ret_time)
        {
			$this->query("CALL procMatchRoute(:depart, :destination, :lun, :mar, :mer, :jeu, :ven, :dep_time, :ret_time)");

			$this->bind(':depart', $id_depart);
			$this->bind(':destination', $id_dest);

			$this->bind(':lun', $days['Lundi']);
			$this->bind(':mar', $days['Mardi']);
			$this->bind(':mer', $days['Mercredi']);
			$this->bind(':jeu', $days['Jeudi']);
			$this->bind(':ven', $days['Vendredi']);

			$this->bind(':dep_time', $dep_time);
			$this->bind(':ret_time', $ret_time);

			return $this->resultSet();
		}
		
		public function accept_ride($id_ride)
		{
			$this->query('INSERT INTO ct_reservation (ID_User, ID_Trajet) VALUES (:id_user, :id_trajet)');

			$this->bind(':id_user', $_SESSION['id']);
			$this->bind(':id_trajet', $id_ride);

			$this->execute();
		}
    }