/**
 * @author Yann LARU
 * Contrôlleur des données du formulaire d'envoie.
 */
(function(){
    angular.module('films', []).controller('MypageController', function($scope, $http) {
        
        $http.get("../../index.php/debt_statement/asso").then(function(response){
           $scope.statements = response.data;
           
           $scope.wStatements = [[]];
           var cpt = 0;
           for(var i = 0; i < $scope.statements.w.length; i++){
               if($scope.wStatements[cpt].length >=  5) {
                   cpt++;
                   $scope.wStatements.push([]);
               }
                $scope.wStatements[cpt].push($scope.statements.w[i]);
           }
           
            $scope.bStatements = [[]];
            var cpt = 0;
            for(var i = 0; i < $scope.statements.b.length; i++){
                if($scope.bStatements[cpt].length >=  5) {
                    cpt++;
                    $scope.bStatements.push([]);
                }
                 $scope.bStatements[cpt].push($scope.statements.b[i]);
            }
        });
        
        $scope.wIndex = 0;
        $scope.paginateWal = function(index) {
             $scope.wIndex = index;
        }
        
        
        $scope.bIndex = 0;
        $scope.paginateBxl = function(index) {
             $scope.bIndex = index;
        }
        
        $scope.increment = function(z) {
            if(z === 'b'){
                if($scope.bIndex < $scope.bStatements.length -1)
                   $scope.bIndex++;
            } else {
                if($scope.wIndex < $scope.wStatements.length -1)
                    $scope.wIndex++;
            }           
        }
        
        $scope.decrement = function(z) {
            if(z === 'b') {
                if($scope.bIndex > 0)
                    $scope.bIndex--;
            } else {
                if($scope.wIndex > 0)
                    $scope.wIndex--;
            }
        }
        
        $scope.display = function(s, l) {
            $scope.s = s;
            $scope.s.z = l;
            
            if(l === 'B')
                $scope.s.zone = 'bxl';
            else
                $scope.s.zone = 'wallonie'
          
            $('#s-scr').fadeIn();
            $('#cover').fadeIn();
        }
        
        $scope.close = function() {
            $('#s-scr').fadeOut();
            $('#cover').fadeOut();
            
        }
    });
})();


