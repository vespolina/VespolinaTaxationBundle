<?php
/**
 * (c) Vespolina Project http://www.vespolina-project.org
 *
 * (c) Daniel Kucharski <daniel@xerias.be>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
 
namespace Vespolina\TaxationBundle\Model;

interface TaxZoneInterface
{
    /**
     * Get unique identifier
     */
    public function getId();

    /**
     * Name of the tax zone
     */
    public function getName();

    /**
     * Set the tax zone id
     *
     * @abstract
     * @param  $id
     * @return void
     */
    public function setId($id);

    /**
     * Set the tax zone name
     *
     * @abstract
     * @param  $name
     * @return void
     */
    public function setName($name);
}
