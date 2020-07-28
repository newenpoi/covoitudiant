<?php
	namespace Covoitudiant\Model;
	
    use Covoitudiant\Lib\Model;
    
    class Panel extends Model
    {
        public function get_formations()
        {
            // Récupère la liste des formations.
            $this->query("SELECT * FROM ct_formation");

            return $this->resultSet();
        }

        public function get_pending()
        {
            // Récupère les utilisateurs en attente d'affectation.
            $this->query("SELECT * FROM ct_pending WHERE id_formation IS NULL");

            return $this->resultSet();
        }

        public function get_validated()
        {
            // Récupère les utilisateurs validés.
            $this->query("SELECT * FROM ct_users a INNER JOIN ct_formation b ON b.id_formation = a.formation");

            return $this->resultSet();
        }

        public function get_switch()
        {
            $this->query('SELECT ct_users.email, ct_users.first_name, ct_users.last_name, ct_formation.id_formation, ct_formation.formation_name FROM ct_switch INNER JOIN ct_users ON ct_users.email = ct_switch.Email INNER JOIN ct_formation ON ct_formation.id_formation = ct_switch.ID_Formation WHERE ct_switch.Pending = 1');

            return $this->resultSet();
        }
    }