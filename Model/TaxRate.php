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

class TaxRate implements TaxRateInterface
{
    protected $code;
    protected $name;
    protected $rate;

    public function __construct()
    {

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
