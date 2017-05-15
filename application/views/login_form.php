<div class="container" style="margin-bottom: 30px;">
    <h3><?= $title ?></h3>
    <?php if($newLogin) { ?>
    <div class=" green card-panel white-text">
        Votre inscription est bien enregistrée, vous pouvez désormais vos connecter. 
    </div>
    <?php } ?>
    <div class="card-panel">
    <?= $message ?>
    <?= validation_errors() ?>
    <?= form_open('user/login', 'class="col s12"') ?>
        <div class="row">
          <div class="input-field col s12">
            <input id="login" type="text" class="validate" name="login">
            <label for="login">Pseudo: </label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="password" type="password" class="validate" name="password">
            <label for="password" class="">Mot de passe</label>
          </div>
        </div>
    <button type="submit" class="waves-effect waves-light btn green darken-1"><i class="material-icons right">done</i>Envoyer</button>
    </form>
    </div>
    <div class="card-panel">
        <a class="pink-text text-lighten-1" href="<?= base_url() ?>index.php/user/forgot">
            <i class="material-icons left">perm_identity</i>
            J'ai oublié mon identifiant et/ou mon mot de passe...
        </a>
    </div>
</div>