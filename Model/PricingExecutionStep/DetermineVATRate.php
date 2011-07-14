<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * (c) Daniel Kucharski <daniel@xerias.be>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\TaxationBundle\Model\PricingExecutionStep;

use Vespolina\PricingBundle\Model\PricingExecutionStep;
use Vespolina\PricingBundle\Model\PricingContextContainerInterface;

class DetermineVATRate extends PricingExecutionStep
{
    public function execute()
    {
        $strategy = $this->getOption('strategy');
        $vatRate = 0;

        switch ($strategy) {
            case 'region_based':

                $country =  $this->pricingContextContainer->get('country');

                if (!$country)
                {
                    throw new \InvalidArgumentException(sprintf('Pricing execution step "%s" needs pricing context container value "country"', $this->name));
                }

                $source = $this->pricingContextContainer->get($this->getOption('source'));

                //$country = $source->getAddress()->getCountry();
                switch ($country) {
                    case 'BE':
                        $vatRate = 21;
                        break;
                }
                $this->pricingContextContainer->set(
                    $this->getOption('target'),
                    $vatRate);
        }
    }
}
