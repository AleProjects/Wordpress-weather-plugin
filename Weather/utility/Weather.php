<?php
/**
 * Date: 11/04/2018
 * Time: 09:52
 */

namespace Weather\utility;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class Weather
{
    const BASE_URL = "http://query.yahooapis.com/v1/public/yql";

    private $city;

    public $url = 'https://query.yahooapis.com/v1/public/yql?q=select wind from weather.forecast where woeid in (select woeid from geo.places(1) where text="chicago, il")&text="chicago,%20il")&format=json';

    public function __construct($city = "")
    {
        $this->setCity($city);
    }

    /**
     * @param string $city
     * @return string[]
     */
    public static function getStaticRequest($city = "") {
        $weather = new self($city);
        return $weather->getRequest();
    }

    /**
     * @return string
     */
    public function getQuery() {
        return 'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="' . $this->getCity() . '")';
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this::BASE_URL . "?q=" . urlencode($this->getQuery()) . "&format=json";
    }

    /**
     * @return string[]
     */
    public function getRequest() {
        $session = curl_init($this->getUrl());
        curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
        $json = curl_exec($session);
        $phpObj = json_decode($json, true);
        return $phpObj;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Weather
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }
}