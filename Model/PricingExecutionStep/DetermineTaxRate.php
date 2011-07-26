<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\TaxationBundle\Model\PricingExecutionStep;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Vespolina\PricingBundle\Model\PricingExecutionStep;
use Vespolina\PricingBundle\Model\PricingContextContainerInterface;
use Vespolina\TaxationBundle\Model\TaxCategory\SalesTaxCategory;
use Vespolina\TaxationBundle\Model\TaxCategory\VatTaxCategory;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class DetermineTaxRate extends PricingExecutionStep
{
    protected $container;

    public function execute(ContainerInterface $container)
    {

        $this->container = $container;

        $strategy = $this->getOption('strategy');
        $vatRate = 0;

        switch ($strategy) {

            case 'tax_zone_based':


                $this->determineByTaxZone();

        }
    }

    protected function determineByTaxZone() {

        $taxationService = $this->container->get('vespolina.taxation');
        $country =  $this->pricingContextContainer->get('country');

        if (!$country) {

            throw new \InvalidArgumentException(sprintf('Pricing execution step "%s" needs pricing context container value "country"', $this->name));
        }

        //For now we assume that the country is the top level tax zone
        $taxZone = $taxationService->getZoneByCode($country);
        if (!$taxZone) {

            throw new \InvalidArgumentException(sprintf('Pricing execution step "%s" cannot resolve a tax zone for "%s"', $this->name, $country));
        }


        $taxCategory = new VatTaxCategory();    //TODO: Tax categorization needs to come in through the context
        $taxRates = $taxationService->getRatesForZone($taxZone, $taxCategory);

        if (!$taxRates || count($taxRates) < 1 ) {

                throw new \InvalidArgumentException(sprintf('Pricing execution step "%s" cannot resolve a tax rate for "%s"', $this->name, $country));
        }


        $determinedTaxRate = null;

        //TODO: Do some magic to determine which available rate should be selected
        foreach($taxRates as $taxRate) {

            $determinedTaxRate = $taxRate; exit;
        }

        if ($determinedTaxRate) {
            $this->pricingContextContainer->set(
                $this->getOption('target'),
                $determinedTaxRate->getRate());
        }
    }
}
