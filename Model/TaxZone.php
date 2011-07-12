<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * (c) Daniel Kucharski <daniel@xerias.be>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\TaxationBundle\Model;

use Vespolina\TaxationBundle\Model\TaxRateInterface;
use Vespolina\TaxationBundle\Model\TaxZoneInterface;

class TaxZone implements TaxZoneInterface
{
    protected $code;
    protected $name;
    protected $rates;

    public function __construct()
    {

        $this->rates = array();

    }

    /**
     * @inheritdoc
     */
    public function addRate(TaxRateInterface $rate)
    {

        $this->rate[$rate->getCode()] = $rate;
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
    public function getRates()
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
