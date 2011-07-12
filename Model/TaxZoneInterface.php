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

interface TaxZoneInterface
{

    /**
     * Add the given rate to this zone
     *
     * @abstract
     * @param TaxRateInterface $rate
     * @return void
     */
    function addRate(TaxRateInterface $rate);


    /**
     * Get tax zone code (should be unique)
     */
    function getCode();

    /**
     * Name of the tax zone
     */
    function getName();

    /**
     * Retrieve a list of available rates
     *
     * @abstract
     * @return void
     */
    function getRates();

    /**
     * Set the tax zone code
     *
     * @abstract
     * @param  $code
     * @return void
     */
    function setCode($cpde);

    /**
     * Set the tax zone name
     *
     * @abstract
     * @param  $name
     * @return void
     */
    function setName($name);
}
