<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\TaxationBundle\Document;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ODM\MongoDB\DocumentManager;

use Vespolina\TaxationBundle\Document\TaxZone;
use Vespolina\TaxationBundle\Model\TaxZoneInterface;
use Vespolina\TaxationBundle\Model\TaxationManager as BaseTaxationManager;
/**
 * @author Daniel Kucharski <daniel@xerias.be>
 * @author Richard Shank <develop@zestic.com>
 */
class TaxationManager extends BaseTaxationManager
{
    protected $taxationRepo;
    protected $dm;
    protected $primaryIdentifier;

    public function __construct(DocumentManager $dm, $taxCategoryClass, $taxRateClass, $taxZoneClass)
    {
        $this->dm = $dm;

        $this->taxZoneRepo = $this->dm->getRepository($taxZoneClass);

        parent::__construct($taxCategoryClass, $taxRateClass, $taxZoneClass);
    }

    /**
     * @inheritdoc
     */
    public function updateTaxZone(TaxZoneInterface $taxZone, $andFlush = true)
    {
        $this->dm->persist($taxZone);
        if ($andFlush) {
            $this->dm->flush();
        }
    }
}
