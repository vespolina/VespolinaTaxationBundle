<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\TaxationBundle\Entity;

use Vespolina\TaxationBundle\Model\TaxRate as AbstractTaxRate;
/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class TaxRate extends AbstractTaxRate
{
    protected $id;
    protected $tax_category_id;
    protected $tax_zone_id;
}