<div ng-controller="StatementsController" class="container">
    <h3>Administration</h3>
    <div class="card-panel">
        <h5 class="pink-text text-lighten-1">Rechercher une déclaration de créance</h5>
        <div id="search-engine" > 
            <div class="row">
                <div class="input-field col s12">
                    <input type="number" ng-keyup="correct()" ng-model="val"
                           id="saisie" class="" />
                    <label for="saisie">
                        <i class="material-icons left">search</i>
                        Rechercher une déclaration par numéro
                    </label>
                </div>
            </div>
        </div>
        <div id="send-div2">
            <button class="btn green darken-1" ng-click="search()">Rechercher</button>
        </div>
        <p ng-show="message" class="card-panel orange lithgten-1 white-text">{{message}}</p>
    </div>
       
    <div class="row card-panel" ng-show="s" id="statement-details">
      <div class="col s12 m12">
        <div class="card">
          <div class="card-content black-text">
            <h5 class="">Déclaration n°{{s.id}}, projection organisée par "{{s.association_name}}"</h5>
            <span class="card-title pink-text text-ligten-1">Le film</span>
            <ul class="collection">
                <li class="collection-item black-text">Titre du film: {{s.title}}</li>
                <li class="collection-item black-text">Réalisateur: {{s.director}}</li>
                <li class="collection-item black-text">Pays: {{s.country}}</li>
                <li class="collection-item black-text">Durée: {{s.duration}} minutes</li>
                <li class="collection-item black-text">Ce film
                    {{(s.helped_by_cfwb === '0')? "n'est pas aidé " : "est aidé " }}
                    par la fédération Wallonie Bruxelles.
                </li>
            </ul>
            <span class="card-title pink-text text-ligten-1">La projection</span>
            <ul class="collection">
                <li class="collection-item black-text">Adresse de la projection: {{s.address}}, {{s.postal_code}} {{s.name}}</li>
                <li class="collection-item black-text">Type de projection: {{s.type}}</li>
                <li class="collection-item black-text">Format utilisé: {{s.f}}</li>
                <li class="collection-item black-text">Nombres de scpectateurs: {{s.spec_nb}}</li>
                <li class="collection-item black-text">Coût de la location (H.T): {{s.rental_cost}}€</li>
                <li class="collection-item black-text">Montant remboursé par le R.A.C.C: {{s.refund_amount}}€</li>
            </ul>
            <div class="card-action">
                <a class="waves-effect waves-light btn green darken-1"  target="_blank"
                   href="<?= base_url() ?>index.php/debt_statement/reprintbyadmin/<?= $zone ?>/{{s.id}}/<?= $user->token ?>/{{s.association_id}}">
                    <i class="material-icons left">print</i>Imprimer
                </a>
                <a class="btn btn-primary orange lighten-1" ng-click="close()">
                    <i class="material-icons left">close</i>fermer</a>
            </div>
          </div>
        </div>
      </div>
        <div ng-show="pay" class="float-form">
            <h5 class="pink-text lighten-1">Passer le statut "payée" à cette déclaration</h5>
            <?= form_open('admin', 'class="form-group"') ?>
                <div class="row">
                    <h5 class="s3 pay-title">Date de paiement</h5>
                    <div class="input-field col s3"> 
                        <input required type="date" name="date" class="validate" id="email" />
                    </div>
                </div>

                <input type="text" value="{{pay.id}}" hidden name="id">

                <input type="submit" name="submit" value="Comfirmer paiement de la créance."
                       class="btn btn-success green darken-1" />
                <a class="btn btn-primary orange lighten-1" ng-click="closePay()">
                    <i class="material-icons left">close</i>fermer</a>
            </form>  
        </div>
    </div>
    <div class="card-panel">
        <h5 class="pink-text text-lighten-1">Déclaration en attente de remboursement</h5>
        <table class="striped">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Date</th>
                    <th>Film</th>
                    <th>Montant remboursable</th>
                    <th>Actions</th>                
                </tr>
                </thead>

                <tbody>
                    <tr ng-repeat="x in statementsUnpaid[index]">
                    <td>{{x.id}}</td>
                    <td>{{x.date}}</td>
                    <td>{{x.title}}</td>
                    <td>{{x.refund_amount}}</td>
                    <td>
                        <a class="waves-effect waves-light btn orange darken-1"  ng-click="paid(x, index)">Paiement</a>
                        <a class="waves-effect waves-light btn green darken-1"  target="_blank"
                           href="<?= base_url() ?>index.php/debt_statement/reprintbyadmin/<?= $zone ?>/{{x.id}}/<?= $user->token ?>/{{x.association_id}}">
                            <i class="material-icons left">print</i>
                        </a>
                       <a class="waves-effect waves-light btn green darken-1" ng-click="display(x)">Détails</a>
                       <!--<a  ng-show="{{x.paid =='0'}}" ng-click="paid(x)" class="waves-effect waves-light btn green darken-1" ng-click="display(x)">Payée</a>-->
                    </td>
                </tr>
            </tbody>
        </table>
        <ul class="pagination">
          <li class="" ng-class="{'disabled' : index === 0}">
              <a href="#!" ng-click="decrement()">
                  <i class="material-icons">chevron_left</i>
              </a>
          </li>
          <li ng-repeat="(x, y) in statementsUnpaid"class="waves-effect" 
              ng-class="{'active': index === x}">
              <a ng-click="paginate(x)">{{x + 1}}</a>
          </li>
          <li class="" ng-class="{'disabled' : index >= statementsUnpaid.length - 1}">
              <a href="#!" ng-click="increment()">
                  <i class="material-icons">chevron_right</i>
              </a>
          </li>
        </ul>
    </div>
    <div class="card-panel">
        <h5 class="pink-text text-lighten-1">Déclaration remboursée</h5>
        <table class="striped">
            <thead>
                <tr>
                    <th>Numéro</th>
                    <th>Date</th>
                    <th>Film</th>
                    <th>Montant remboursé</th>
                    <th>Actions</th>                
                </tr>
                </thead>

                <tbody>
                    <tr ng-repeat="x in statementsPaid[index2]">
                    <td>{{x.id}}</td>
                    <td>{{x.date}}</td>
                    <td>{{x.title}}</td>
                    <td>{{x.refund_amount}}</td>
                    <td>
                        <a class="waves-effect waves-light btn green darken-1"  target="_blank"
                           href="<?= base_url() ?>index.php/debt_statement/reprintbyadmin/<?= $zone ?>/{{x.id}}/<?= $user->token ?>/{{x.association_id}}">
                            <i class="material-icons left">print</i>
                        </a>
                       <a class="waves-effect waves-light btn green darken-1" ng-click="display(x)">Détails</a>
                       <!--<a  ng-show="{{x.paid =='0'}}" ng-click="paid(x)" class="waves-effect waves-light btn green darken-1" ng-click="display(x)">Payée</a>-->
                    </td>
                </tr>
            </tbody>
        </table>
        <ul class="pagination">
          <li class="" ng-class="{'disabled' : index2 === 0}">
              <a href="#!" ng-click="decrement2()">
                  <i class="material-icons">chevron_left</i>
              </a>
          </li>
          <li ng-repeat="(x, y) in statementsPaid"class="waves-effect" 
              ng-class="{'active': index2 === x}">
              <a ng-click="paginate2(x)">{{x + 1}}</a>
          </li>
          <li class="" ng-class="{'disabled' : index2 >= statementsPaid.length - 1}">
              <a href="#!" ng-click="increment2()">
                  <i class="material-icons">chevron_right</i>
              </a>
          </li>
        </ul>
    </div>    
</div>
<script src="<?= base_url() ?>js/angular/StatementsController.js"></script>