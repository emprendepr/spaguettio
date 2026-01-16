<div class="spaguettio-chat-terms-container">
    <div class="spaguettio-chat-terms-header">
        <h1><?php echo ossn_print('spaguettio:chat:terms:title'); ?></h1>
    </div>
    
    <div class="spaguettio-chat-terms-content">
        <div class="terms-intro">
            <p><strong><?php echo ossn_print('spaguettio:chat:terms:header'); ?></strong></p>
        </div>
        
        <div class="terms-text">
            <h3>Términos y Condiciones / Terms and Conditions</h3>
            
            <div class="terms-section">
                <h4>1. Comportamiento Respetuoso / Respectful Behavior</h4>
                <p><?php echo ossn_print('spaguettio:chat:terms:content'); ?></p>
            </div>
            
            <div class="terms-section">
                <h4>2. Prohibiciones / Prohibitions</h4>
                <ul>
                    <li>No spam o mensajes repetitivos / No spam or repetitive messages</li>
                    <li>No lenguaje ofensivo o discriminatorio / No offensive or discriminatory language</li>
                    <li>No compartir información personal / Do not share personal information</li>
                    <li>No publicidad no autorizada / No unauthorized advertising</li>
                </ul>
            </div>
            
            <div class="terms-section">
                <h4>3. Consecuencias / Consequences</h4>
                <p>El incumplimiento de estas normas puede resultar en la suspensión temporal o permanente de tu acceso al chat.</p>
                <p>Violation of these rules may result in temporary or permanent suspension of your chat access.</p>
            </div>
            
            <div class="terms-section">
                <h4>4. Privacidad / Privacy</h4>
                <p>Tus mensajes serán almacenados en nuestra base de datos. No compartas información sensible o privada.</p>
                <p>Your messages will be stored in our database. Do not share sensitive or private information.</p>
            </div>
        </div>
        
        <div class="terms-actions">
            <form id="terms-form" method="post" action="<?php echo ossn_site_url('action/chat/accept_terms'); ?>">
                <?php echo ossn_plugin_view('input/security_token'); ?>
                <div class="button-container">
                    <button type="submit" name="action" value="decline" class="btn btn-decline">
                        <i class="fa fa-times"></i>
                        <?php echo ossn_print('spaguettio:chat:terms:decline'); ?>
                    </button>
                    <button type="submit" name="action" value="accept" class="btn btn-accept">
                        <i class="fa fa-check"></i>
                        <?php echo ossn_print('spaguettio:chat:terms:accept'); ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.spaguettio-chat-terms-container {
    max-width: 800px;
    margin: 40px auto;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.spaguettio-chat-terms-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 30px;
    text-align: center;
}

.spaguettio-chat-terms-header h1 {
    margin: 0;
    font-size: 28px;
}

.spaguettio-chat-terms-content {
    padding: 40px;
}

.terms-intro {
    background: #f0f4ff;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    border-left: 4px solid #667eea;
}

.terms-intro p {
    margin: 0;
    font-size: 16px;
    color: #333;
}

.terms-text {
    margin-bottom: 40px;
}

.terms-text h3 {
    color: #667eea;
    margin-bottom: 25px;
    font-size: 22px;
}

.terms-section {
    margin-bottom: 25px;
    padding: 20px;
    background: #fafafa;
    border-radius: 6px;
}

.terms-section h4 {
    color: #333;
    margin-top: 0;
    margin-bottom: 15px;
    font-size: 18px;
}

.terms-section p {
    color: #555;
    line-height: 1.6;
    margin: 10px 0;
}

.terms-section ul {
    margin: 10px 0;
    padding-left: 25px;
}

.terms-section li {
    color: #555;
    margin: 8px 0;
    line-height: 1.5;
}

.terms-actions {
    border-top: 2px solid #e0e0e0;
    padding-top: 30px;
}

.button-container {
    display: flex;
    gap: 20px;
    justify-content: center;
}

.btn {
    padding: 15px 40px;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 180px;
    justify-content: center;
}

.btn-accept {
    background: linear-gradient(135deg, #4caf50 0%, #45a049 100%);
    color: #fff;
    box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
}

.btn-accept:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(76, 175, 80, 0.4);
}

.btn-decline {
    background: #f44336;
    color: #fff;
    box-shadow: 0 4px 15px rgba(244, 67, 54, 0.3);
}

.btn-decline:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(244, 67, 54, 0.4);
}

@media (max-width: 600px) {
    .spaguettio-chat-terms-container {
        margin: 20px;
    }
    
    .spaguettio-chat-terms-content {
        padding: 20px;
    }
    
    .button-container {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
