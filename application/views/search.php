<h1 class="">Rechercher une déclaration de créance</h1>
<div ng-controller="SearchController" id="main-content">
    <div id="search-engine" > 
        <input placeholder="Entrez le numéro de la déclaration: "  type="number" ng-keyup="correct()" ng-model="val" id="saisie" class="" />
    </div>
    <div id="">
        <button ng-click="search()" id="searchbtn">Rechercher</button>
    </div>
    <p ng-show="message" id="search-message">{{ message }}</p>
    <div ng-show="request" id="request-container">
        <p ng-repeat="(x, y) in request" >
            {{ x }} : {{ y }}
        </p>
    </div>
    <a ng-show="request" id="print-link" 
       href="<?= base_url() ?>index.php/refundrequest/get/{{ linkId }}" 
       target="_blank">Imprimer cette déclaration...</a>
</div>
<script src="<?= base_url() ?>js/angular/searchController.js"></script>