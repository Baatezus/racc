/**
 * @author Yann LARU
 * ContrÃÂ´lleur des donnÃÂ©es du formulaire d'envoie.
 */
(function(){
    angular.module('films', []).controller('StatementsController', function($scope, $http) {
        
        $http.get("../index.php/debt_statement/all").then(function(response){
            $scope.r = response.data; 
            
            $scope.statementsPaid = [[]];
            $scope.statementsUnpaid = [[]];
            
            
            var cpt1 = 0;
            var cpt2 = 0;
            
            
            for(var i = 0; i < $scope.r.length; i++){
                if($scope.r[i].paid === '0'){
                    if($scope.statementsUnpaid[cpt1].length >=  5) {
                        cpt1++;
                        $scope.statementsUnpaid.push([]);
                    }
                     $scope.statementsUnpaid[cpt1].push($scope.r[i]);                    
                } else {
                    if($scope.statementsPaid[cpt2].length >=  5) {
                        cpt2++;
                        $scope.statementsPaid.push([]);
                    }
                     $scope.statementsPaid[cpt2].push($scope.r[i]);
                }
            }
        });

        $scope.search = function() { 
            $scope.s = getStatement($scope.val);
            
            if(!$scope.s)
                $scope.message = "Aucune correspondance...";
            else
                $scope.message = false;
            
            $scope.val = '';
        }

        $scope.paid = function(x) {
            $scope.display(x);
            $scope.pay = x;
        };
        
        $scope.closePay = function() {
            $scope.pay = false;
            $scope.s = false;
        };  
        
        function getStatement(id) {
            var s = false;
             
            for(var i = 0; i < $scope.statements.length && !s; i++)
                for(var k = 0; k < $scope.statements[i].length && !s; k++)
                    if(parseInt($scope.statements[i][k].id) === id)
                        s = $scope.statements[i][k];
            
            return s;
        };

        $scope.index = 0;
        
        $scope.paginate = function(index) {
             $scope.index = index;
        }
        
        $scope.increment = function() {
            if($scope.index < $scope.statementsUnpaid.length -1)
                $scope.index++;          
        }
        
        $scope.decrement = function() {
            if($scope.index > 0)
                $scope.index--;
        }
        
        $scope.index2 = 0;
        
        $scope.paginate2 = function(index2) {
             $scope.index2 = index2;
        }
        
        $scope.increment2 = function() {
            if($scope.index2 < $scope.statementsPaid.length -1)
                $scope.index2++;          
        }
        
        $scope.decrement2 = function() {
            if($scope.index2 > 0)
                $scope.index2--;
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


