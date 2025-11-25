<?php
/**
 * Acción: enviar solicitud de pareja desde editar perfil.
 */

$user = ossn_loggedin_user();
if(!$user){
    ossn_trigger_message(ossn_print('ossn:login:required'), 'error');
    redirect(REF);
}

$username     = trim(input('partner_username'));
$relationship = trim(input('relationship_text'));

if(empty($username) || empty($relationship)){
    ossn_trigger_message(ossn_print('couples:error:nopartner'), 'error');
    redirect(REF);
}

// 1) Intentar por username exacto
$partner = ossn_user_by_username($username);

// 2) Si no lo encuentra, intentar usar el buscador (por nombre / apellido)
if((!$partner || !$partner->guid)){
    $c = new Couples();
    $found = $c->searchUsers($username);
    if($found && isset($found[0]->guid)){
        $partner = ossn_user_by_guid($found[0]->guid);
    }
}

if(!$partner || !$partner->guid){
    ossn_trigger_message(ossn_print('couples:error:notfound'), 'error');
    redirect(REF);
}

if($partner->guid == $user->guid){
    ossn_trigger_message(ossn_print('couples:error:self'), 'error');
    redirect(REF);
}

$c = new Couples();
if($c->sendRequest($user->guid, $partner->guid, $relationship)){
    ossn_trigger_message(ossn_print('couples:request:sent'), 'success');
} else {
    ossn_trigger_message(ossn_print('couples:error:generic'), 'error');
}
redirect(REF);
