<?php
/**
 * Bloque dentro del formulario de editar perfil.
 * Tiene su propio botón para enviar la solicitud de pareja
 * y un autocomplete para sugerir usuarios.
 */

$user = ossn_loggedin_user();
if(!$user){
    return;
}
?>
<hr />
<h4><?php echo ossn_print('couples:title'); ?></h4>

<style>
.couples-suggest-box {
    position: relative;
}
.couples-suggest-list {
    position: absolute;
    z-index: 9999;
    background: #ffffff;
    border: 1px solid #ccc;
    width: 100%;
    max-height: 200px;
    overflow-y: auto;
    margin-top: 2px;
    border-radius: 3px;
}
.couples-suggest-item {
    padding: 5px 8px;
    cursor: pointer;
}
.couples-suggest-item:hover {
    background: #f0f0f0;
}
.couples-suggest-empty {
    padding: 5px 8px;
    color: #777;
}
</style>

<form action="<?php echo ossn_site_url('action/couples/request', true); ?>" method="post">
    <div class="form-group couples-suggest-box">
        <label for="partner_username">
            <?php echo ossn_print('couples:label:username'); ?>
        </label>
        <input type="text"
               name="partner_username"
               id="partner_username"
               class="form-control"
               autocomplete="off"
               placeholder="@usuario (sin espacios)"
               />
        <div id="couples-suggest-list" class="couples-suggest-list" style="display:none;"></div>
    </div>

    <div class="form-group">
        <label for="relationship_text">
            <?php echo ossn_print('couples:label:relationship'); ?>
        </label>
        <input type="text"
               name="relationship_text"
               id="relationship_text"
               class="form-control"
               placeholder="<?php echo ossn_print('couples:placeholder'); ?>"
               />
    </div>

    <p class="ossn-text-help">
        <?php echo ossn_print('couples:hint:edit'); ?>
    </p>

    <button type="submit" class="btn btn-primary">
        <?php echo ossn_print('couples:sendrequest'); ?>
    </button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function(){
    var input  = document.getElementById('partner_username');
    var list   = document.getElementById('couples-suggest-list');
    if(!input || !list){ return; }

    var baseUrl = '<?php echo ossn_site_url('couples/suggest'); ?>';

    var lastQuery = '';
    var timer = null;

    function hideList() {
        list.style.display = 'none';
        list.innerHTML = '';
    }

    function showSuggestions(items) {
        if(!items || !items.length){
            list.innerHTML = '<div class="couples-suggest-empty"><?php echo ossn_print('couples:suggest:none'); ?></div>';
            list.style.display = 'block';
            return;
        }
        var html = '';
        items.forEach(function(item){
            var name = (item.fullname && item.fullname.length)
                ? item.fullname + ' (@' + item.username + ')'
                : '@' + item.username;
            html += '<div class="couples-suggest-item" data-username="' + item.username.replace(/"/g, '&quot;') + '">' +
                        name.replace(/</g, '&lt;').replace(/>/g, '&gt;') +
                    '</div>';
        });
        list.innerHTML = html;
        list.style.display = 'block';
    }

    input.addEventListener('keyup', function(){
        var q = input.value.trim();
        if(q.length < 2){
            hideList();
            return;
        }
        if(q === lastQuery){
            return;
        }
        lastQuery = q;

        if(timer){
            clearTimeout(timer);
        }
        timer = setTimeout(function(){
            var url = baseUrl + '?q=' + encodeURIComponent(q);
            fetch(url, { credentials: 'same-origin' })
                .then(function(r){ return r.json(); })
                .then(function(data){
                    showSuggestions(data);
                })
                .catch(function(){
                    hideList();
                });
        }, 250);
    });

    list.addEventListener('click', function(e){
        var target = e.target;
        if(target.classList.contains('couples-suggest-item')){
            var username = target.getAttribute('data-username');
            if(username){
                input.value = username;
                hideList();
            }
        }
    });

    // Ocultar lista si se hace click fuera
    document.addEventListener('click', function(e){
        if(!list.contains(e.target) && e.target !== input){
            hideList();
        }
    });
});
</script>
