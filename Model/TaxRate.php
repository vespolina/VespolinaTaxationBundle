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


/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class TaxRate implements TaxRateInterface
{
    protected $taxCategory;
    protected $code;
    protected $name;
    protected $rate;
    protected $taxZone;

    public function __construct()
    {

    }

    public function getTaxCategory()
    {

        return $this->taxCategory;
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
    public function getRate()
    {

        return $this->rate;
    }

    /**
     * @inheritdoc
     */
    public function setTaxCategory(TaxCategoryInterface $taxCategory)
    {
        $this->taxCategory = $taxCategory;
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

    /**
     * @inheritdoc
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function setTaxZone($taxZone)
    {
        $this->taxZone = $taxZone;
    }

    public function getTaxZone()
    {
        return $this->taxZone;
    }
}
