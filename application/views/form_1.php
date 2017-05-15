<h1 class="page-title blur">Formulaire de déclaration de créance</h1>
<div id="message_container" class="blur">
</div>
<div ng-controller="FormController" id="main-content" class="blur">
    <div id="search-engine" > 
        <input placeholder="Rechercher un film"  type="text" ng-keyup="filterFilms()" ng-model="val" id="saisie" class="" />
        <div ng-repeat="x in results | limitTo: 5" class="films-list">
            <p class="films-list-element" ng-click="selectFilm(x)">{{ x.titre }}</p>
        </div>
    </div>
    <div id="film-info">
    <p class="float">{{ (title)? 'Titre du film: ' + title : '' }}</p>
    <p class="float">{{ (director)? 'Réalisteur: ' + director : '' }}</p>
    <p class="float">{{ (country)? 'Pays: ' + country : '' }}</p>
    <p class="float">{{ (duration)? 'Durée : ' + duration + ' minutes': '' }}</p>
    <p ng-show="helped" >Ce film est aidé par la Fédération Wallonie Bruxelles</p>
    </div>
    <hr />
    <form method="post" action="<?= base_url() ?>index.php/refundrequest/add" onsubmit="return checkFrm(this)" class="" id="main_form">
        <div class="cover-div" hidden>
            <div id="confirm_div" class="confirm_div" hidden>
                <h2>Confirmer ces informations: <h2>
                <h3>Le film</h3>
                <p>Titre: {{ title }}</p>
                <p>Réalisateur:  {{ director }}</p>
                <h3>L'association</h3>
                <p>Numéro de compte: BE{{ account_nb1 + ' ' +  account_nb2 + ' ' +  account_nb3 + ' ' +  account_nb4 }}</p>
                <h3>La projection</h3>
                <p>Montant de la location (HT): {{ rental_cost }} €</p>
                <h3>Montant remboursé: {{ refund_amount }} €</h3>
                <button type="submit" class="okBtn">Ok</button>
                <button class="cancelBtn" type="button" >Annuler</button>
                <div class="clear-both"></div>
            </div>
        </div>
        <fieldset id="entity_fieldset">
            <legend><span class="legend_text1">Coordonnées de l'association: </span></legend>
            <p class="form_element">
                <label for="applicant_name">Nom du demandeur: </label><br />
                <input placeholder="Nom du demandeur"  type="text" name="applicant_last_name" id="name" class="required"/>
            </p>
            <p class="form_element">
                <label for="applicant_name">Prenom du demandeur: </label><br />
                <input placeholder="Nom du demandeur"  type="text" name="applicant_first_name" id="name" class="required"/>
            </p>            
            <p class="form_element">
                <label for="association_name">Nom de l'association: </label><br />
                <input placeholder="Nom de l'association"  type="text" name="association_name" id="association_name" class="required"/>
            </p>
            <p class="form_element">
                <label for="association_address">Adresse: </label><br />
                <input placeholder="Adresse"  type="text" name="association_address" id="address" class="required"/>
            </p>
            <p class="form_element">
                <label for="locality">Commune: </label><br />
                <input placeholder="Chercher une commune (code postal ou nom)"  type="text" ng-keyup="filterLocalities()" ng-model="localityVal" id="saisie" class="" />
                <select name="association_locality" class="required_select empty">
                    <option ng-repeat="x in localitiesRes" value="{{ x.id + '|' + x.postal_code + '|' + x.name }}">{{ x.postal_code + ' ' + x.name }}</option>
                </select>
            </p>
            <p class="form_element">
                <label for="email">Adresse mail: </label><br />
                <input placeholder="Adresse mail"  type="email" name="email" id="email" class="required"/>
            </p>
            <p class="form_element">
                <label for="phone_nb">Numéro de téléphone: </label><br />
                <input placeholder="Numéro de téléphone"  type="text" name="phone_nb" id="phone_nb" class="required"/>
            </p>
            <p class="form-element" id="association-type-div">           
                <input type="radio" name="association_type" onclick="display('business')" value="asbl" class="chk unchecked" id="asbl_radio_input" /><span class="chk-txt">ASBL</span>
                <input type="radio" name="association_type" onclick="display('nat_reg')" value="association" class="chk unchecked" id="" /><span class="chk-txt">Association de fait</span>
            </p>
        </fieldset> 
        <fieldset id="bank-account-fieldset">
            <legend><span class="legend_text2">Coordonnées banquaire: </span></legend>    
            <p class="form_element">
                <label for="account_name">Nom d titulaire: </label><br />
                <input placeholder="Nom du demandeur"  type="text" name="account_name" id="name" class="required"/>
            </p>
            <p class="form-element" id="account_div">           
                <label for="account_nb">Numéro de compte (IBAN uniquement, au format : BExx xxxx xxxx xxxx)</label><br />
                <span style="margin-left: 40px; font-size: 1.4em;" >BE</span>
                <input type="number" name="account_nb1" id="account_nb1" required
                       class="required account-input" type="number" min="10" max="99" 
                       ng-model="account_nb1" id="account-input1" maxlength="2"
                       style="width: 40px !important; text-align: center; margin-left: 5px"
                       oninput="maxLengthCheck(this)" />
                <input type="number" name="account_nb2" id="account_nb2" required
                       class="required account-input" type="number" min="1000" max="9999" 
                       ng-model="account_nb2" id="account-input2" maxlength="4"
                       style="width: 80px !important; text-align: center; margin-left: 5px"
                       oninput="maxLengthCheck(this)" />
                <input type="number" name="account_nb3" id="account_nb3" required
                       class="required account-input" type="number" min="1000" max="9999" 
                       ng-model="account_nb3" id="account-input3" maxlength="4"
                       style="width: 80px !important; text-align: center; margin-left: 5px"
                       oninput="maxLengthCheck(this)" />
                <input type="number" name="account_nb4" id="account_nb4" required
                       class="required account-input" type="number" min="1000" max="9999"
                       ng-model="account_nb4" id="account-input4" maxlength="4"
                       style="width: 80px !important; text-align: center; margin-left: 5px"
                       oninput="maxLengthCheck(this)" />
            </p> 
            <p class="form_element">
                <label for="account_address">Adresse du titulaire: </label><br />
                <input placeholder="Adresse"  type="text" name="account_address" id="address" class="required"/>
            </p>
            <p class="form_element">
                <label for="locality">Commune: </label><br />
                <input placeholder="Chercher une commune (code postal ou nom)"  type="text" ng-keyup="filterAccountLocalities()" ng-model="accountLocalityVal" id="saisie" class="" />
                <select name="account_locality" class="required_select empty">
                    <option ng-repeat="x in accountLocalitiesRes" value="{{ x.id + '|' + x.postal_code + '|' + x.name }}">{{ x.postal_code + ' ' + x.name }}</option>
                </select>
            </p>
        </fieldset>
        <fieldset id="show_fieldset">
            <legend><span class="legend_text3">La projection: </span></legend>
            <p class="form-element">
                <label>Format: </label><br />
                <select name="format" class="form_element required_select" ng-model="format">
                    <option></option>
                    <option ng-repeat="x in formats" value="{{ x.id + '|' + x.format }}">{{ x.format }}</option>
                </select>               
            </p>            
            <p class="form_element">
                <label for="show_address">Adresse de la projection : </label><br />
                <input placeholder="Adresse de la projection"  type="text" name="show_address" id="address" class="required"/>
            </p>
            <p class="form_element">
                <label for="locality">Commune: </label><br />
                <input placeholder="Chercher une commune (code postal ou nom)"  type="text" ng-keyup="filterShowLocalities()" ng-model="showLocalityVal" id="saisie" class="" />
                <select name="show_locality" class="required_select empty">
                    <option ng-repeat="x in showLocalitiesRes" value="{{ x.id + '|' + x.postal_code + '|' + x.name }}">{{ x.postal_code + ' ' + x.name }}</option>
                </select>
            </p>
            <p class="form_element">
                <label for="date">date de la projection: </label><br />
                <input placeholder="Date de la projection"  type="date" name="date" id="date" class="required"/>
            </p>
            <p class="form_element">
                <label for="type">Type de manifestation: </label><br />
                <select name="type" class="form_element required_select">
                    <option></option>
                    <option value="scolaire">Scolaire</option>
                    <option value="publique">Publique</option>
                </select>
            <p class="form_element">
                <label for="spec_nb">Nombre de spectateurs</label>
                <input type="number"  name="spec_nb" id="spec_nb" class="required"/>
            <p>
            <p class="form_element">
                <label for="spec_nb" >Prix de la location (hors TVA)</label>
                <input type="number" ng-keyup="calRefund()" name="rental_cost" id="spec_nb" class="required" step="any" ng-model="rental_cost"/>
            <p>                
            </p>
        </fieldset>
                <input placeholder="Titre du film"  type="text" name="title" id="title" class="required-film-value" value="{{ title }}" hidden />

                <input placeholder="Réalisateur"  type="text" name="director" id="director" class="" value="{{ director }}" hidden />

                <input placeholder="Pays"  type="text" name="country" id="country" class="" value="{{ country }}" hidden />
                
                <input placeholder="Durée"  type="number" name="duration" id="duration" class="" value="{{ duration }}" hidden />

                <input type="number" name="helped_by_cfwb" hidden value="{{ (helped) ? 1 : 0 }}" />
                
                <input type="number" name="film_id" hidden value="{{ film_id }}" />
                
                <input type="number" name ="refund_amount" step="any"  hidden value="{{ refund_amount }}">
                
        <div id="send-div"><button type="submit">Envoyer</button></div>
    </form>
</div>
<script src="<?= base_url() ?>js/angular/formController.js"></script>