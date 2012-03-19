<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * (c) Daniel Kucharski <daniel@xerias.be>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\TaxationBundle\Model;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Vespolina\TaxationBundle\Model\TaxCategoryInterface;
use Vespolina\TaxationBundle\Model\TaxRate;
use Vespolina\TaxationBundle\Model\TaxRateInterface;
use Vespolina\TaxationBundle\Model\TaxZone;
use Vespolina\TaxationBundle\Model\TaxZoneInterface;
use Vespolina\TaxationBundle\Model\TaxationManagerInterface;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class TaxationManager extends ContainerAware implements TaxationManagerInterface
{

    protected $zones;

    public function __construct() {

        $this->zones = array();
    }
  
    /**
     * @inheritdoc
     */
    public function createRateForZone($code, $rate, TaxCategoryInterface $category, TaxZoneInterface $zone)
    {

        $rate = new TaxRate();
        $rate->setCategory($category);
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

        if ($parentZone) {
            
            $parentZone->addZone($zone);
            
        } else {

            $this->zones[$code] = $zone;
        }

        return $zone;
    }

    /**
     * @inheritdoc
     */
    public function getRatesForZone(TaxZoneInterface $zone, TaxCategoryInterface $category)
    {

        return $zone->getRates($category);

    }

    /**
     * @inheritdoc
     */
    public function getZoneByCode($code)
    {
        if (array_key_exists($code, $this->zones)) {

            return $this->zones[$code];
        }
    }

    /**
     * @inheritdoc
     */
    public function getZoneByCodePath($code)
    {

        $zone = null;

        //Traverse the path if a "." exists
        if (strpos($code, '.')) {

            foreach( explode('.', $code) as $part) {

                if ($zone) {

                    $zone = $zone->getZone($part);

                } else {
              
                    $zone = $this->getZoneByCode($part);


                }
            }
        }

        return $zone;
    }
}
