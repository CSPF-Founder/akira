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

namespace Tests\Unit\Utils;

use Tirreno\Utils\VersionControl;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Tirreno\Utils\VersionControl.
 *
 * Covered:
 * - versionString() (semantic version format: X.Y.Z)
 * - fullVersionString() (prefixed format: vX.Y.Z)
 *
 * Purpose:
 * - guard public version format from accidental changes
 * - ensure constants are composed consistently
 *
 * @todo Refactor:
 * - consider replacing constants with a Version value object
 * - consider single source of truth for version formatting
 */
final class VersionControlTest extends TestCase {
    public function testVersionString(): void {
        $expected = '0.9.11';
        $actual = VersionControl::versionString();

        $this->assertSame($expected, $actual);
    }

    public function testFullVersionString(): void {
        $expected = 'v0.9.11';
        $actual = VersionControl::fullVersionString();

        $this->assertSame($expected, $actual);
    }
}
