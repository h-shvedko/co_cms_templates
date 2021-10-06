<?php
/**
 * Created by PhpStorm.
 * User: hennadii.shvedko
 * Date: 01/10/2018
 * Time: 16:44
 */

namespace ContentManager\Entities;


use ContentManager\App\core\ORM\AModel;

class Templates extends AModel
{
    /**
     * @var string Name of DB table
     */
    protected $tableName = 'templates';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $identifier;

    /**
     * @var int
     */
    public $default_template;

    /**
     * @var string
     */
    public $description;

    /**
     * @var int
     */
    public $site_structure_id;

    /**
     * @var string
     */
    public $_created;

    /**
     * @var string
     */
    public $_modified;

    /**
     * @var int
     */
    public $_modified_by;

    /**
     * @var string
     */
    public $_accessed;

    /**
     * @var int
     */
    public $livesite;

    /**
     * @var string
     */
    public $global_container;

    /**
     * @var int
     */
    public $reference_for_global_container;

    /**
     * @var string
     */
    public $removable_container_in_extended_content;

    /**
     * @var int
     */
    public $additional_cssfile_for_extended_content;

    /**
     * @var string
     */
    public $cdn;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * @return int
     */
    public function getDefaultTemplate(): int
    {
        return $this->default_template;
    }

    /**
     * @param int $default_template
     */
    public function setDefaultTemplate(int $default_template)
    {
        $this->default_template = $default_template;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getSiteStructureId(): int
    {
        return $this->site_structure_id;
    }

    /**
     * @param int $site_structure_id
     */
    public function setSiteStructureId(int $site_structure_id)
    {
        $this->site_structure_id = $site_structure_id;
    }

    /**
     * @return string
     */
    public function getCreated(): string
    {
        return $this->_created;
    }

    /**
     * @param string $created
     */
    public function setCreated(string $created)
    {
        $this->_created = $created;
    }

    /**
     * @return string
     */
    public function getModified(): string
    {
        return $this->_modified;
    }

    /**
     * @param string $modified
     */
    public function setModified(string $modified)
    {
        $this->_modified = $modified;
    }

    /**
     * @return int
     */
    public function getModifiedBy(): int
    {
        return $this->_modified_by;
    }

    /**
     * @param int $modified_by
     */
    public function setModifiedBy(int $modified_by)
    {
        $this->_modified_by = $modified_by;
    }

    /**
     * @return string
     */
    public function getAccessed(): string
    {
        return $this->_accessed;
    }

    /**
     * @param string $accessed
     */
    public function setAccessed(string $accessed)
    {
        $this->_accessed = $accessed;
    }

    /**
     * @return int
     */
    public function getLivesite(): int
    {
        return $this->livesite;
    }

    /**
     * @param int $livesite
     */
    public function setLivesite(int $livesite)
    {
        $this->livesite = $livesite;
    }

    /**
     * @return string
     */
    public function getGlobalContainer(): string
    {
        return $this->global_container;
    }

    /**
     * @param string $global_container
     */
    public function setGlobalContainer(string $global_container)
    {
        $this->global_container = $global_container;
    }

    /**
     * @return int
     */
    public function getReferenceForGlobalContainer(): int
    {
        return $this->reference_for_global_container;
    }

    /**
     * @param int $reference_for_global_container
     */
    public function setReferenceForGlobalContainer(int $reference_for_global_container)
    {
        $this->reference_for_global_container = $reference_for_global_container;
    }

    /**
     * @return string
     */
    public function getRemovableContainerInExtendedContent(): string
    {
        return $this->removable_container_in_extended_content;
    }

    /**
     * @param string $removable_container_in_extended_content
     */
    public function setRemovableContainerInExtendedContent(string $removable_container_in_extended_content)
    {
        $this->removable_container_in_extended_content = $removable_container_in_extended_content;
    }

    /**
     * @return int
     */
    public function getAdditionalCssfileForExtendedContent(): int
    {
        return $this->additional_cssfile_for_extended_content;
    }

    /**
     * @param int $additional_cssfile_for_extended_content
     */
    public function setAdditionalCssfileForExtendedContent(int $additional_cssfile_for_extended_content)
    {
        $this->additional_cssfile_for_extended_content = $additional_cssfile_for_extended_content;
    }

    /**
     * @return string
     */
    public function getCdn(): string
    {
        return $this->cdn;
    }

    /**
     * @param string $cdn
     */
    public function setCdn(string $cdn)
    {
        $this->cdn = $cdn;
    }
}