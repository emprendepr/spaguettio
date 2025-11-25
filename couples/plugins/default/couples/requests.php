<?php
/**
 * Vista de solicitudes y parejas actuales.
 * Ruta: components/couples/plugins/default/couples/requests.php
 */

$user = ossn_loggedin_user();
if(!$user){
    return;
}

$db = new OssnDatabase();
$uid = (int) $user->guid;

// Solicitudes recibidas (couple:request donde el to es el usuario)
$db->statement("SELECT * FROM ossn_relationships
                WHERE relation_to = '{$uid}'
                  AND type = 'couple:request'
                ORDER BY time_created DESC");
$incoming = $db->get();

// Parejas actuales (couple donde from o to es el usuario)
$db->statement("SELECT * FROM ossn_relationships
                WHERE (relation_to = '{$uid}' OR relation_from = '{$uid}')
                  AND type = 'couple'
                ORDER BY time_created DESC");
$current = $db->get();
?>
<div class="ossn-couples-page">
    <h3><?php echo ossn_print('couples:requests:incoming'); ?></h3>
    <?php
    if(!$incoming){
        echo '<p>' . ossn_print('couples:requests:none') . '</p>';
    } else {
        echo '<ul class="ossn-list">';
        foreach($incoming as $rel){
            $from = ossn_user_by_guid($rel->relation_from);
            if(!$from){
                continue;
            }
            $txt = $rel->subtype;
            if(empty($txt)){
                $txt = ossn_print('couples:placeholder');
            }
            $url_accept = ossn_site_url("action/couples/accept?id={$rel->id}", true);
            $url_reject = ossn_site_url("action/couples/remove?id={$rel->id}", true);
            echo '<li>';
            echo ossn_print('couples:label:relationship') . ': ';
            echo htmlspecialchars($txt, ENT_QUOTES, 'UTF-8') . ' ';
            echo htmlspecialchars($from->fullname, ENT_QUOTES, 'UTF-8');
            echo '<br />';
            echo '<a class="btn btn-success btn-sm" href="' . $url_accept . '">' . ossn_print('couples:accept') . '</a> ';
            echo '<a class="btn btn-danger btn-sm" href="' . $url_reject . '">' . ossn_print('couples:reject') . '</a>';
            echo '</li>';
        }
        echo '</ul>';
    }

    echo '<hr />';
    echo '<h3>' . ossn_print('couples:requests:current') . '</h3>';

    if(!$current){
        echo '<p>' . ossn_print('couples:requests:none') . '</p>';
    } else {
        echo '<ul class="ossn-list">';
        foreach($current as $rel){
            $other_guid = ($rel->relation_from == $uid) ? $rel->relation_to : $rel->relation_from;
            $other = ossn_user_by_guid($other_guid);
            if(!$other){
                continue;
            }
            $txt = $rel->subtype;
            if(empty($txt)){
                $txt = ossn_print('couples:placeholder');
            }
            $url_remove = ossn_site_url("action/couples/remove?id={$rel->id}", true);
            echo '<li>';
            echo htmlspecialchars($txt, ENT_QUOTES, 'UTF-8') . ' ';
            echo htmlspecialchars($other->fullname, ENT_QUOTES, 'UTF-8');
            echo '<br />';
            echo '<a class="btn btn-danger btn-sm" href="' . $url_remove . '">' . ossn_print('couples:remove') . '</a>';
            echo '</li>';
        }
        echo '</ul>';
    }
    ?>
</div>
