<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Vespolina\TaxationBundle\Entity;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;

use Vespolina\TaxationBundle\Entity\Taxation;
use Vespolina\TaxationBundle\Model\TaxationInterface;
use Vespolina\TaxationBundle\Model\TaxZoneInterface;
use Vespolina\TaxationBundle\Model\TaxationManager as BaseTaxationManager;
/**
 * @author Daniel Kucharski <daniel@xerias.be>
 * @author Richard Shank <develop@zestic.com>
 */
class TaxationManager extends BaseTaxationManager
{
    protected $taxationClass;
    protected $taxationRepo;
    protected $em;

    public function __construct(EntityManager $em, $taxCategoryClass, $taxRateClass, $taxZoneClass)
    {
        $this->em = $em;

        $this->taxZoneRepo = $this->em->getRepository($taxZoneClass);

        parent::__construct($taxCategoryClass, $taxRateClass, $taxZoneClass);

    }

    /**
     * @inheritdoc
     */
    public function updateTaxZone(TaxZoneInterface $taxZone, $andFlush = true)
    {
        $this->em->persist($taxZone);
        if ($andFlush) {
            $this->em->flush();
        }
    }
}
