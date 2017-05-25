<?php
/**
 * Created by PhpStorm.
 * User: kostya
 * Date: 24.05.17
 * Time: 22:23
 */

namespace App;

use Acme\Entity\Post;

/**
 * Class Pagination
 * @package App
 */
class Pagination
{
    /**
     * @var int|string $pageRange range product for page
     */
    private $pageRange;

    /**
     * @var string $sortable sort params
     */
    private $sortable;

    /**
     * @var string $filtration filtration param
     */
    private $filtration;

    /**
     * @var object Post post entity
     */
    private $postEntity;

    /**
     * @var int $steps stored count steps for pagination
     */
    private $steps;

    /**
     * Get page range
     *
     * @return mixed
     */
    public function getPageRange()
    {
        return $this->pageRange;
    }

    /**
     * Set page range
     *
     * @param mixed $pageRange
     */
    public function setPageRange($pageRange)
    {
        $this->pageRange = $pageRange;
    }

    /**
     * Get sortable
     *
     * @return mixed
     */
    public function getSortable()
    {
        return $this->sortable;
    }

    /**
     * Set sortable
     *
     * @param mixed $sortable
     */
    public function setSortable($sortable)
    {
        $this->sortable = $sortable;
    }

    /**
     * Get filtration
     *
     * @return mixed
     */
    public function getFiltration()
    {
        return $this->filtration;
    }

    /**
     * Set filtration
     *
     * @param mixed $filtration
     */
    public function setFiltration($filtration)
    {
        $this->filtration = $filtration;
    }

    /**
     * Get steps
     *
     * @return mixed
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * Pagination constructor.
     */
    public function __construct()
    {
        $this->postEntity = new Post();
    }

    /**
     * Get pagination data
     *
     * @param $range
     * @param int $shift
     * @param null $order
     * @param string $orderParam
     * @return array
     */
    public function getPaginationData($range, $shift = 1, $order = null, $orderParam = 'ASC')
    {
        $db = Db::connect();

        $this->steps = ceil($this->postEntity->getStepCount($range));

        return $this->postEntity->getPaginationList($range, $this->getPageRange(), $shift, $order, $orderParam);
    }
}