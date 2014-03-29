<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 29.03.14
 * Time: 16:48
 */

namespace system;

/**
 * class DVR
 * Система управления камерами
 * @package system
 */
abstract class DVR implements IDVR {
    /**
     * @var \UserID
     */
    private $uid;

    /**
     * @var ICamCreator
     */
    private $cams;

    /**
     * @param \UserID $uid
     */
    function __construct(\UserID $uid)
    {
        $this->uid = $uid;
    }

    /**
     * @param ICamCreator $cams
     */
    public function setCams(ICamCreator $cams)
    {
        $this->cams = $cams;
    }

    /**
     * @return ICamCreator
     */
    public function getCams()
    {
        return $this->cams;
    }

    /**
     * @return \UserID
     */
    public function getUid()
    {
        return $this->uid;
    }

    public function restart()
    {
        $this->stop();
        sleep(1);
        $this->start();
    }

    public function startup()
    {
        $this->stop();
        sleep(1);
        $this->kill();
        sleep(1);
        $this->start();
    }
} 