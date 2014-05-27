<?php
/**
 * Created by PhpStorm.
 * User: calc
 * Date: 15.05.14
 * Time: 0:58
 */

namespace system2;

/**
 * Собственная сборка камеры с HLS и FLV, и записью потока на диск
 * Class BBCam
 * @package system2
 */
class BBCam extends VlcCam{
    /**
     * @param IDVR $dvr
     * @param ICamSettings $cs
     */
    function __construct(IDVR $dvr, ICamSettings $cs)
    {
        parent::__construct($dvr, $cs);

        $cs = $this->cs;
        /** @var $cs BBCamSettings */
        if($cs->live) $this->streams[] = new MotionStream($this, $cs);
    }

    public function _create()
    {
        $cs = $this->cs;
        /** @var $cs BBCamSettings */
        if($cs->live){
            $live = new BBLiveStream($this);
            $this->streams[] = $live;
            $this->streams[] = new HLSVlcStream($this, $live);
            //$this->streams[] = new FlvVlcReStream($this, $live);

            //nginx rtmp stream
            //$this->streams[] = new RtmpVlcReStream($this, $live);

            if($cs->rec) $this->streams[] = new BBRecStream($this, $live);

            //motion flv stream
            $this->streams[] = new UrlFlvVlcStream($this, "http://localhost:".(MOTION_STREAM_PORT + $this->getID()));
        }
    }
}
