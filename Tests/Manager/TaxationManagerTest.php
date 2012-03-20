<?php

namespace Vespolina\TaxationBundle\Tests\Manager;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Vespolina\TaxationBundle\Model\TaxRate;
use Vespolina\TaxationBundle\Model\TaxZone;
use Vespolina\TaxationBundle\Model\TaxCategory\SalesTaxCategory;
use Vespolina\TaxationBundle\Model\TaxCategory\VATTaxCategory;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class TaxationManagerTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = $this->createClient();
    }

    public function getKernel(array $options = array())
    {
        if (!self::$kernel) {
            self::$kernel = $this->createKernel($options);
            self::$kernel->boot();
        }

        return self::$kernel;
    }

    public function testCreateTaxationZonesAndRatesForBE()
    {
        $taxationManager = $this->getKernel()->getContainer()->get('vespolina.taxation_manager');

        $vatTaxCategory = new \Vespolina\TaxationBundle\Model\TaxCategory\VATTaxCategory();


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
        $taxationManager = $this->getKernel()->getContainer()->get('vespolina.taxation_manager');

        $salesTaxCategory = new \Vespolina\TaxationBundle\Model\TaxCategory\SalesTaxCategory();
               
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
        $taxationManager = $this->getKernel()->getContainer()->get('vespolina.taxation_manager');

        $zones = $taxationManager->loadTaxSchema('be');
        foreach($zones as $zone) {
            $taxationManager->updateTaxZone($zone);
        }

    }

    public function testCalculateTax()
    {
        $this->testCreateTaxationZonesAndRatesForBE();

        return; //Ignore for now further testing

        $pricingManager = $this->getKernel()->getContainer()->get('vespolina.pricing');
        $pricingManager->loadPricingConfigurationFile(__DIR__.'/../config','tax_pricing_test.xml');

        //Retrieve pricing meta data
        $pricingConfiguration = $pricingManager->getPricingConfiguration('tax_product_default');
        $pricingContextContainer = $pricingManager->createPricingContextContainer($pricingConfiguration);

        //Prepare the pricing context container
        $pricingContextContainer->set('net_value', '100');

        //The pricing set will in the end be stored together with the related entity such as a product, sales order, ...
        $pricingSet = $pricingManager->createPricingSet($pricingConfiguration);


        /** If the country is not set, tax determination is not possible
         * In this case an InvalidArgumentException will be raised.  Let's test if this is indeed working!
         */

        $invalidArgumentExceptionRaised = 0;

        try{

            $pricingManager->buildPricingSet(
                      $pricingSet,
                      $pricingContextContainer,
                      array('execution_event' => 'all'));

        }catch(\InvalidArgumentException $e)
        {
            $invalidArgumentExceptionRaised++;
        }

        $this->assertEquals($invalidArgumentExceptionRaised, 1);

        //Fix the error by setting the country
        $pricingContextContainer->set('country', 'be');

        try{
            $pricingManager->buildPricingSet(
                      $pricingSet,
                      $pricingContextContainer,
                      array('execution_event' => 'all'));

        }catch(\InvalidArgumentException $e)
        {
            $invalidArgumentExceptionRaised++;
        }

        $this->assertEquals($invalidArgumentExceptionRaised, 1);

        $this->assertEquals($pricingContextContainer->get('total_tax'), 22.05);
        //print_r($pricingContextContainer->getContainerData());

    }

}