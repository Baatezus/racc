/**
 * @author Yann LARU
 * Contrôlleur des données du formulaire d'envoie.
 */
(function(){
    angular.module('films', []).controller('FormController', function($scope, $http) {
        
        //Récupération des données via reqêtes AJAX
        //Récupération de la liste des films: 
        $http.get("../../index.php/films").then(function(response){
           $scope.films = response.data; 
        });
        
        
        //Récupération de la liste des localitées
        $http.get("../../index.php/localities").then(function(response){
           $scope.localities = response.data; 
        });
        //Récupération des formats de diffusion de films
        $http.get("../../index.php/formats").then(function(response){
           $scope.formats = response.data; 
        });   
        

        /**
         * @param {void} 
         * @returns {void}
         * Dans le champ "Rechercher un film", à chaque pression d'un touche,
         * récupère le contenu du champ et injecte dans le flux une proposition 
         * de cinq films. Ceux ci sont "selectionnable" (cf. selectFilm() ).
         */
        $scope.filterFilms = function() {
            $scope.results = []; 
            
            if($scope.val !== "")
                $scope.val = replaceStr($scope.val);

            for(var i = 0; i < $scope.films.length; i++)
                if($scope.films[i].titre.toLowerCase().includes($scope.val.toLowerCase()))
                    $scope.results.push($scope.films[i]);

        };

        $scope.filterLocalities = function() {
            $scope.localitiesRes = [];  
                
            if($scope.localityVal !== "")
                $scope.localityVal = replaceStr($scope.localityVal);
            
            for(var i = 0; i < $scope.localities.length && $scope.localitiesRes.length < 6; i++)
                if($scope.localities[i].name.toLowerCase().includes($scope.localityVal.toLowerCase()) || 
                        $scope.localityVal === $scope.localities[i].postal_code)
                    $scope.localitiesRes.push($scope.localities[i]);
            
            if($scope.localityVal.length < 1)
                $scope.localitiesRes = [];  
        };      

        $scope.choose = function(div) {
            $scope.locality = div.id;
            $scope.displayedLocality = div.postal_code + ' ' + div.name; 
            $('.temp').remove();     
        };

        function replaceStr(str) {  
            str = str.replace(/[éêèë]/, 'e');
            str = str.replace(/[öô]/, 'o');
            str = str.replace(/[îï]/, 'i');
            str = str.replace(/[ûü]/, 'i');
            str = str.replace('ç', 'c'); 
            
            return str;
        }

        $scope.selectFilm = function(x) {
            $scope.val = "";
            $scope.results = [];
            $scope.title = x.titre;
            $scope.film_id = x.id; 
            $scope.director = x.realisateur;    
            $scope.country = x.pays;
            $scope.duration = x.duree;
            $scope.helped = x.comfr === '1';
        };
        
        $scope.calRefund = function() {
            $scope.ceil = 0;

            $scope.refund_amount = ($scope.helped)? $scope.rental_cost : $scope.rental_cost / 2;

            if($scope.duration < 40)
                    $scope.ceil = 25;
            else 
                if($scope.format === '1' || $scope.format === '6')
                    if($scope.helped)
                        $scope.ceil = ($scope.duration > 59)? 150 : 60;
                    else
                        $scope.ceil = ($scope.duration > 59)? 100 : 50;
                else
                    if($scope.helped)
                        $scope.ceil = ($scope.duration > 59)? 100 : 60;
                    else
                        $scope.ceil = ($scope.duration > 59)? 50 : 40;


            if($scope.refund_amount > $scope.ceil) $scope.refund_amount = $scope.ceil;
            
        }; 
    });
})();


