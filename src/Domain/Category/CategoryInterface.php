<?php

namespace App\Domain\Category;

interface CategoryInterface
{
    const TYPE_BIKE = 'TYPE_BIKE';
    const TYPE_COMPONENT = 'TYPE_COMPONENTS';
    const TYPE_ACCESSORY = 'TYPE_ACCESSORIES';
    const TYPE_OTHER = 'TYPE_OTHER';

    //Bike types
    const PARENT_BIKE_CATEGORY_ID = 1;
    const ROAD_BIKE_CATEGORY_ID = 2;
    const MOUNTAIN_BIKE_CATEGORY_ID = 3;
    const TRIATHLON_BIKE_CATEGORY_ID = 4;
    const MOUNTAIN_E_BIKE_CATEGORY_ID = 34;
    const ROAD_E_BIKE_CATEGORY_ID = 35;
    const URBAN_E_BIKE_CATEGORY_ID = 36;
    const CROSS_BIKE_CATEGORY_ID = 37;
    const ELECTRIC_BIKE_CATEGORY_ID = 40;
    const ELECTRIC_BIKES_CATEGORIES_IDS = [
        self::ELECTRIC_BIKE_CATEGORY_ID,
        self::MOUNTAIN_E_BIKE_CATEGORY_ID,
        self::ROAD_E_BIKE_CATEGORY_ID,
        self::URBAN_E_BIKE_CATEGORY_ID
    ];

    //Component types
    const ROAD_WHEEL_CATEGORY_ID = 7;
    const MOUNTAIN_WHEEL_CATEGORY_ID = 8;
    const COMPONENT_CATEGORY_ID = 9;

    const ROAD_FRAME_CATEGORY_ID = 11;
    const MOUNTAIN_FRAME_CATEGORY_ID = 12;

    const HANDLEBAR_CATEGORY_ID = 13;
    const SEAT_BIKE_CATEGORY_ID = 16;
    const FORK_CATEGORY_ID = 19;
    const CRANK_ARM_CATEGORY_ID = 21;
    const SHIFTER_CATEGORY_ID = 22;
    const OTHER_COMPONENTS_CATEGORY_ID = 25;
    const STEM_CATEGORY_ID = 39;
    const FRAME_CATEGORY_ID = 41;
    const WHEEL_CATEGORY_ID = 42;

    //Accessories types
    const ACCESSORY_CATEGORY_ID = 26;
    const HELMET_CATEGORY_ID = 27;
    const GPS_CATEGORY_ID = 28;
    const ROLLER_CATEGORY_ID = 29;
    const SHOES_CATEGORY_ID = 30;
    const OTHER_ACCESSORIES_CATEGORY_ID = 31;

    //Other triatlon accessories
    const NEOPRENE_CATEGORY_ID = 33;
}
