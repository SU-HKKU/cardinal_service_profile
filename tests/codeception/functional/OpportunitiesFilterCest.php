<?php

/**
 * Class OpportunitiesFilterCest.
 */
class OpportunitiesFilterCest {

  /**
   * Test the PDB is available and displays nodes when filtering.
   */
  public function testFilters(FunctionalTester $I) {
    /** @var \Drupal\node\NodeInterface $node */
    $I->logInWithRole('site_manager');
    $node = $I->createEntity([
      'type' => 'stanford_page',
      'title' => 'Filters Page',
    ]);
    $filter_url = $node->toUrl()->toString();
    $this->createOpportunityNodes($I);

    $I->amOnPage($filter_url);
    $I->click('Layout');
    $I->click('Add block');
    $I->waitForAjaxToFinish();
    $I->click('Opportunities Filtering List');
    $I->waitForAjaxToFinish();
    $I->click('Add block');
    $I->waitForAjaxToFinish();
    $I->click('Add block');
    $I->waitForAjaxToFinish();
    $I->click('Opportunities: All Filtered');
    $I->waitForAjaxToFinish();
    $I->click('Add block');
    $I->waitForAjaxToFinish();
    $I->click('Save layout');
    $I->canSeeNumberOfElements('.views-row', 10);

    $I->waitForElementVisible('.MuiFormControl-root', 5);
    $I->click('.su_opp_type-select .MuiAutocomplete-popupIndicator');
    $I->click('#su_opp_type-option-0');

    $I->click('.su_opp_open_to-select');
    $I->click('#su_opp_open_to-option-0');

    $I->click('.su_opp_time_year-select');
    $I->click('#su_opp_time_year-option-0');

    $I->click('Search', '#opportunities-filter-list');
    $I->canSeeNumberOfElements('.views-row', [1, 10]);
  }

  protected function createOpportunityNodes(FunctionalTester $I) {
    $terms = $this->createTerms($I);
    for ($j = 0; $j <= 10; $j++) {
      $values = [
        'type' => 'su_opportunity',
        'title' => "Opportunity $j",
        'su_opp_open_to' => $terms['su_opportunity_open_to'][$j % 3]->id(),
        'su_opp_location' => $terms['su_opportunity_location'][($j + 1) % 3]->id(),
        'su_opp_time_year' => $terms['su_opportunity_time'][($j + 2) % 3]->id(),
        'su_opp_type' => $terms['su_opportunity_type'][$j % 3]->id(),
      ];
      $I->createEntity($values);
    }
  }

  protected function createTerms(FunctionalTester $I) {
    $vids = [
      'su_opportunity_open_to',
      'su_opportunity_location',
      'su_opportunity_time',
      'su_opportunity_type',
    ];
    $terms = [];
    foreach ($vids as $vid) {
      $terms[$vid][] = $I->createEntity([
        'vid' => $vid,
        'name' => 'foo',
      ], 'taxonomy_term');
      $terms[$vid][] = $I->createEntity([
        'vid' => $vid,
        'name' => 'bar',
      ], 'taxonomy_term');
      $terms[$vid][] = $I->createEntity([
        'vid' => $vid,
        'name' => 'baz',
      ], 'taxonomy_term');
    }
    return $terms;
  }

}
