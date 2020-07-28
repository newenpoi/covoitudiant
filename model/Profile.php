<?php
	namespace Covoitudiant\Model;
	
    use Covoitudiant\Lib\Model;
    
    class Profile extends Model
    {
        /*
            Récupère la liste des formations.
        */
        public function get_formations()
        {
            $this->query("SELECT * FROM ct_formation");

            return $this->resultSet();
        }

        public function switch_formation($id_formation)
        {
            $this->query("INSERT INTO ct_switch (ID_User, Formation) VALUES (:id_user, :id_formation) ON DUPLICATE KEY UPDATE Formation = :id_formation");

            $this->bind(":id_user", $_SESSION['id']);
            $this->bind(":id_formation", $id_formation);

            return $this->execute();
        }

        public function add_vehicle($mark, $color, $nb_places, $immat)
        {
            $this->query('INSERT INTO ct_vehicle (ID_User, Marque, Couleur, Places, Immatriculation) VALUES (:id_user, :mark, :color, :nb_places, :immat)');

            $this->bind(':id_user', $_SESSION['id']);
            $this->bind(':mark', $mark);
            $this->bind(':color', $color);
            $this->bind(':nb_places', $nb_places);
            $this->bind(':immat', $immat);

            return $this->execute();
        }

        /*
            Supprime notre véhicule.
        */
        public function del_vehicle()
        {
            $this->query('DELETE FROM ct_vehicle WHERE ID_User = :id_user');

            $this->bind(':id_user', $_SESSION['id']);

            $this->execute();
        }
        
        /*
            Récupère les informations liés au véhicule de l'utilisateur.

        */
        public function get_vehicle()
        {
            $this->query('SELECT ct_modele.Name AS Marque, ct_colors.Name AS Couleur, Places, Immatriculation FROM ct_vehicle INNER JOIN ct_modele ON ct_modele.ID = ct_vehicle.Marque INNER JOIN ct_colors ON ct_colors.ID = ct_vehicle.Couleur WHERE ct_vehicle.ID_User = :id_user');
            $this->bind(':id_user', $_SESSION['id']);

            return $this->single();
        }

        public function get_infos($id_user = null)
        {
            $id_user = ($id_user ? $id_user : $_SESSION['id']);
            
            $this->query('SELECT loc, first_name, last_name, biography, avatar FROM ct_users WHERE id = :id_user');
            $this->bind(':id_user', $id_user);

            return $this->single();
        }

        public function get_trajets($id_user)
        {
            $this->query('SELECT 1 FROM ct_trajets WHERE ID_User = :id_user');
            $this->bind(':id_user', $id_user);
            
            return $this->single();
        }

        public function get_comments($id_user)
        {
            $this->query('SELECT ct_users.first_name, ct_users.avatar, Content FROM ct_comments INNER JOIN ct_users ON ct_users.id = ct_comments.ID_User WHERE ID_Profile = :id_user');

            $this->bind(':id_user', $id_user);

            return $this->resultSet();
        }

        public function edit_avatar($file_name)
        {
            $this->query('UPDATE ct_users SET avatar = :new_avatar WHERE ID = :id_user');

            $this->bind(':new_avatar', $file_name);
            $this->bind(':id_user', $_SESSION['id']);

            $this->execute();
        }

        public function edit_bio($bio)
        {
            $this->query('UPDATE ct_users SET biography = :bio WHERE id = :id_user');

            $this->bind(':bio', $bio);
            $this->bind(':id_user', $_SESSION['id']);

            $this->execute();
        }
    }