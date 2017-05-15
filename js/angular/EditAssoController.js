(function(){
    angular.module('films', []).controller('EditAssoController', function($scope, $http) {
        
        //Récupération de la liste des localitées
        $http.get("../../../index.php/localities").then(function(response){
           $scope.localities = response.data; 
        });

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

        function replaceStr(str) {  
            str = str.replace(/[éêèë]/, 'e');
            str = str.replace(/[öô]/, 'o');
            str = str.replace(/[îï]/, 'i');
            str = str.replace(/[ûü]/, 'i');
            str = str.replace('ç', 'c'); 
            
            return str;
        }
                
        $scope.choose = function(div) {
            $scope.locality = div.id;
            $scope.displayedLocality = div.postal_code + ' ' + div.name; 
            $('.temp').remove();  
        }
    });
})();


