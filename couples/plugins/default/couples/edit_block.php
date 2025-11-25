<?php
/**
 * Bloque "Parejas verificadas" en Editar perfil.
 * Versión simple sin AJAX: usa <datalist> y un formulario propio.
 */

$user = ossn_loggedin_user();
if(!$user){
    return;
}

// Cargar hasta 200 usuarios para el datalist
$db = new OssnDatabase();
$db->statement("SELECT guid, username, first_name, last_name
                FROM ossn_users
                ORDER BY username ASC
                LIMIT 200");
$users = $db->get();
?>
<hr />
<h4><?php echo ossn_print('couples:title'); ?></h4>

<form action="<?php echo ossn_site_url('action/couples/request', true); ?>" method="post">
    <?php echo ossn_view('input/securitytoken'); ?>

    <div class="form-group">
        <label for="partner_username">
            <?php echo ossn_print('couples:label:username'); ?>
        </label>
        <input type="text"
               name="partner_username"
               id="partner_username"
               class="form-control"
               list="couples-users-list"
               placeholder="@usuario (username exacto)" />

        <datalist id="couples-users-list">
            <?php
            if($users){
                foreach($users as $u){
                    $uname = $u->username;
                    $full  = trim($u->first_name . ' ' . $u->last_name);
                    if(!empty($full)){
                        $label = $full . ' (@' . $uname . ')';
                    } else {
                        $label = '@' . $uname;
                    }
                    ?>
                    <option value="<?php echo htmlspecialchars($uname, ENT_QUOTES, 'UTF-8'); ?>">
                        <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                    <?php
                }
            }
            ?>
        </datalist>
    </div>

    <div class="form-group">
        <label for="relationship_text">
            <?php echo ossn_print('couples:label:relationship'); ?>
        </label>
        <input type="text"
               name="relationship_text"
               id="relationship_text"
               class="form-control"
               placeholder="<?php echo ossn_print('couples:placeholder'); ?>" />
    </div>

    <p class="ossn-text-help">
        <?php echo ossn_print('couples:hint:edit'); ?>
    </p>

    <button type="submit" class="btn btn-primary">
        <?php echo ossn_print('couples:sendrequest'); ?>
    </button>
</form>
