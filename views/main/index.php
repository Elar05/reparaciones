<?php require_once 'views/layout/head.php'; ?>

<?php require_once 'views/layout/header.php'; ?>

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Total de ingresos por mes - <?= date("Y") ?></h4>
          </div>
          <div class="card-body">
            <div class="recent-report__chart">
              <div id="chart1"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Total de ingresos por mes y por usuario - <?= date("Y") ?></h4>
          </div>
          <div class="card-body">
            <div class="recent-report__chart">
              <div id="chart2"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Total de reparaciones por mes - <?= date("Y") ?></h4>
          </div>
          <div class="card-body">
            <div class="recent-report__chart">
              <div id="chart3"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Total de reparaciones por mes y usuario - <?= date("Y") ?></h4>
          </div>
          <div class="card-body">
            <div class="recent-report__chart">
              <div id="chart4"></div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-4">
        <div class="card">
          <div class="card-header">
            <h4>Pie Chart</h4>
          </div>
          <div class="card-body">
            <div class="recent-report__chart">
              <div id="chart5"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card">
          <div class="card-header">
            <h4>Pie Chart</h4>
          </div>
          <div class="card-body">
            <div class="recent-report__chart">
              <div id="chart6"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card">
          <div class="card-header">
            <h4>Pie Chart</h4>
          </div>
          <div class="card-body">
            <div class="recent-report__chart">
              <div id="chart7"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php require_once 'views/layout/footer.php'; ?>

<script src="<?= URL ?>public/bundles/apexcharts/apexcharts.min.js"></script>
<script src="<?= URL ?>public/js/main.js"></script>

<?php require_once 'views/layout/foot.php'; ?>