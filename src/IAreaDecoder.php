<?php

namespace Fu\Geo;

/**
 * 根据经纬度或IP地址解析
 */
interface IAreaDecoder
{
    /**
     * 得到解析后的地址
     *
     * @param  IService $service
     * @return Area
     */
    public function getArea(IService $service): Area;
}
