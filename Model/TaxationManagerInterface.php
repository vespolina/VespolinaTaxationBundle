<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\TaxationBundle\Model;

use Vespolina\TaxationBundle\Model\TaxCategoryInterface;
use Vespolina\TaxationBundle\Model\TaxZoneInterface;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
interface TaxationManagerInterface
{
    /**
     * Create a new rate and attach it to the given zone
     *
     * @abstract
     * @param $code
     * @param $rate
     * @param \Vespolina\TaxationBundle\Model\TaxZoneInterface $zone
     * @return void
     */
    function createRateForZone($code, $rate, TaxCategoryInterface $taxCategory, TaxZoneInterface $zone);


    /**
     * Create a new tax zone
     *
     * @abstract
     * @param $code Tax code
     * @param $name Descriptive name
     * @return TaxZoneInterface instance
     */
    function createZone($code, $name);

    /**
     * Get all tax rates for a given zone
     *
     * @abstract
     * @param TaxZoneInterface $taxZone
     * @return array()
     */
    function getRatesForZone(TaxZoneInterface $zone, TaxCategoryInterface $taxCategory);

    /**
     * Retrieve a specific tax zone by its code
     */
    function findZoneByCode($code);
}
