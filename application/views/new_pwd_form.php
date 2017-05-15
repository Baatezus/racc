<div class="form-container">
<h5><?= $title ?></h5>
<?= validation_errors() ?>
<?= form_open('user/new_password', 'class="form-group"') ?>

    <label for="password">Entrez votre nouveau mot de passe: </label>
    <input type="password" name="password" class="" /><br />
    
    <label for="passconf">Confirmer le nouveau mot de passe: </label>
    <input type="password" name="passconf" class="" /><br />
    
    <input hidden name="token" value="<?= $token ?>" />
    <input hidden name="user_id" value="<?= $user_id ?>" />

    <input type="submit" name="submit" value="Envoyer" class="green darken-1" />

</form>
</div>
