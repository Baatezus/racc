<div class="container" ng-controller="MypageController">
<h5>Vos coordonées: </h5>
<div class="row">
    <div class="col s12 m6">
        <div class="row">
          <div class="col s12 m12">
            <div class="card">
              <div class="card-content black-text">
                <span class="card-title pink-text text-lighten-1">Bienvenue <?= $user->login ?></span>
                <p style="margin-bottom: 10px">Déclarations de créances: </p>
                    <a class="waves-effect waves-light btn p-link green darken-1"
                       href="#wal">
                        Projections en Wallonie
                    </a>
                    <a class="waves-effect waves-light btn p-link green darken-1"
                       href="#bxl">
                        Projections à Bruxelles
                    </a>
              </div>
              <div class="card-action">
                  <a class="blue-text" href="<?= base_url() ?>index.php/user/change_password/">Modifier mon mot de passe</a>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="col s12 m6">
        <div class="row">
          <div class="col s12 m12">
            <div class="card">
              <div class="card-content black-text">
                  <span class="card-title pink-text text-lighten-1">L'association <small>(ref n°: <?= $asso->id ?>)</small></span>
                <ul class="collection with-header black-text">
                  <li class="collection-header"><h5><?= $asso->association_name ?></h5></li>
                  <li class="collection-item">Personne de contact: <?= $asso->first_name .' '. $asso->last_name ?></li>
                  <li class="collection-item">Téléphone: <?= $asso->phone_nb ?></li>    
                  <li class="collection-item">Adresse mail: <?= $asso->email ?></li>
                  <li class="collection-item">Type: <?= $asso->association_type ?></li>
                  <li class="collection-item">Adresse: <?= $asso->address ?></li>
                  <li class="collection-item">Commune: <?= $asso->locality_name ?> (<?= $asso->postal_code ?>)</li>
                </ul>
              </div>
              <div class="card-action">
                <a class="blue-text" href="<?= base_url() ?>index.php/association/edit/<?= $user->token ?>">Modifier les information de l'association</a>
              </div>
            </div>
          </div>
        </div>
    </div>
    <div class="col s12 m6 bank-div">
        <div class="row">
          <div class="col s12 m12">
            <div class="card">
              <div class="card-content black-text">
                <span class="card-title pink-text text-lighten-1" style='margin-bottom: 13px'>Coordonnées bancaires et nationales</span>
                <p>Numéro de compte: </p>
                <p style='margin-bottom: 15px' class="blue-text"><?= $asso->account_nb ?></p>
                <?php if($asso->national_nb === 'nc.') { ?>
                    <p>Numéro d'entreprise: </p>
                    <p class="blue-text"><?= $asso->business_nb ?></p>
                <?php } else { ?>
                    <p>Numéro de registre national: </p>
                    <p class="blue-text"><?= $asso->national_nb ?></p>                
                <?php } ?>
            </div>
          </div>
        </div>
        </div>
    </div>
</div>

<h5>Déclarations de créances</h5>

<div class="card-panel" id="wal">
<h5 class="pink-text text-lighten-1">Projections en Wallonie</h5>
    <table class="striped">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Date</th>
                <th>Film</th>
                <th>Montant remboursable</th>
                <th>Payée</th>
                <th>Actions</th>                
            </tr>
            </thead>

            <tbody>
                <tr ng-repeat="x in wStatements[wIndex]">
                <td>{{x.id}}</td>
                <td>{{x.date}}</td>
                <td>{{x.title}}</td>
                <td>{{x.refund_amount}}</td>
                <td>{{(x.paid === '0') ? "Non" : "Oui"}}</td>
                <td>
                    <a class="waves-effect waves-light btn green darken-1"  target="_blank"
                       href="<?= base_url() ?>index.php/debt_statement/reprint/wallonie/{{x.id}}/<?= $user->token ?>">
                        <i class="material-icons left">print</i>
                    </a>
                   <a class="waves-effect waves-light btn green darken-1" ng-click="display(x, 'W')">Détails</a>
                </td>
            </tr>
        </tbody>
    </table>
    <ul class="pagination">
      <li class="" ng-class="{'disabled' : wIndex === 0}">
          <a href="#!" ng-click="decrement('w')">
              <i class="material-icons">chevron_left</i>
          </a>
      </li>
      <li ng-repeat="(x, y) in wStatements"class="waves-effect" 
          ng-class="{'active': wIndex === x}">
          <a ng-click="paginateWal(x)">{{x + 1}}</a>
      </li>
      <li class="" ng-class="{'disabled' : wIndex >= wStatements.length - 1}">
          <a href="#!" ng-click="increment('w')">
              <i class="material-icons">chevron_right</i>
          </a>
      </li>
    </ul>
