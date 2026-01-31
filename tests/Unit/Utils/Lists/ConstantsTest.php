<?php

/**
 * Akira ~ open-source security framework
 * Based on Tirreno (https://github.com/TirrenoTechnologies/tirreno)
 * Copyright (c) Tirreno Technologies Sàrl (https://www.tirreno.com)
 * Modified by Cyber Security and Privacy Foundation (https://cysecurity.org)
 *
 * Licensed under GNU Affero General Public License version 3 of the or any later version.
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Tirreno Technologies Sàrl, Cyber Security and Privacy Foundation
 * @license       https://opensource.org/licenses/AGPL-3.0 AGPL License
 * @link          https://cysecurity.org Akira
 */

declare(strict_types=1);

namespace Tests\Unit\Utils\Lists;

use PHPUnit\Framework\TestCase;
use Tests\Support\Utils\Lists\ConstantsNoFsStub;

final class ConstantsTest extends TestCase {
    public function testGetListReturnsBuiltInMapWhenExtensionIsNull(): void {
        $list = ConstantsNoFsStub::getList();

        self::assertIsArray($list);
        self::assertNotEmpty($list);
    }

    public function testGetListHasRequiredTopLevelGroups(): void {
        $list = ConstantsNoFsStub::getList();

        self::assertArrayHasKey('user_details_total_limits', $list);

        self::assertIsArray($list['user_details_total_limits']);
    }

    public function testAllLimitsAreIntegersAndNonNegative(): void {
        $list = ConstantsNoFsStub::getList();

        foreach ($list as $group => $limits) {
            self::assertIsArray($limits);

            foreach ($limits as $metric => $value) {
                self::assertIsInt($value, $group . '.' . $metric . ' must be int');
                self::assertGreaterThanOrEqual(0, $value, $group . '.' . $metric . ' must be >= 0');
            }
        }
    }
}
