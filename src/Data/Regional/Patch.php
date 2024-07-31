<?php

namespace Fu\Geo\Data\Regional;

/**
 * 根据腾讯地理位置服务 - TencentDistrictService
 * 更新的行政区域数据，统一不同服务的数据口径
 */
class Patch
{
    public function fix(array &$area, Item $item): void
    {
        foreach ($area as $idx => $place) {
            if ($place == '海外') break;
            if ($place == '中国') continue;
            $item = $this->place_children($area, $idx, $item->getChildren());
            if (!$item) break;
        }
    }

    private function match($haystack, $needle): bool
    {
        if (!$needle) return false;
        return mb_strpos($haystack, $needle, 0, 'UTF-8') !== false;
    }

    private function place_match($place, Item $item): string
    {
        return $this->match($item->getValue(), $place) ? $item->getValue() : '';
    }

    /**
     * @param array $area
     * @param int $index
     * @param Item[]|null $children
     * @return Item|null
     */
    private function place_children(array &$area, int $index, ?array $children): ?Item
    {
        foreach($children as $child) {
            $name = $this->place_match($area[$index], $child);
            if ($name) {
                $area[$index] = $name;
                return $child;
            }
        }
        return null;
    }
}
