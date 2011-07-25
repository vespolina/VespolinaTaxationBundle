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
    protected $category;
    protected $code;
    protected $name;
    protected $rate;


    public function __construct()
    {

    }

    public function getCategory()
    {

        return $this->category;
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
    public function setCategory(TaxCategoryInterface $category)
    {
        $this->category = $category;
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
}
