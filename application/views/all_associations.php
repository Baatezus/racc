<div ng-controller="AssociationsController" class="container">
    <h3>{{assoCount}} association inscrites actuellement.</h3>
    <h4>{{asblCount}} A.S.B.L | {{factAssoCount}} Associations de fait</h4>
    <div class="card-panel">
        <h4 class="">Rechercher une association</h4>
        <div id="search-engine" > 
            <div class="row">
                <div class="input-field col s12">
                    <input type="text" ng-keyup="filterAssociations()" ng-model="val"
                           id="saisie" class="" />
                    <label for="saisie">
                        <i class="material-icons left">search</i>
                        Rechercher une association par nom
                    </label>
                </div>
            </div>
        </div>
        <div ng-repeat="x in results | limitTo: 5" class="">
            <p class="film-element" ng-click="selectAsso(x)">{{ x.association_name }}</p>
        </div>
        <p ng-show="message" class="card-panel orange lithgten-1 white-text">{{message}}</p>
    </div>
        <div class="row" ng-show="s" id="statement-details">
        <div class="col s12 m12">
            <div class="card">
              <div class="card-content black-text">
                <h5>{{s.association_name}} ({{s.association_type}})</h5>
                <span class="card-title pink-text text-lighten-1">Contacts</span>
                <ul class="collection">
                    <li class="collection-item black-text">Représenté par: {{s.first_name}} {{s.last_name}}</li>
                    <li class="collection-item black-text">Téléphone: {{s.phone_nb}}</li>
                    <li class="collection-item black-text">E-mail: {{s.email}}</li>
                    <li class="collection-item black-text">
                        Adresse: {{ s.address }}, {{s.postal_code}} {{s.name}}
                    </li>
                </ul>
                <span class="card-title pink-text text-lighten-1">Coordonées</span>
                <ul class="collection">
                    <li class="collection-item black-text">Numéro de compte: {{s.account_nb}}</li>
                    <li class="collection-item black-text">
                         {{ (s.national_nb === "nc.") ? 
                            "Numéro d' entreprise: " +  s.business_nb : 
                            "Numéro de registre national: "   + s.national_nb
                         }}
                    </li>
                </ul>
                <span class="card-title pink-text text-lighten-1">{{ s.stmCount}} déclarations effectué(s) pour l'ann&eacute; <?= date('Y') ?></span>
              </div>
            </div>
          </div>
        </div>
    <div class="card-panel">
        <h4 class="page-title blur"><?= $title ?></h4>
        <table class="striped">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Nom de l'association</th>
                    <th>Représenté par</th>
                    <th>Actions</th>                
                </tr>
                </thead>

                <tbody>
                    <tr ng-repeat="x in associations[index]">
                    <td>{{x.id}}</td>
                    <td>{{x.association_name}}</td>
                    <td>{{x.first_name}} {{x.last_name}}</td>
                    <td>
                       <a class="waves-effect waves-light btn green darken-1" ng-click="display(x)">Détails</a>
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
          <li ng-repeat="(x, y) in associations"class="waves-effect" 
              ng-class="{'active': index === x}">
              <a ng-click="paginate(x)">{{x + 1}}</a>
          </li>
          <li class="" ng-class="{'disabled' : index >= associations.length - 1}">
              <a href="#!" ng-click="increment()">
                  <i class="material-icons">chevron_right</i>
              </a>
          </li>
        </ul>
    </div>
</div>
<script src="<?= base_url() ?>js/angular/associationsController.js"></script>