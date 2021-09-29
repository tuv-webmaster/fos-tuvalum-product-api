<?php
declare(strict_types=1);


namespace App\Tests\files\Application\Controller\Brand;

class CreateBrandControllerTest
{
    private function getValidatorMock()
    {
        return $this->getMockBuilder(ValidatorInterface::class)
            ->disableOriginalConstructor()
            ->disableOriginalClone()
            ->disableArgumentCloning()
            ->disallowMockingUnknownTypes()
            ->getMock();
    }
}