</div>

<div class="card-panel" id="bxl">
    <h5 class="pink-text text-lighten-1">Projections à Bruxelles</h5>
    <table class="striped">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Date</th>
                <th>Film</th>
                <th>Montant remboursable</th>
                <th>Payée</th>
                <th>Actions</th>               
            </tr>
            </thead>

            <tbody>
                <tr ng-repeat="x in bStatements[bIndex]">
                <td>{{x.id}}</td>
                <td>{{x.date}}</td>
                <td>{{x.title}}</td>
                <td>{{x.refund_amount}}</td>
                <td>{{(x.paid === '0') ? "Non" : "Oui"}}</td>
                <td>
                    <a class="waves-effect waves-light btn green darken-1" target="_blank"
                       href="<?= base_url() ?>index.php/debt_statement/reprint/bxl/{{x.id}}/<?= $user->token ?>">
                        <i class="material-icons left">print</i>
                    </a>
                    <a class="waves-effect waves-light btn green darken-1" ng-click="display(x, 'B')">Détails</a>
                </td>
            </tr>
        </tbody>
    </table>
    <ul class="pagination">
      <li class="" ng-class="{'disabled' : bIndex === 0}">
          <a href="#!" ng-click="decrement('b')">
              <i class="material-icons">chevron_left</i>
          </a>
      </li>
      <li ng-repeat="(x, y) in bStatements"class="waves-effect"
          ng-class="{'active': bIndex === x}">
          <a ng-click="paginateBxl(x)">{{x + 1}}</a>
      </li>
      <li class="" ng-class="{'disabled' : bIndex >= bStatements.length - 1}">
          <a href="#!" ng-click="increment('b')">
              <i class="material-icons">chevron_right</i>
          </a>
      </li>
    </ul>    
</div>

<div id="s-scr" style="" hidden class="card-panel container">
        <ul class="collection with-header">
            <li class="collection-header"><h4>Déclaration n° {{s.z +' '+ s.id}}</h4></li>
            <li class="collection-item">Titre du film: {{s.title}}</li>
            <li class="collection-item">Réalisateur: {{s.director}}</li>
            <li class="collection-item">Pays: {{s.country}}</li>
            <li class="collection-item">Durée: {{s.duration}} minutes</li>
            <li class="collection-item">Format de projection: {{s.f}}</li>
            <li class="collection-item">Adresse de la projection: {{s.address}}</li>
            <li class="collection-item">Commune: {{s.postal_code +' '+ s.name}}</li>
            <li class="collection-item">Coût de la location (H.T.): {{s.rental_cost}} €</li>
            <li class="collection-item">Montant remboursable par le R.A.C.C: {{s.refund_amount}} €</li>
            <li class="collection-item">Payée: {{(s.paid === '1') ? 'oui' : 'non'}}</li>
        </ul> 
        <a class="waves-effect waves-light btn green darken-1" target="_blank"
           href="<?= base_url() ?>index.php/debt_statement/reprint/{{s.zone}}/{{s.id}}/<?= $user->token ?>">
            <i class="material-icons left">print</i>
        </a>
        <a ng-click="close()" class="waves-effect waves-light btn  orange darken-3"><i class="material-icons left">close</i>Fermer</a>
</div>
<div id="cover"></div>
</div>
<script src="<?= base_url() ?>js/angular/mypageController.js"></script>