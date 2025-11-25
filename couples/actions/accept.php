<?php
/**
 * Aceptar solicitud de pareja (crear relaciones couple en ambas direcciones)
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
                  AND type = 'couple:request'
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

if((int)$rel->relation_to !== (int)$user->guid){
    $msg = ossn_print('couples:error:generic');
    if(!ossn_is_xhr()){
        ossn_trigger_message($msg, 'error');
        redirect(REF);
    } else {
        echo json_encode(array('type' => 0, 'text' => $msg));
        exit;
    }
}

$from = (int) $rel->relation_from;
$to   = (int) $rel->relation_to;
$text = addslashes($rel->subtype);
$time = time();

// Eliminar solicitud
$db->statement("DELETE FROM ossn_relationships WHERE id = '{$id}'");
$db->execute();

// Crear pareja en ambas direcciones
$db->statement("INSERT INTO ossn_relationships
                (relation_from, relation_to, type, time_created, subtype)
                VALUES
                ('{$from}', '{$to}', 'couple', '{$time}', '{$text}')");
$ok1 = $db->execute();

$db->statement("INSERT INTO ossn_relationships
                (relation_from, relation_to, type, time_created, subtype)
                VALUES
                ('{$to}', '{$from}', 'couple', '{$time}', '{$text}')");
$ok2 = $db->execute();

if($ok1 && $ok2){
    $msg = ossn_print('couples:accepted');
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
