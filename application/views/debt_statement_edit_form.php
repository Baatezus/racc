<h1 class="page-title blur"><?= $title ?></h1>
<div id="message_container" class="blur">
</div>
<div ng-controller="FormController" id="main-content" class="blur">
<?= form_open('debt_statement/add', 'class="form-group register-form"') ?>
       
        <label for="type">Type de manifestation</label><br />
        <select name="type" class="form-control" style="position: relative; right: 46px; margin-bottom: 30px;">>
            <option></option>
            <option value="scolaire" selected>Scolaire</option>
            <option value="publique">Publique</option>
        </select>

        <label for="first_name">Nombre de spectateurs</label>
        <input required type="number" name="spec_nb" class="form-control"
                value="<?= $s->spec_nb ?>" /><br />

        <label for="spec_nb" >Prix de la location (hors TVA)</label>
        <input type="number" ng-keyup="calRefund()" name="rental_cost" requred
               id="spec_nb" class="" step="any"
               ng-model="rental_cost" />

        <input placeholder="Titre du film"  type="text" name="title" id="title" class="required-film-value" value="<?= $s->title  ?>" />

        <input placeholder="Réalisateur"  type="text" name="director" id="director" class="" value="<?= $s->director ?>" />

        <input placeholder="Pays"  type="text" name="country" id="country" class="" value="<?= $s->country ?>" />

        <input placeholder="Durée"  type="number" name="duration" id="duration" class="" value="<?= $s->duration ?>" />

        <input type="number" name="helped_by_cfwb"  value="<?= $s->helped_by_cfwb ?>" />

        <input type="number" name ="refund_amount" step="any"  value="{{refund_amount}}">
        
        <input type="number" name ="association_id" step="any"   value="<?= $s->id ?>">
        
        <input type="number" name ="format"  value="<?= $s->format ?>">
        
        <div class="btn-container">
            <input type="submit"  value="Envoyer" class="btn btn-success" />
        </div>
        
    </form>
</div>
<script src="<?= base_url() ?>js/angular/editStatementController.js"></script>