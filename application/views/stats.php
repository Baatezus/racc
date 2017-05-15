<div ng-controller="StatsController" id="main-content" class=container>
<h5 class="page-title">Statistiques: </h5>
<div class="row">
    <div class="col s12 m6">
        <div class="row">
          <div class="col s12 m12">
            <div class="card">
              <div class="card-content black-text">
                <span class="card-title">Films aidé par la CFWB</span>
                <canvas id="comFrChart" width="200" height="200"></canvas>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
</div>
<script src="<?= base_url() ?>js/angular/statsController.js"></script>
