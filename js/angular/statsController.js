(function(){
    angular.module('films', []).controller('StatsController', function($scope, $http) {
        /*
        $http.get("../../index.php/films").then(function(response){
            var allFilms = response.data;
        });
        */
        $http.get("../../index.php/debt_statement/all").then(function(response){
            var all = response.data;
            var nbComfr = 0;
            
            for(var i = 0; i < all.length; i++){
                if(all[i].helped_by_cfwb === '1')
                    nbComfr++;
            }
      
            var data = {
                labels: [
                    "Films aidés",
                    "Fims non aidés"
                ],
                datasets: [
                    {
                        data: [nbComfr, all.length - nbComfr],
                        backgroundColor: [
                            "#FF6384",
                            "#36A2EB"
                        ],
                        hoverBackgroundColor: [
                            "#FF6384",
                            "#36A2EB"
                        ]
                    }]
              };
      
      
            var myDoughnutChart = new Chart($('#comFrChart'), {
                type: 'doughnut',
                data: data
            });
            
        });        
    });
})();


