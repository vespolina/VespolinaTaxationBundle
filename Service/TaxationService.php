<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * (c) Daniel Kucharski <daniel@xerias.be>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\TaxationBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Vespolina\TaxationBundle\Model\TaxRate;
use Vespolina\TaxationBundle\Model\TaxRateInterface;
use Vespolina\TaxationBundle\Model\TaxZone;
use Vespolina\TaxationBundle\Model\TaxZoneInterface;

use Vespolina\TaxationBundle\Service\TaxationServiceInterface;

class TaxationService extends ContainerAware implements TaxationServiceInterface
{

    /**
     * @inheritdoc
     */
    public function createRateForZone($code, $rate, TaxZoneInterface $zone)
    {

        $rate = new TaxRate();
        $rate->setCode($zone->getCode() . '_' . $code);

        $zone->addRate($rate);
        return $rate;
    }


    /**
     * @inheritdoc
     */
    public function createZone($code, $name, TaxZoneInterface $parentZone = null)
    {

        $zone = new TaxZone();
        $zone->setCode($code);
        $zone->setName($name);

        if ($parentZone)
        {
            $parentZone->add($zone);
        }

        return $zone;
    }

    /**
     * @inheritdoc
     */
    function getRatesForZone(TaxZoneInterface $taxZone)
    {

        return $taxZone->getRates();

    }

}
