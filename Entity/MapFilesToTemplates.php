<?php
/**
 * Created by PhpStorm.
 * User: hennadii.shvedko
 * Date: 01/10/2018
 * Time: 16:44
 */

namespace ContentManager\Entities;

class MapFilesToTemplates
{
    /**
     * @var string Name of DB table
     */
    protected $tableName = 'map_files_to_templates';

    /**
     * @var int
     */
    public $id_template;

    /**
     * @var int
     */
    public $id_file;

    /**
     * @var string
     */
    public $type;

    /**
     * @var int
     */
    public $embedd;

    /**
     * @var int
     */
    public $livesite;

    /**
     * @var int
     */
    public $sorter;

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
    public $_created;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id_template;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id_template = $id;
    }

    /**
     * @return int
     */
    public function getIdFile(): int
    {
        return $this->id_file;
    }

    /**
     * @param int $id_file
     */
    public function setIdFile(int $id_file)
    {
        $this->id_file = $id_file;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getEmbedd(): int
    {
        return $this->embedd;
    }

    /**
     * @param int $embedd
     */
    public function setEmbedd(int $embedd)
    {
        $this->embedd = $embedd;
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
     * @return int
     */
    public function getSorter(): int
    {
        return $this->sorter;
    }

    /**
     * @param int $sorter
     */
    public function setSorter(int $sorter)
    {
        $this->sorter = $sorter;
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

}
