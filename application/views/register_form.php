<div class="container" ng-controller="RegisterController">
    <h2><?= $title ?></h2>
    <p>
        Une fois l'inscription de votre association validée, vous pourrez accéder à la déclaration de créances en ligne<br />
       Cela vous aidera à compléter facilement et rapidement le formulaire puis d'imprimer la déclaration avant de nous la renvoyer avec les pièces nécessaires (factures).<br />
Vous pourrez également accéder à l'historique de vos déclarations et les réimprimer si besoin.
    </p>
    <p>
        Veuillez compléter ce formulaire d'inscription avec soin. Toute modification ultérieure devra être faite à partir de la page de l'association (accessible une fois l'inscription validée) et chaque modification sera soumise à validation avant d'être effective.
    </p>
    <?= $message ?>
    <?php if(strlen(validation_errors()) > 0) { ?>
        <div class="card-panel red darken-1 white-text">
            <?= validation_errors() ?>
        </div>
    <?php } ?>
    <?= form_open('user/register', 'class="col s12"') ?>
    <div class="card-panel"> 
        <h6 class="pink-text text-lighten-1">Choisissez un pseudo et un mot de passe.<br />
        Conservez ces informations précieusement, elles vous seront nécessaires pour vous connecter.</h6>

        <div class="row">
            <div class="input-field col s12">
                <input required type="text" name="login" class="validate"
                        value="<?= set_value('login') ?>" />
                <label for="login">Choisissez un pseudo</label>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12">
                <input required type="password" name="password" class="validate" />
                <label for="password">Choisissez un mot de passe</label>
            </div>
        </div>                

        <div class="row">
            <div class="input-field col s12">
                <input required type="password" name="passconf" class="validate" />
                <label for="passconf">Confirmer le mot de passe</label>
            </div>
        </div> 
    </div>
    <div class="card-panel"> 
        <h6 class="pink-text text-lighten-1">Renseignez les informations relatives à votre association: </h6>
        <p for="association_type">Type d'association</p>
        
        <div class="row">
            <div class="input-field col s12">      
                <input type="radio" name="association_type" value="A.S.B.L" checked id="asbl"
                       class="register-radio" onclick="show('business')" />
                <label for="asbl" style="margin-left: 5px;">A.S.B.L</label>

                <input type="radio" name="association_type" value="Association de fait" id="asdf"
                       class="register-radio" onclick="show('national')" />
                <label for="asdf" style="margin-left: 5px;">Association de fait</label>
            </div>
        </div>

        <div id="business-toggle">
            <label class="number-label" for=""id="nb_label">Numéro d'entreprise: </span></label><br/>
            <input required type="number" name="business_nb1" id="business_nb1" 
                   class="required nb_input" type="number" maxlength="4"  
                   style="width: 80px !important; text-align: center; margin-left: 5px" 
                   oninput="maxLengthCheck(this)" />
            <input required type="number" name="business_nb2" id="business_nb2" 
                   class="required nb_input" type="number" maxlength="3" 
                   style="width: 60px !important; text-align: center; margin-left: 5px"
                   oninput="maxLengthCheck(this)" />
            <input required type="number" name="business_nb3" id="business_nb3" 
                   class="required nb_input" type="number" maxlength="3"
                   style="width: 60px !important; text-align: center; margin-left: 5px" 
                   oninput="maxLengthCheck(this)" />
            <div style="clear: both"></div>
        </div>
        
        <div class="grey-container">
            <div id="account-div">
                <label class="number-label" for="account_nb">Numéro de compte (IBAN uniquement)</label><br />
                <span style="font-size: 1.4em;float:left" >BE</span>
                <input required type="number" name="account_nb1" id="account_nb1" required
                       class="required nb_input" type="number" min="10" max="99" 
                       ng-model="account_nb1" id="account-input1" maxlength="2"
                       style="width: 40px !important; text-align: center; margin-left: 5px"
                       oninput="maxLengthCheck(this)" />
                <input required type="number" name="account_nb2" id="account_nb2" required
                       class="required nb_input" type="number" min="1000" max="9999" 
                       ng-model="account_nb2" id="account-input2" maxlength="4"
                       style="width: 80px !important; text-align: center; margin-left: 5px"
                       oninput="maxLengthCheck(this)" />
                <input required type="number" name="account_nb3" id="account_nb3" required
                       class="required nb_input" type="number" min="1000" max="9999" 
                       ng-model="account_nb3" id="account-input3" maxlength="4"
                       style="width: 80px !important; text-align: center; margin-left: 5px"
                       oninput="maxLengthCheck(this)" />
                <input required type="number" name="account_nb4" id="account_nb4" required
                       class="required nb_input" type="number" min="1000" max="9999"
                       ng-model="account_nb4" id="account-input4" maxlength="4"
                       style="width: 80px !important; text-align: center; margin-left: 5px"
                       oninput="maxLengthCheck(this)" />
                <div style="clear: both"></div>
            </div>
        </div>        
        <div class="row">
            <div class="input-field col s12">
                    <input required type="text" name="association_name" class="validate"
                        value="<?= set_value('association_name') ?>" />
                    <label for="association_name">Nom de l'association</label>
            </div>
        </div>        
   
        <div class="row">
            <div class="input-field col s12">

                <input required type="text" name="last_name" class="validate"
                    value="<?= set_value('last_name') ?>" />
                <label for="last_name">Nom de la personne de contact</label>
            </div>
        </div>
                                    
        <div class="row">
            <div class="input-field col s12"> 
                <input required type="text" name="first_name" class="validate"
                        value="<?= set_value('first_name') ?>" />
                <label for="first_name">Prénom de la personne de contact</label>
            </div>
        </div>                        

        <div class="row">            
            <div class="input-field col s12">               
                <input required type="email" name="email" class="validate"
                    value="<?= set_value('email') ?>" />
                <label for="eamil">Adresse mail</label>
            </div>
        </div>
 
        <div class="row">
            <div class="input-field col s12">
                <input required type="text" name="phone_nb" class="validate"
                        value="<?= set_value('phone_nb') ?>" />
                <label for="">Numéro de téléphone</label>
            </div>
        </div>  
        
        <div class="row">
            <div class="input-field col s12">
                <input required type="text" name="gsm" class="validate"
                        value="<?= set_value('gsm') ?>" />
                <label for="">Numéro de GSM</label>
            </div>
        </div>        
               
        <div class="row">
            <div class="input-field col s12">
                <input required type="text" name="address" class="validate"
                        value="<?= set_value('address') ?>" />
                <label for="address">Adresse</label><br />
            </div>
        </div>                  
                
        <div class="row">
            <div class="input-field col s12">             
                <input autocomplete="off" type="text" ng-keyup="filterLocalities()"
                       ng-model="localityVal" id="saisie" ng-value="displayedLocality" />
                <label for="saisie">
                    <i class="material-icons left">search</i>
                    Chercher une commune (code postal ou nom)
                </label>
            </div>
        </div>     
        
        <p class="temp" id="p{{x.id}}" ng-click="choose(x)" ng-repeat="x in localitiesRes">{{ x.postal_code + ' ' + x.name }}</p>
        
        <input id="locality" type="text" required hidden name="locality" value="{{locality}}" />
        
        <div class="btn-container">
            <input type="submit"  value="Envoyer" class="btn btn-success green darken-1" />
        </div>
    </div>
    </form>
</div>
<script src="<?= base_url() ?>js/angular/registerController.js"></script>