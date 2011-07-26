<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\TaxationBundle\Model;

use Vespolina\TaxationBundle\Model\TaxCategoryInterface;
use Vespolina\TaxationBundle\Model\TaxRateInterface;
use Vespolina\TaxationBundle\Model\TaxZoneInterface;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class TaxZone implements TaxZoneInterface
{
    protected $code;
    protected $name;
    protected $rates;
    protected $zones;

    public function __construct()
    {

        $this->rates = array();
        $this->zones = array();

    }

    /**
     * @inheritdoc
     */
    public function addRate(TaxRateInterface $rate)
    {

        $this->rates[$rate->getCategory()->getCode()][$rate->getCode()] = $rate;
    }
    
    /**
     * @inheritdoc
     */
    public function addZone(TaxZone $zone)
    {

        $this->zones[$zone->getCode()] = $zone;
    }


    /**
     * @inheritdoc
     */
    public function getCode()
    {

        return $this->code;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {

        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function getRates(TaxCategoryInterface $category)
    {

       return $this->rates[$category->getCode()];
    }

    /**
     * @inheritdoc
     */
    public function getZone($code)
    {
        if (array_key_exists($code, $this->zones)) {

            return $this->zones[$code];
        }
    }
    
    /**
     * @inheritdoc
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
