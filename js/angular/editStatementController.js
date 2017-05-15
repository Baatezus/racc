/**
 * @author Yann LARU
 * Contrôlleur des données du formulaire d'envoie.
 */
(function(){
    angular.module('films', []).controller('FormController', function($scope, $http) {
        //Récupération des formats de diffusion de films
        $http.get("../../../index.php/formats").then(function(response){
           $scope.formats = response.data; 
        });   
 
        $scope.calRefund = function() {
            var ceil = 0;

            $scope.refund_amount = ($scope.helped)? $scope.rental_cost : $scope.rental_cost / 2;

            if($scope.duration < 40)
                    ceil = 25;
            else 
                if($scope.format === '1' || $scope.format === '6')
                    if($scope.helped)
                        ceil = ($scope.duration > 59)? 150 : 60;
                    else
                        ceil = ($scope.duration > 59)? 100 : 50;
                else
                    if($scope.helped)
                        ceil = ($scope.duration > 59)? 100 : 60;
                    else
                        ceil = ($scope.duration > 59)? 50 : 40;


            if($scope.refund_amount > ceil) $scope.refund_amount = ceil;
            
        }; 
    });
})();


