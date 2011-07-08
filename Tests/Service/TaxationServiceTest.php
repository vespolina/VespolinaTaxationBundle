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

    public function testCreateTaxationZones()
    {
        $taxationService = $this->getKernel()->getContainer()->get('vespolina.taxation');

        $taxZoneBE = new TaxZone();
        $taxZoneBE->setName('Belgium');

        $taxRate21 = new TaxRate();
        $taxRate21->setRate(21);

        $taxationService->addRateToZone($taxRate21, $taxZoneBE);
        


    }

}