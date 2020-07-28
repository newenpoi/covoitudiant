<?php
	namespace Covoitudiant\Model;
	
    use Covoitudiant\Lib\Model;
    
    class Ajax extends Model
    {
        public function get_cities()
        {
            $this->query("SELECT ville_nom_reel, ville_latitude_deg, ville_longitude_deg FROM ct_villes");

            return $this->resultSet();
        }

        public function add_formation($name)
        {
            $this->query("INSERT INTO ct_formation (formation_name) VALUES :f_name");
            
            $this->bind(':f_name', $name);
			
			return $this->execute();
        }

        public function aff_user($email, $id_formation)
        {
            $this->query("UPDATE ct_pending SET id_formation = :id_f WHERE email = :email");

            $this->bind(':id_f', $id_formation);
            $this->bind(':email', $email);

            return $this->execute();
        }

        public function get_token($email)
        {
            $this->query("SELECT token FROM ct_pending WHERE email = :email");

            $this->bind(':email', $email);

            return $this->single();
        }

        public function reaffect($email, $id_formation)
        {
            // Mettre à jour la table switch.
            $this->query('UPDATE ct_switch SET Pending = 0 WHERE Email = :email');
            $this->bind(':email', $email);
            $this->execute();

            // Mettre à jour la table utilisateurs.
            $this->query('UPDATE ct_users SET formation = :id_formation WHERE email = :email');
            $this->bind(':id_formation', $id_formation);
            $this->bind(':email', $email);

            return $this->execute();
        }

        public function add_admin($email)
        {
            return false;
        }
    }