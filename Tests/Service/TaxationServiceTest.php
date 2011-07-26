<?php

namespace Vespolina\TaxationBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Vespolina\TaxationBundle\Model\TaxRate;
use Vespolina\TaxationBundle\Model\TaxZone;
use Vespolina\TaxationBundle\Model\TaxCategory\SalesTaxCategory;
use Vespolina\TaxationBundle\Model\TaxCategory\VATTaxCategory;



/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class TaxationServiceTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        $this->client = $this->createClient();
    }

    public function getKernel(array $options = array())
    {
        if (!$this->kernel) {
            $this->kernel = $this->createKernel($options);
            $this->kernel->boot();
        }

        return $this->kernel;
    }

    public function testCreateTaxationZonesAndRatesForBE()
    {
        $taxationService = $this->getKernel()->getContainer()->get('vespolina.taxation');

        $vatTaxCategory = new \Vespolina\TaxationBundle\Model\TaxCategory\VATTaxCategory();


        $taxZoneBE = $taxationService->createZone('be', 'Belgium');

        $taxRateBE6 = $taxationService->createRateForZone('be21', 21, $vatTaxCategory, $taxZoneBE);
        $taxRateBE21 = $taxationService->createRateForZone('be6', 6, $vatTaxCategory, $taxZoneBE);


        //Test retrieval of a registered zone
        $testTaZoneBe = $taxationService->getZoneByCode('be');

        $this->assertEquals($testTaZoneBe->getName(), 'Belgium');

        $taxRatesForBE = $taxationService->getRatesForZone($testTaZoneBe, $vatTaxCategory);
        $this->assertEquals(count($taxRatesForBE), 2);
    }

    public function testCreateTaxationZonesAndRatesForUS()
    {
        $taxationService = $this->getKernel()->getContainer()->get('vespolina.taxation');

        $salesTaxCategory = new \Vespolina\TaxationBundle\Model\TaxCategory\SalesTaxCategory();
               
        $taxZoneUS = $taxationService->createZone('us', 'United States');
        $taxZoneNY = $taxationService->createZone('ny', 'New York', $taxZoneUS);
        $taxZoneOR = $taxationService->createZone('or', 'Oregon', $taxZoneUS);
        $taxZoneNYUtica = $taxationService->createZone('ut', 'Utica', $taxZoneNY);

        $taxRateNYUtica = $taxationService->createRateForZone('sales_tax', 8.75, $salesTaxCategory, $taxZoneNYUtica);

        //Oregon has no sales tax
        $taxRateOR = $taxationService->createRateForZone('sales_tax', 0, $salesTaxCategory, $taxZoneOR);

        //Test retrieval of a registered zone
        $testTaZoneUS = $taxationService->getZoneByCode('us');

        $this->assertEquals($testTaZoneUS->getCode(), 'us');

        //Test retrieval of a registered sub sub zone
        $testTaZoneUtica = $taxationService->getZoneByCodePath('us.ny.ut');
        $this->assertEquals($testTaZoneUtica->getCode(), 'ut');


    }




    public function testCalculateTax()
    {
        $this->testCreateTaxationZonesAndRatesForBE();

        $pricingService = $this->getKernel()->getContainer()->get('vespolina.pricing');
        $pricingService->loadPricingConfigurationFile(__DIR__.'/../config','tax_pricing_test.xml');

        //Retrieve pricing meta data
        $pricingConfiguration = $pricingService->getPricingConfiguration('tax_product_default');
        $pricingContextContainer = $pricingService->createPricingContextContainer($pricingConfiguration);

        //Prepare the pricing context container
        $pricingContextContainer->set('net_value', '100');

        //The pricing set will in the end be stored together with the related entity such as a product, sales order, ...
        $pricingSet = $pricingService->createPricingSet($pricingConfiguration);


        /** If the country is not set, tax determination is not possible
         * In this case an InvalidArgumentException will be raised.  Let's test if this is indeed working!
         */

        $invalidArgumentExceptionRaised = 0;

        try{

            $pricingService->buildPricingSet(
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
            $pricingService->buildPricingSet(
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