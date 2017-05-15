/**
 * @author Yann LARU
 * ContrÃ´lleur des donnÃ©es du formulaire d'envoie.
 */
(function(){
    angular.module('films', []).controller('AssociationsController', function($scope, $http) {
        
        $http.get("../../index.php/association/all").then(function(response){
            $scope.r = response.data; 
            
            $scope.assoCount = $scope.r.length;
            $scope.asblCount = 0;
            $scope.factAssoCount = 0;
            
            $scope.associations = [[]];
            var cpt = 0;
            for(var i = 0; i < $scope.r.length; i++){
                if($scope.associations[cpt].length >=  5) {
                    cpt++;
                    $scope.associations.push([]);
                }
                $scope.associations[cpt].push($scope.r[i]);
                if($scope.r[i].type === "A.S.B.L")
                    $scope.asblCount++;
                else
                    $scope.factAssoCount++;
            }
        });
        
        $scope.filterAssociations = function() {
            $scope.results = []; 
            
            if($scope.val === '')
                $scope.results = [];
            
            for(var i = 0; i < $scope.r.length; i++)
                if($scope.r[i].association_name.toLowerCase().includes($scope.val.toLowerCase()))
                    $scope.results.push($scope.r[i]);
            
                        if($scope.val === '')
                $scope.results = [];
        };
        
        
        $scope.search = function() { 
            $scope.s = getAssociation($scope.val);
            
            if(!$scope.s)
                $scope.message = "Aucune correspondance...";
            else
                $scope.message = false;
            
            $scope.val = '';
        }
        
        
        $scope.selectAsso = function (x) {
            $scope.s = x;
        }
        
        $scope.index = 0;
        
        $scope.paginate = function(index) {
             $scope.index = index;
        }
        
        $scope.increment = function() {
            if($scope.index < $scope.associations.length -1)
                $scope.index++;          
        }
        
        $scope.decrement = function() {
            if($scope.index > 0)
                $scope.index--;
        }
        
        $scope.display = function(s) {
            $scope.val = '';
            $scope.message = false;
            $scope.s = s;
            $('html,body').animate({scrollTop: $("#statement-details").offset().top}, 'fast');
        }
        
        $scope.close = function() {
            $scope.s = false;
        }        
        
    });
})();


