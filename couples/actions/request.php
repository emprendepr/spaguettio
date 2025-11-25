<?php
/**
 * Enviar solicitud de pareja (couple:request)
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

$username = trim(input('partner_username'));
$relationship = trim(input('relationship_text'));

if(empty($username) || empty($relationship)){
    $msg = ossn_print('couples:error:nopartner');
    if(!ossn_is_xhr()){
        ossn_trigger_message($msg, 'error');
        redirect(REF);
    } else {
        echo json_encode(array('type' => 0, 'text' => $msg));
        exit;
    }
}

$partner = ossn_user_by_username($username);
if(!$partner || !$partner->guid){
    $msg = ossn_print('couples:error:notfound');
    if(!ossn_is_xhr()){
        ossn_trigger_message($msg, 'error');
        redirect(REF);
    } else {
        echo json_encode(array('type' => 0, 'text' => $msg));
        exit;
    }
}

if($partner->guid == $user->guid){
    $msg = ossn_print('couples:error:self');
    if(!ossn_is_xhr()){
        ossn_trigger_message($msg, 'error');
        redirect(REF);
    } else {
        echo json_encode(array('type' => 0, 'text' => $msg));
        exit;
    }
}

$db   = new OssnDatabase();
$from = (int) $user->guid;
$to   = (int) $partner->guid;

// Verificar si ya existe solicitud pendiente
$db->statement("SELECT id FROM ossn_relationships
                WHERE relation_from = '{$from}'
                  AND relation_to   = '{$to}'
                  AND type          = 'couple:request'");
$exist = $db->get();
if($exist){
    $msg = ossn_print('couples:error:already:requested');
    if(!ossn_is_xhr()){
        ossn_trigger_message($msg, 'error');
        redirect(REF);
    } else {
        echo json_encode(array('type' => 0, 'text' => $msg));
        exit;
    }
}

// Crear relación de solicitud
$time     = time();
$rel_text = addslashes($relationship);

$db->statement("INSERT INTO ossn_relationships
                (relation_from, relation_to, type, time_created, subtype)
                VALUES
                ('{$from}', '{$to}', 'couple:request', '{$time}', '{$rel_text}')");

if($db->execute()){
    $msg = ossn_print('couples:request:sent');
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
