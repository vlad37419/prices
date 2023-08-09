<?= $f_AdminCommon; ?>
<?php
$sql_select_prices = "SELECT name, price, subs, category, category_service FROM `Message256`";
$prices = $nc_core->db->get_results($sql_select_prices, $output = ARRAY_A);

$pricesGroup = [];
foreach ($prices as $price) {
  $key = $price['category_service'];
  if (!isset($pricesGroup[$key])) {
    $pricesGroup[$key] = array($price);
  } else {
    $pricesGroup[$key][] = $price;
  }
}

$allSubs = [];
$allPurentSub = [];
foreach ($prices as $price) {
  $priceSubs = explode(',', $price['subs']);
  $allSubs = array_merge($allSubs, $priceSubs);
}

$treeSub = $nc_core->subdivision->get_parent_tree($current_sub['Subdivision_ID']);
foreach ($treeSub as $value) {
  $allPurentSub[] = $value['Subdivision_ID'];
}
$allPurentSub = array_diff($allPurentSub, array(''));
$allSubs = array_diff($allSubs, array(''));
?>
<?php if (array_intersect($allPurentSub, $allSubs)): ?>
  <section class="prices tabs-container section-offset">
    <div class="prices__container container">
      <div class="prices__info">
        <h2 class="prices__title section-title">
          Цены на услуги
        </h2>
        <div class="prices__tabs tabs">
          <button class="tabs__active">
            <p class="tabs__active-text"></p>
            <svg class="tabs__active-icon" width="10" height="7" viewBox="0 0 10 7" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <path d="M1 1L5 5L9 1" stroke="white" stroke-width="1.5" />
            </svg>
          </button>
          <div class="tabs__container">
            <div class="tabs__content">
              <div class="tabs__wrapper">
                <button class="tabs__close">
                  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 1L1 17" stroke="#B0BBCE" stroke-width="1.5"></path>
                    <path d="M17 17L1 1" stroke="#B0BBCE" stroke-width="1.5"></path>
                  </svg>
                </button>
                <?php foreach ($pricesGroup as $category_service => $prices): ?>
                  <button class="tabs__item tab">
                    <?= $category_service ?>
                  </button>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="prices__wrapper" data-aos="fade-up" data-aos-duration="600">
        <?php foreach ($pricesGroup as $category_service => $prices): ?>
          <div class="prices__content tab-content">
            <p class="prices__name">
              <?= $category_service ?>
            </p>
            <?php foreach ($prices as $price):
              $currentSubs = [];
              if (!empty($price['subs'])) {
                $currentSubs = explode(',', $price['subs']);
              }
              if (array_intersect($allPurentSub, $currentSubs)): ?>
                <div class="prices__table table-prices">
                  <div class="table-prices__row">
                    <p class="table-prices__name">
                      <?= $price['name'] ?>
                    </p>
                    <div class="table-prices__action">
                      <p class="table-prices__price">
                        <?= $price['price'] ?>
                      </p>
                      <button class="table-prices__btn popup-btn" data-path="form"
                        data-additional="Кнопка в блоке цен на услугу '<?= $price['name'] ?>'"
                        data-title="<?= $price['name'] ?>">
                        Заказать
                      </button>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>