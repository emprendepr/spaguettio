<?php
/**
 * Vista de administración del Lounge
 */

// Cargar datos
$messages = lounge_load_messages();
$users = lounge_load_users();
$totalMessages = count($messages);
$totalUsers = count($users);

// Calcular estadísticas
$userMessages = [];
foreach ($messages as $msg) {
    if ($msg['type'] === 'user') {
        if (!isset($userMessages[$msg['username']])) {
            $userMessages[$msg['username']] = 0;
        }
        $userMessages[$msg['username']]++;
    }
}
arsort($userMessages);
?>

<div class="lounge-admin-container">
    <div class="row">
        <div class="col-md-3">
            <div class="well">
                <h4><?php echo ossn_print('lounge:admin:stats:total'); ?></h4>
                <h2><?php echo $totalMessages; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="well">
                <h4><?php echo ossn_print('lounge:admin:stats:users'); ?></h4>
                <h2><?php echo $totalUsers; ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="well">
                <h4><?php echo ossn_print('lounge:admin:stats:system'); ?></h4>
                <h2><?php echo count(array_filter($messages, fn($m) => $m['type'] === 'system')); ?></h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="well">
                <h4><?php echo ossn_print('lounge:admin:stats:unique'); ?></h4>
                <h2><?php echo count($userMessages); ?></h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <h3><?php echo ossn_print('lounge:admin:actions'); ?></h3>
                <a href="<?php echo ossn_site_url('lounge'); ?>" class="btn btn-success">
                    <?php echo ossn_print('lounge:admin:goto:chat'); ?>
                </a>
            </div>
        </div>
    </div>

    <?php if (count($userMessages) > 0): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="well">
                <h3><?php echo ossn_print('lounge:admin:top:users'); ?></h3>
                <ul class="list-group">
                    <?php foreach (array_slice($userMessages, 0, 10) as $uname => $count): ?>
                        <li class="list-group-item">
                            <strong><?php echo htmlspecialchars($uname); ?></strong>
                            <span class="badge"><?php echo $count; ?> mensajes</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="well">
                <h3><?php echo ossn_print('lounge:admin:users:connected'); ?> (<?php echo $totalUsers; ?>)</h3>
                <?php if (empty($users)): ?>
                    <p><?php echo ossn_print('lounge:admin:no:users'); ?></p>
                <?php else: ?>
                    <ul class="list-group">
                        <?php foreach ($users as $sessionId => $user): ?>
                            <li class="list-group-item">
                                <strong style="color: <?php echo $user['color']; ?>">
                                    <?php echo htmlspecialchars($user['username']); ?>
                                </strong>
                                <br>
                                <small>Última actividad: <?php echo date('Y-m-d H:i:s', $user['last_activity']); ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="well">
                <h3><?php echo ossn_print('lounge:admin:messages:recent'); ?> (<?php echo $totalMessages; ?>)</h3>
                <?php if (empty($messages)): ?>
                    <p><?php echo ossn_print('lounge:admin:no:messages'); ?></p>
                <?php else: ?>
                    <div style="max-height: 400px; overflow-y: auto;">
                        <?php foreach (array_reverse($messages) as $msg): ?>
                            <div class="alert <?php echo $msg['type'] === 'system' ? 'alert-warning' : 'alert-info'; ?>">
                                <strong style="color: <?php echo $msg['color']; ?>">
                                    <?php echo htmlspecialchars($msg['username']); ?>
                                </strong>
                                <small>(<?php echo $msg['time']; ?>)</small>
                                <br>
                                <?php echo htmlspecialchars($msg['message']); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
.lounge-admin-container .well h2 {
    color: #764ba2;
    font-size: 36px;
    margin: 10px 0;
}
</style>
