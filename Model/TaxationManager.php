<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * (c) Daniel Kucharski <daniel@xerias.be>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\TaxationBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpKernel\Bundle\Bundle;

use Vespolina\TaxationBundle\Model\TaxCategoryInterface;
use Vespolina\TaxationBundle\Model\TaxRate;
use Vespolina\TaxationBundle\Model\TaxRateInterface;
use Vespolina\TaxationBundle\Model\TaxZone;
use Vespolina\TaxationBundle\Model\TaxZoneInterface;
use Vespolina\TaxationBundle\Model\TaxationManagerInterface;

/**
 * @author Daniel Kucharski <daniel@xerias.be>
 */
abstract class TaxationManager extends ContainerAware implements TaxationManagerInterface
{

    protected $taxCategoryClass;
    protected $taxRateClass;
    protected $taxZoneClass;
    protected $zones;

    public function __construct($taxCategoryClass, $taxRateClass, $taxZoneClass) {

        $this->taxCategoryClass = $taxCategoryClass;
        $this->taxRateClass = $taxRateClass;
        $this->taxZoneClass = $taxZoneClass;
        $this->zones = new ArrayCollection();
    }
  
    /**
     * @inheritdoc
     */
    public function createRateForZone($code, $rate, TaxCategoryInterface $category, TaxZoneInterface $zone)
    {

        $rate = new $this->taxRateClass;
        $rate->setCategory($category);
        $rate->setCode($zone->getCode() . '_' . $code);
        $zone->addRate($rate);
        
        return $rate;
    }


    /**
     * @inheritdoc
     */
    public function createZone($code, $name)
    {

        $zone = new $this->taxZoneClass;
        $zone->setCode($code);
        $zone->setName($name);

        $this->zones->set($code, $zone);

        return $zone;
    }

    /**
     * @inheritdoc
     */
    public function createTaxCategory($code, $name)
    {
        $taxCategory = new $this->taxCategoryClass;
        $taxCategory->setCode($code);
        $taxCategory->setName($name);

        return $taxCategory;
    }

    /**
     * @inheritdoc
     */
    public function getRatesForZone(TaxZoneInterface $zone, TaxCategoryInterface $category)
    {
        return $zone->getRates($category);
    }

    /**
     * @inheritdoc
     */
    public function findZoneByCode($code)
    {
        return $this->zones->get($code);
    }


    public function loadTaxSchema($country) {

        $zones = array();

        $xmlFile = __DIR__ . '/../Resources/config/taxschemas/' . strtolower($country) . '.xml';
        if (!$xmlZones = simplexml_load_file($xmlFile)) {

            return $zones;
        }

        //Init tax categories
        $defaultTaxCategory = $this->createTaxCategory('default', 'default');

        //Create zones
        foreach ($xmlZones as $xmlZone) {


            $country = '';
            $name = '';
            $selection = (string)$xmlZone->selection;
            $state = '';
            $type = (string)$xmlZone->type;

            //Get regional information for this zone
            foreach ($xmlZone->zone->attributes() as $xmlName => $xmlValue) {

                switch ($xmlName) {
                    case 'country':
                        $country = (string)$xmlValue;
                        break;
                    case 'name':
                        $name = (string)$xmlValue;
                        break;
                    case 'state':
                        $state = (string)$xmlValue;
                        break;
                }
            }

            if (!$country && !$state) {
                continue;
            }

            $location = ($state? $country . '-' . $state : $country);

            //Create the zone
            $zone = $this->createZone($location, $name);

            //Create tax rates per zone
            foreach ($xmlZone->zone->tax_rates as $xmlTaxRate) {

                $taxRate = (string)$xmlTaxRate->tax_rate->rate;

                $this->createRateForZone($taxRate, $taxRate, $defaultTaxCategory, $zone);
            }

            $zones[] = $zone;
        }

        return $zones;
    }
}
