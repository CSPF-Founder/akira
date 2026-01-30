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

use Tests\Support\Utils\Lists\FileExtensionsStubWithExtension;
use PHPUnit\Framework\TestCase;

final class FileExtensionsTest extends TestCase {
    public function testGetWordsReturnsExtensionMapWhenExtensionProvided(): void {
        $actual = FileExtensionsStubWithExtension::getList();

        $expected = [
            'images' => ['jpg', 'png'],
            'docs' => ['pdf'],
        ];

        self::assertSame($expected, $actual);
    }

    public function testGetKeysReturnsArrayKeysFromWords(): void {
        $actual = FileExtensionsStubWithExtension::getKeys();

        $expected = ['images', 'docs'];

        self::assertSame($expected, $actual);
    }

    public function testGetValuesReturnsValueForExistingKeyAndEmptyForMissing(): void {
        $actualImages = FileExtensionsStubWithExtension::getValues('images');
        $expectedImages = ['jpg', 'png'];

        self::assertSame($expectedImages, $actualImages);

        $actualMissing = FileExtensionsStubWithExtension::getValues('missing');
        $expectedMissing = [];

        self::assertSame($expectedMissing, $actualMissing);
    }
}
