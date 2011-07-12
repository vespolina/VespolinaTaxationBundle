<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
 
namespace Vespolina\TaxationBundle\Model;

/**
 * TaxCategory holds the basic tax classification for various entities such as
 *  - defining the customer tax category.  eg. "wholesale customer"
 *  - defining the product tax category eg. "prepared food"
 *
 * @author Daniel Kucharski <daniel@xerias.be>
 */
interface TaxCategoryInterface
{
    /**
     * Get unique identifier
     */
    public function getId();

    /**
     * Name of the tax category
     */
    public function getName();

    /**
     * Set the tax category id
     *
     * @abstract
     * @param  $id
     * @return void
     */
    public function setId($id);

    /**
     * Set the tax category name
     *
     * @abstract
     * @param  $name
     * @return void
     */
    public function setName($name);
}
