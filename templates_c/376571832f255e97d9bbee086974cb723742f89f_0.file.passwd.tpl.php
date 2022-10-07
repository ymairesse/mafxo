<?php
/* Smarty version 3.1.34-dev-7, created on 2022-10-03 11:36:36
  from '/home/yves/www/mdm/templates/passwd.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_633aad246cf944_70470519',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '376571832f255e97d9bbee086974cb723742f89f' => 
    array (
      0 => '/home/yves/www/mdm/templates/passwd.tpl',
      1 => 1664298442,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_633aad246cf944_70470519 (Smarty_Internal_Template $_smarty_tpl) {
?><div class="container">

<h2>Changement du mot de passe</h2>

<form id="form-passwd" autocomplete="off">

    <div class="col-md-6 col-xs-12">

        <div class="form-group">
            <label for="passwd">Mot de passe souhaité *</label>
            <input type="password" 
                class="form-control pwd" 
                id="passwd" 
                name="passwd" 
                minlength="6" 
                maxlength="12" 
                placeholder="Le mot de passe que vous souhaitez utiliser"
                autocomplete="off">
        </div>

    </div>

    <div class="col-md-6 col-xs-12">

        <div class="form-group">
            <label for="passwd">Mot de passe souhaité *</label>
            <input type="password" 
                class="form-control pwd" 
                id="passwd2" 
                name="passwd2" 
                minlength="6" 
                maxlength="12" 
                placeholder="Répétez le mot de passe que vous souhaitez utiliser"
                autocomplete="off">
        </div>

    </div>

    <button type="button" class="btn btn-primary pull-right" id="btn-save">Envoyer</button>

    <div class="clearfix"></div>
    
    <button type="button" class="btn btn-info btn-xs" id="btn-voir">Afficher le mot de passe</button>

</form>

</div>

<?php echo '<script'; ?>
>

    $(document).ready(function() {

        $('#btn-voir').click(function (){
            if ($('input.pwd').prop('type') == 'text')
                $('input.pwd').prop('type', 'password');
                else $('input.pwd').prop('type', 'text');
        })

        $('#btn-save').click(function() {
            if ($('#form-passwd').valid()) {
                var formulaire = $('#form-passwd').serialize();
                
                $.post('inc/saveNewPwd.inc.php', {
                    formulaire: formulaire
                }, function(resultat){
                    bootbox.alert({
                        title: 'Enregistrement',
                        message: resultat
                    })
                })
            }
        })

        $('#form-passwd').validate({
            rules: {
                passwd: {
                    minlength: 6,
                    maxlength: 12,
                },
                passwd2: {
                    equalTo: "#passwd"
                }
            },
            messages: {
                passwd: 'Au moins 6 signes, lettres et chiffres.',
                passwd2: 'Les deux versions diffèrent',
            }
        });

    })
<?php echo '</script'; ?>
><?php }
}
