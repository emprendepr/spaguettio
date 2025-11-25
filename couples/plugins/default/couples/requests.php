<?php
/**
 * Página: ver solicitudes de pareja recibidas
 */

$user = ossn_loggedin_user();
if(!$user){
    echo ossn_print('ossn:login:required');
    return;
}

$c = new Couples();
$requests = $c->getRequestsForUser($user->guid);
?>
<div class="ossn-layout-module">
    <div class="module-title">
        <?php echo ossn_print('couples:requests:title'); ?>
    </div>
    <div class="module-contents">
        <?php if(!$requests){ ?>
            <p><?php echo ossn_print('couples:requests:none'); ?></p>
        <?php } else { ?>
            <ul class="list-unstyled">
                <?php foreach($requests as $row){
                    $from = ossn_user_by_guid($row->user_guid);
                    if(!$from){ continue; }
                    $accept_url = ossn_site_url("action/couples/accept?id={$row->id}", true);
                    $remove_url = ossn_site_url("action/couples/remove?id={$row->id}", true);
                ?>
                    <li style="margin-bottom:10px;">
                        <strong><?php echo $from->fullname; ?></strong><br />
                        <span><?php echo ossn_print('couples:display', array($row->relationship, $from->fullname)); ?></span><br />
                        <a href="<?php echo $accept_url; ?>" class="btn btn-success btn-sm">
                            <?php echo ossn_print('couples:btn:accept'); ?>
                        </a>
                        <a href="<?php echo $remove_url; ?>" class="btn btn-danger btn-sm">
                            <?php echo ossn_print('couples:btn:reject'); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</div>
