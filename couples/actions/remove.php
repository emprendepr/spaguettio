<?php
/**
 * Rechazar solicitud de pareja o eliminar relación existente
 */

if(ossn_is_xhr()){
    header('Content-Type: application/json');
}

$user = ossn_loggedin_user();
if(!$user){
    $msg = ossn_print('ossn:login:required');
    if(!ossn_is_xhr()){
        ossn_trigger_message($msg, 'error');
        redirect(REF);
    } else {
        echo json_encode(array('type' => 0, 'text' => $msg));
        exit;
    }
}

$id = (int) input('id');
if(!$id){
    $msg = ossn_print('couples:error:generic');
    if(!ossn_is_xhr()){
        ossn_trigger_message($msg, 'error');
        redirect(REF);
    } else {
        echo json_encode(array('type' => 0, 'text' => $msg));
        exit;
    }
}

$db = new OssnDatabase();
$db->statement("SELECT * FROM ossn_relationships
                WHERE id = '{$id}'
                LIMIT 1");
$rows = $db->get();
if(!$rows){
    $msg = ossn_print('couples:error:generic');
    if(!ossn_is_xhr()){
        ossn_trigger_message($msg, 'error');
        redirect(REF);
    } else {
        echo json_encode(array('type' => 0, 'text' => $msg));
        exit;
    }
}
$rel = $rows[0];

$uid = (int) $user->guid;
if($rel->relation_from != $uid && $rel->relation_to != $uid){
    $msg = ossn_print('couples:error:generic');
    if(!ossn_is_xhr()){
        ossn_trigger_message($msg, 'error');
        redirect(REF);
    } else {
        echo json_encode(array('type' => 0, 'text' => $msg));
        exit;
    }
}

$ok = false;
if($rel->type == 'couple:request'){
    // Rechazar solicitud
    $db->statement("DELETE FROM ossn_relationships WHERE id = '{$id}'");
    $ok = $db->execute();
} elseif($rel->type == 'couple'){
    // Eliminar relación en ambas direcciones
    $a = (int) $rel->relation_from;
    $b = (int) $rel->relation_to;
    $db->statement("DELETE FROM ossn_relationships
                    WHERE ((relation_from = '{$a}' AND relation_to = '{$b}')
                       OR  (relation_from = '{$b}' AND relation_to = '{$a}'))
                      AND type = 'couple'");
    $ok = $db->execute();
}

if($ok){
    $msg = ossn_print('couples:removed');
    if(!ossn_is_xhr()){
        ossn_trigger_message($msg, 'success');
        redirect(REF);
    } else {
        echo json_encode(array('type' => 1, 'text' => $msg));
        exit;
    }
} else {
    $msg = ossn_print('couples:error:generic');
    if(!ossn_is_xhr()){
        ossn_trigger_message($msg, 'error');
        redirect(REF);
    } else {
        echo json_encode(array('type' => 0, 'text' => $msg));
        exit;
    }
}
