<?php
/**
 * Acción: eliminar relación o rechazar solicitud
 */

$user = ossn_loggedin_user();
if(!$user){
    ossn_trigger_message(ossn_print('ossn:login:required'), 'error');
    redirect(REF);
}

$id = (int) input('id');
if(!$id){
    ossn_trigger_message(ossn_print('couples:error:generic'), 'error');
    redirect(REF);
}

$c = new Couples();
if($c->removeRelationship($id, $user->guid)){
    ossn_trigger_message(ossn_print('couples:removed'), 'success');
} else {
    ossn_trigger_message(ossn_print('couples:error:generic'), 'error');
}

redirect(REF);
