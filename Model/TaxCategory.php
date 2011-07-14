<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Vespolina\TaxationBundle\Model;

use Vespolina\TaxationBundle\Model\TaxCategoryInterface;

/**
 * TaxCategory holds the basic tax classification for various entities such as
 *  - defining the customer tax category.  eg. "wholesale customer"
 *  - defining the product tax category eg. "prepared food"
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
class TaxCategory implements TaxCategoryInterface
{
    protected $id;
    protected $name;

    public function __construct()
    {

    }

    /**
     * @inheritdoc
     */
    public function getId()
    {

        return $this->id;
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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
