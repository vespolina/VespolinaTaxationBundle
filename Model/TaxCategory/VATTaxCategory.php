<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\TaxationBundle\Model\TaxCategory;

use Vespolina\TaxationBundle\Model\TaxCategory;

/**
 * TaxCategory holds the basic tax classification for various entities such as
 *  - defining the customer tax category.  eg. "wholesale customer"
 *  - defining the product tax category eg. "prepared food"
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class VATTaxCategory extends TaxCategory
{

    public function getCode()
    {

        return 'vat';
    }
 
}
