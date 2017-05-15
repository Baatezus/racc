(function(){
    angular.module('films', []).controller('SearchController', function($scope, $http) {       
        $http.get("../../index.php/refundrequest/all").then(function(response){
           $scope.requests = response.data; 
        });

        //Récupération de la liste des localitées
        $http.get("../../index.php/localities").then(function(response){
           $scope.localities = response.data; 
        });
        
        $http.get("../../index.php/formats").then(function(response){
           $scope.formats = response.data; 
        });
           
        $scope.message = false;
        $scope.request = false;   
        
        $scope.search = function() { 
            var request = getRequest();
            $scope.message = false;

            if(request){
                var localitiesData = getLocalitiesData(request.association_locality, request.show_locality);
                var format = getFormat(request.format);
                $scope.linkId = request.id;
                $scope.request = constructRequest(request, format, localitiesData);
            } else {
                $scope.message = "Aucun résultat trouvé...";
            } 
        };
        
        function getRequest() {
            var request = false;
            
            for(var i = 0; i < $scope.requests.length && !request; i++){
                if($scope.val === parseInt($scope.requests[i].id)){
                    request  = $scope.requests[i];
                }
            }
            
            return request;
        }
        
        function getLocalitiesData(a, s){
            var localitiesData = {};
            var foundAsso = false;
            var foundShow = false;
            
            for(var i = 0; i < $scope.localities.length && (!foundShow || !foundAsso); i++) {

                if(a === $scope.localities[i].id){
                    localitiesData.assoLocalityName = $scope.localities[i].name;
                    localitiesData.assoPostalCode = $scope.localities[i].postal_code+'';
                    foundAsso = true;
                }
                if(s === $scope.localities[i].id){
                    localitiesData.showLocalityName = $scope.localities[i].name;
                    localitiesData.showPostalCode = $scope.localities[i].postal_code;
                    foundShow = true;
                }   
            }
            
            return localitiesData;
        }
        
        function getFormat(f) {
            var format = "Aucun format reconnu"
            
            for(var i = 0; i < $scope.formats.length; i++)
                if($scope.formats[i].id === f)
                    format = $scope.formats[i].format;   
            
            return format;
        }
        
        function constructRequest(r, f, l){
            var request = {
                "Numéro de la déclaration": r.id,
                "Nom du demandeur": r.applicant_last_name,
                "Prénom de demabdeur" : r.applicant_first_name,
                "Nom de l'association" : r.association_name,
                "Adresse de l'association" : r.association_address
                    + ' ' + l.assoPostalCode
                    + ' ' + l.assoLocalityName,
                "Adresse mail": r.email,
                "Numéro de téléphone": r.phone_nb,
                "Type d'association" : r.association_type,
                "Référence": (r.national_nb.length > 0)? "numéro de registre national " + r.national_nb : "numéro d'entreprise " + r.business_nb,
                "Numéro de compte": r.account_nb,
                "Format": f
            };
            
            return request;
        }
        
    });
})();


