<div class="container">
    <?php if(strlen($message) > 0 || strlen(validation_errors() > 0)) { ?>
    <div class="card-panel red white-text">
        <?= $message ?>
        <?= validation_errors() ?>
    </div>   
    <?php } ?>
<div class="card-panel">    
<h2><?= $title ?></h2>
<?php if(!$email_sent) { ?>
<?= form_open('user/forgot', 'class="form-group"') ?>

       <div class="row">            
            <div class="input-field col s12">               
                <input required type="email" name="email" class="validate"
                    value="<?= set_value('email') ?>" />
                <label for="eamil">Adresse mail</label>
            </div>
        </div>

    <input type="submit" name="submit" value="M'envoyer un mail pour changer mon mot de passe."
           class="btn btn-success green darken-1" />

</form>
</div>
<?php } else { ?>
<h3>Changer son mot de passe.</h3>
<p>Un email vous à été envoyé à <span class="" style="color: #20BB46"><?= $email ?></span>.<br />
    Il contient les instruction pour obtenir un nouveau mot de passe.
</p>
<?php } ?>
</div>
</div>