<div class="container">
<h4 class="">Formulaire de déclaration de créance</h4>
<div id="message_container" class="blur">
</div>
<div ng-controller="FormController" id="main-content" class="blur">
    <div class="card-panel">
        <h5 class="pink-text text-lighten-1">Le film: </h5>
        <div id="search-engine" > 
            <div class="row">
                <div class="input-field col s12">
                    <input type="text" ng-keyup="filterFilms()" ng-model="val"
                           id="saisie" class="" />
                    <label for="saisie">
                        <i class="material-icons left">search</i>
                        Rechercher un film
                    </label>
                </div>
            </div>
            <div ng-repeat="x in results | limitTo: 5" class="">
                <p class="film-element" ng-click="selectFilm(x)">{{ x.titre }}</p>
            </div>
        </div>
        <div id="film-info">
        <p class="film-">{{ (title)? 'Titre du film: ' + title : '' }}</p>
        <p class="">{{ (director)? 'Réalisteur: ' + director : '' }}</p>
        <p class="">{{ (country)? 'Pays: ' + country : '' }}</p>
        <p class="">{{ (duration)? 'Durée : ' + duration + ' minutes': '' }}</p>
        <p ng-show="helped" >Ce film est aidé par la Fédération Wallonie Bruxelles</p>
        </div>
    </div>
    <?php if(strlen($message) > 0) { ?>
        <div class="card-panel red darken-1 white-text">
            <?= $message ?>
        </div>
    <?php } ?>
    <?php if(strlen(validation_errors()) > 0) { ?>
        <div class="card-panel red darken-1 white-text">
            <?= validation_errors() ?>
        </div>
    <?php } ?>
    <div class="card-panel">
    <h5 class="pink-text text-lighten-1">La projection: </h5>
    <?= form_open('debt_statement/add', 'class="form-group register-form"') ?>
    
    <div class="row">
        <div class="input-field col s4">
            <select name="format" required class="validate">
                <option>Choississez un format</option>
            <?php foreach ($formats as $f) { ?>
                <option value="<?= $f->id ?>"><?= $f->format ?></option>
            <?php } ?>
            </select>    
            <label for="format">Format</label>
        </div>
    </div>
        
    <div class="row">
        <div class="input-field col s12">        
            <input required type="text" name="address" class="validate"
                    value="<?= set_value('address') ?>" />
            <label for="address">Adresse de la projection</label>
        </div>
    </div>        
        
    <div class="row">
        <div class="input-field col s12">             
            <input autocomplete="off" type="text" ng-keyup="filterLocalities()"
                   ng-model="localityVal" id="saisie2" ng-value="displayedLocality" />
            <label for="saisie2">
                <i class="material-icons left">search</i>
                Chercher une commune (code postal ou nom)
            </label>
        </div>
    </div>     
        
    <p class="temp" id="{{x.id}}" ng-click="choose(x)" ng-repeat="x in localitiesRes">{{ x.postal_code + ' ' + x.name }}</p>

    <input id="locality" type="text"  hidden name="locality" value="{{locality}}" />         
        
    <div class="row">
        <div class="input-field col s4">          
            <select name="type" class="" style="position: relative; right: 46px; margin-bottom: 30px;">
                <option>Choississez un type de manifestation</option>
                <option value="scolaire">Scolaire</option>
                <option value="publique">Publique</option>
            </select>
            <label for="type">Type de manifestation</label>
        </div>
    </div>            
        
    <div id="firefox-alert">
    </div>
    <div class="row">
        <div class="input-field col s4" id="">    
            <label for="date" id="date-label">Date et heure de la projection: </label><br />
            <input required type="datetime-local" name="date" class="validate"
                    value="<?= set_value('date') ?>" />
            
        </div>
    </div>         
    <div class="row">
        <div class="input-field col s12">            
            <input required type="number" name="spec_nb" class="validate"
                    value="<?= set_value('spec_nb') ?>" />
            <label for="first_name">Nombre de spectateurs</label>    
        </div>
    </div> 
    
    <div class="row">
        <div class="input-field col s12">            
            <input type="number" name="rental_cost" required
                   id="spec_nb" class="" step="any" />
            <label for="spec_nb" >Prix de la location (hors TVA)</label>
        </div>
    </div>         
        
        <input placeholder="Titre du film"  type="text" name="title" id="title" class="" value="{{ title }}" hidden />

        <input placeholder="Réalisateur"  type="text" name="director" id="director" class="" value="{{ director }}" hidden />

        <input placeholder="Pays"  type="text" name="country" id="country" class="" value="{{ country }}" hidden />

        <input placeholder="Durée"  type="number" name="duration" id="duration" class="" value="{{ duration }}" hidden />

        <input type="number" name="helped_by_cfwb" hidden value="{{ (helped) ? 1 : 0 }}" />
        
        <input type="number" name ="association_id" step="any"  hidden value="<?= $asso->id ?>">
        
        <div class="btn-container">
            <input type="submit"  value="Envoyer" class="btn btn-success green darken-1" />
        </div>
        
    </form>
    </div>
</div>
</div>
<script src="<?= base_url() ?>js/angular/formController.js"></script>
<script>
    if(navigator.userAgent.toLowerCase().indexOf('firefox') > -1){
        $('#firefox-alert').text('Exemple de format:  "2017-01-31T20:30" uniquement(utilisez un autre navigateur pour plus de facilité)');
        $('#firefox-alert').css({
            "border": "1 px solid"
        })
    }
</script>