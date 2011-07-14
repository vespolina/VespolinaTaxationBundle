<?php

namespace Vespolina\TaxationBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Vespolina\TaxationBundle\Model\TaxRate;
use Vespolina\TaxationBundle\Model\TaxZone;


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

    public function testCreateTaxationZonesAndRates()
    {
        $taxationService = $this->getKernel()->getContainer()->get('vespolina.taxation');

        $taxZoneBE = $taxationService->createZone('be', 'Belgium');

        $taxRateBE6 = $taxationService->createRateForZone('21%', 21, $taxZoneBE);
        $taxRateBE21 = $taxationService->createRateForZone('6%', 6, $taxZoneBE);
      
        $taxZonesForBE = $taxationService->getRatesForZone($taxZoneBE);
        
    }

    public function testCalculateTax()
    {
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
        $pricingContextContainer->set('country', 'BE');

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

        $this->assertEquals($pricingContextContainer->get('total_vat'), 22.05);
        //print_r($pricingContextContainer->getContainerData());
    }

}