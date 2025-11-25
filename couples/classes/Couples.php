<?php

class Couples extends OssnDatabase {

    /**
     * Insertar solicitud de pareja.
     */
    public function sendRequest($user_guid, $partner_guid, $relationship){
        $user_guid    = (int) $user_guid;
        $partner_guid = (int) $partner_guid;
        $relationship = addslashes($relationship);
        $time_created = time();

        $sql = "INSERT INTO ossn_couples
                    (user_guid, partner_guid, relationship, status, time_created)
                VALUES
                    ('{$user_guid}', '{$partner_guid}', '{$relationship}', 'pending', '{$time_created}')";

        $this->statement($sql);
        return $this->execute();
    }

    /**
     * Solicitudes pendientes para un usuario.
     */
    public function getRequestsForUser($guid){
        $guid = (int) $guid;
        $sql = "SELECT * FROM ossn_couples
                WHERE partner_guid = '{$guid}'
                  AND status = 'pending'";
        $this->statement($sql);
        return $this->get();
    }

    /**
     * Aceptar solicitud.
     */
    public function acceptRequest($id, $partner_guid){
        $id           = (int) $id;
        $partner_guid = (int) $partner_guid;

        $sql = "UPDATE ossn_couples
                SET status = 'accepted'
                WHERE id = '{$id}' AND partner_guid = '{$partner_guid}'";

        $this->statement($sql);
        return $this->execute();
    }

    /**
     * Eliminar relación o rechazar.
     */
    public function removeRelationship($id, $owner_guid){
        $id         = (int) $id;
        $owner_guid = (int) $owner_guid;

        $sql = "DELETE FROM ossn_couples
                WHERE id = '{$id}' AND (user_guid = '{$owner_guid}' OR partner_guid = '{$owner_guid}')";

        $this->statement($sql);
        return $this->execute();
    }

    /**
     * Relaciones aceptadas de un usuario.
     */
    public function getAcceptedForUser($guid){
        $guid = (int) $guid;

        $sql = "SELECT * FROM ossn_couples
                WHERE (user_guid = '{$guid}' OR partner_guid = '{$guid}')
                  AND status = 'accepted'";

        $this->statement($sql);
        return $this->get();
    }

    /**
     * Buscar usuarios para el autocomplete de parejas.
     * Busca por username, nombre o apellido.
     */
    public function searchUsers($query){
        $query = trim($query);
        if($query === '' || strlen($query) < 2){
            return false;
        }

        $like = addslashes($query . '%');

        $sql = "SELECT guid, username, first_name, last_name
                FROM ossn_users
                WHERE username  LIKE '{$like}'
                   OR first_name LIKE '{$like}'
                   OR last_name  LIKE '{$like}'
                ORDER BY username ASC
                LIMIT 10";

        $this->statement($sql);
        return $this->get();
    }
}
