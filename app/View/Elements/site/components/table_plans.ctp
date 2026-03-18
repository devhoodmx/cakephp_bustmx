<?php
$this->Package->append('component', 'css', array(
  'view.pages.table_plans',
));
?>


<?php

$allFeatures = [];
foreach ($plansTable[0]['features'] as $featureName => $featureData) {
  $allFeatures[$featureName] = $featureData == 'SECTION' ? 'SECTION' : 'DATA';
}
?>

<div class="component-table-plans">
  <div class="swiper-section" >
    <div class="swiper swiper-table-plans">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <table class="table-plans">
            <thead class="table-head">
              <tr>
                <th class="feature-name">Características</th>
                <?php foreach ($plansTable as $plan): ?>
                  <th class="plan-name">
                    <h3 class="name"><?= $plan['name']; ?></h3>
                    <div class="price"><?= $plan['price']; ?></div>
                    <?php echo $this->Html->link('Hablar con ventas', ['controller' => 'pages', 'action' => 'contact'], ['class' => 'btn btn-view-more']); ?>
                  </th>
                <?php endforeach; ?>
              </tr>
            </thead>

            <tbody>
              <?php $counter = 0; ?>
              <?php foreach ($allFeatures as $featureName => $featureType) : ?>
                <?php if ($featureType == 'SECTION') : ?>
                  <tr class="feature-row">
                    <td class="features-name bg-dark text-white" colspan="<?= 1 + sizeof($plansTable) ?>"><?= $featureName ?></td>
                  </tr>
                <?php else : ?>
                  <tr class="feature-row">
                    <td class="features-name"><?= $featureName ?></td>

                    <?php foreach ($plansTable as $plan): ?>
                        <td class="features-item text-center">
                          <?= $plan['features'][$featureName] ?? '-' ?>
                        </td>
                    <?php endforeach; ?>
                  </tr>
                <?php endif ?>

                <?php $counter++; ?>

                <?php if ($counter == 6) : ?>
                   </tbody>

                    <tbody class="collapse collapsePlansTable" id="collapsePlansTable">
                <?php endif ?>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- ver mas informacion -->
  <a class="btn-more-info" data-toggle="collapse" href=".collapsePlansTable" role="button" aria-expanded="false" aria-controls="collapsePlansTable">
    <span class="collapse show collapsePlansTable" style="transition: none !important;">Ver más características</span>
    <span class="collapse collapsePlansTable" style="transition: none !important;">Ver menos características</span>
  </a>
</div>