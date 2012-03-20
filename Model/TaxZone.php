<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\TaxationBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
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

    public function __construct()
    {

        $this->rates = new ArrayCollection();
    }

    /**
     * @inheritdoc
     */
    public function addRate(TaxRateInterface $rate)
    {

        $this->rates->set($rate->getCode(), $rate);
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
    public function getRates(TaxCategoryInterface $category = null)
    {

       return $this->rates;
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
