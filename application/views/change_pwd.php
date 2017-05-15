<div class="container" style="margin-bottom: 30px;">
    <h2><?= $title ?></h2>
    <div class="card-panel">
    <?= $message ?>
    <?= validation_errors() ?>
    <?= form_open('user/change_password', 'class="col s12"') ?>
        <div class="row">
          <div class="input-field col s12">
            <input id="password" type="password" class="validate" name="password">
            <label for="password">Entrez le mot de passe actuel</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="password" type="password" class="validate" name="new_password">
            <label for="new_password">Entrez le nouveau mot de passe</label>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="password" type="password" class="validate" name="passconf">
            <label for="passconf"">Confirmez le nouveau mot de passe</label>
          </div>
        </div>        
    <button type="submit" class="waves-effect waves-light btn"><i class="material-icons right">done</i>Envoyer</button>
    </form>
    </div>
</div>