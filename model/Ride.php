<?php
	namespace Covoitudiant\Model;
	
	use Covoitudiant\Lib\Model;
	
	class Ride extends Model
	{
		public function get_ride()
		{
			/*
				Renvoie le trajet proposé par l'utilisateur.
			*/

			$this->query('SELECT a.ville_nom_reel AS Point_Depart, b.ville_nom_reel AS Destination, ID, Depart, Arrivee, Retour FROM ct_trajets INNER JOIN ct_villes a ON a.ville_id = ct_trajets.ID_Depart INNER JOIN ct_villes b ON b.ville_id = ct_trajets.ID_Destination WHERE ID_User = :id_user');
			
			$this->bind(':id_user', $_SESSION['id']);

			return $this->single();
		}

		public function get_reserved()
		{
			/*
				Renvoie les trajets souhaités par l'utilisateur.
			*/

			$this->query('SELECT ct_trajets.Depart, ct_trajets.Arrivee, ct_trajets.Retour, ct_users.email, ct_users.first_name, a.ville_nom_reel AS Point_Depart, b.ville_nom_reel AS Destination, ID_Trajet, Pending FROM ct_reservation INNER JOIN ct_trajets ON ct_trajets.id = ct_reservation.ID_Trajet INNER JOIN ct_users ON ct_users.id = ct_trajets.ID_User INNER JOIN ct_villes a ON a.ville_id = ct_trajets.ID_Depart INNER JOIN ct_villes b ON b.ville_id = ct_trajets.ID_Destination WHERE ct_reservation.ID_User = :id_user');
			
			$this->bind(':id_user', $_SESSION['id']);

			return $this->resultSet();
		}

		public function get_pending()
		{
			/*
				Renvoie les réservations en attente pour le trajet de l'utilisateur.
			*/

			$this->query('SELECT ct_villes.ville_nom_reel AS Lieu_Recuperation, ct_users.email, ct_users.first_name, ct_reservation.ID_User, ct_reservation.ID_Trajet FROM ct_users INNER JOIN ct_villes on ct_villes.ville_id = ct_users.loc INNER JOIN ct_reservation ON ct_reservation.ID_User = ct_users.id INNER JOIN ct_trajets ON ct_trajets.ID = ct_reservation.ID_Trajet WHERE ct_trajets.ID_User = :id_user AND ct_reservation.Pending = 1');

			$this->bind(':id_user', $_SESSION['id']);

			return $this->resultSet();
		}

		public function get_accepted()
		{
			/*
				Renvoie les réservations acceptées pour le trajet de l'utilisateur.
			*/

			$this->query('SELECT ct_villes.ville_nom_reel AS Lieu_Recuperation, ct_users.email, ct_users.first_name, ct_reservation.ID_User, ct_reservation.ID_Trajet FROM ct_users INNER JOIN ct_villes on ct_villes.ville_id = ct_users.loc INNER JOIN ct_reservation ON ct_reservation.ID_User = ct_users.id INNER JOIN ct_trajets ON ct_trajets.ID = ct_reservation.ID_Trajet WHERE ct_reservation.Pending = 0');

			$this->bind(':id_user', $_SESSION['id']);

			return $this->resultSet();
		}

		public function accept($id_user, $id_trajet)
		{
			// Supprime les autres réservations.
			$this->query('DELETE FROM ct_reservation WHERE ID_User = :id_user AND ID_Trajet NOT IN (:id_trajet)');

			$this->bind(':id_user', $id_user);
			$this->bind(':id_trajet', $id_trajet);

			$this->execute();
			
			// Accepte la réservation d'un utilisateur sur le trajet donné.
			$this->query('UPDATE ct_reservation SET Pending = 0 WHERE ID_User = :id_user AND ID_Trajet = :id_trajet');

			$this->bind(':id_user', $id_user);
			$this->bind(':id_trajet', $id_trajet);

			return $this->execute();
		}

		public function delete($id_trajet)
		{
			// Supprimer le trajet.
			$this->query('DELETE FROM ct_trajets WHERE ID = :id_trajet AND ID_User = :id_user');

			$this->bind(':id_trajet', $id_trajet);
			$this->bind(':id_user', $_SESSION['id']);

			$this->execute();

			// Supprimer les réservations liées au trajet.
			$this->query('DELETE FROM ct_reservation WHERE ID_User = :id_user AND ID_Trajet = :id_trajet');

			$this->bind(':id_user', $_SESSION['id']);
			$this->bind(':id_trajet', $id_trajet);

			return $this->execute();
		}

		public function cancel($id_trajet)
		{
			/*
				Supprime la réservation de l'utilisateur sur le trajet spécifié.
			*/

			$this->query('DELETE FROM ct_reservation WHERE ID_User = :id_user AND ID_Trajet = :id_trajet');

			$this->bind(':id_user', $_SESSION['id']);
			$this->bind(':id_trajet', $id_trajet);

			return $this->execute();
		}
    }