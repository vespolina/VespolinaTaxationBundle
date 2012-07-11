<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\TaxationBundle\Tests;


use Vespolina\PartnerBundle\Model\Partner;
use Vespolina\PartnerBundle\Model\PartnerManager;

abstract class TaxationTestCommon extends \PHPUnit_Framework_TestCase
{

    public function createTaxationManager()
    {
            return
                $this->getMockForAbstractClass('Vespolina\TaxationBundle\Model\TaxationManager',
                array(
                		'Vespolina\TaxationBundle\Model\TaxCategory',
                        'Vespolina\TaxationBundle\Model\TaxRate',
                        'Vespolina\TaxationBundle\Model\TaxZone'
                ));
    }
}