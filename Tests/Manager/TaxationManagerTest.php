<?php

namespace Vespolina\TaxationBundle\Tests\Manager;

use Vespolina\TaxationBundle\Tests\TaxationTestCommon;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class TaxationManagerTest extends TaxationTestCommon
{

    public function testCreateTaxationZonesAndRatesForBE()
    {
        $taxationManager = $this->createTaxationManager();

        $vatTaxCategory = $taxationManager->createTaxCategory('vat', 'vat');
        $taxZoneBE = $taxationManager->createZone('be', 'Belgium');

        $taxRateBE6 = $taxationManager->createRateForZone('be21', 21, $vatTaxCategory, $taxZoneBE);
        $taxRateBE21 = $taxationManager->createRateForZone('be6', 6, $vatTaxCategory, $taxZoneBE);

        //Test retrieval of a registered zone
        $testTaZoneBe = $taxationManager->findZoneByCode('be');

        $this->assertEquals($testTaZoneBe->getName(), 'Belgium');

        $taxRatesForBE = $taxationManager->getRatesForZone($testTaZoneBe, $vatTaxCategory);
        $this->assertEquals($taxRatesForBE->count(), 2);
    }

    public function testCreateTaxationZonesAndRatesForUS()
    {
        $taxationManager = $this->createTaxationManager();
        $salesTaxCategory = new \Vespolina\TaxationBundle\Model\TaxCategory\SalesTaxCategory();
        $salesTaxCategory = $taxationManager->createTaxCategory('sales', 'sales');
        $taxZoneUS = $taxationManager->createZone('us', 'United States');
        $taxZoneNY = $taxationManager->createZone('us-ny', 'New York');
        $taxZoneOR = $taxationManager->createZone('us-or', 'Oregon');
        $taxZoneNYUtica = $taxationManager->createZone('us-ny-ut', 'Utica');

        $taxRateNYUtica = $taxationManager->createRateForZone('sales_tax', 8.75, $salesTaxCategory, $taxZoneNYUtica);

        //Oregon has no sales tax
        $taxRateOR = $taxationManager->createRateForZone('sales_tax', 0, $salesTaxCategory, $taxZoneOR);

        //Test retrieval of a registered zone
        $testTaZoneUS = $taxationManager->findZoneByCode('us');

        $this->assertEquals($testTaZoneUS->getCode(), 'us');

        //Test retrieval of a registered sub sub zone
        $testTaZoneUtica = $taxationManager->findZoneByCode('us-ny-ut');
        $this->assertEquals($testTaZoneUtica->getCode(), 'us-ny-ut');
    }


    public function testLoadTaxSchema()
    {
        $taxationManager = $this->createTaxationManager();

        $taxSchema = $taxationManager->loadTaxSchema('us');

        $this->assertGreaterThan(1, count($taxSchema['zones']));
        foreach ($taxSchema['zones'] as $zone) {
        }

    }

}