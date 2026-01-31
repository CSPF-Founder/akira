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

use Tirreno\Utils\DictManager;
use PHPUnit\Framework\TestCase;
use Tests\Support\FakeFilesystem;

/**
 * Unit tests for DictManager.
 *
 * Covered:
 * - loading existing dictionary file
 * - ignoring missing file
 * - ignoring file returning false
 *
 * Notes:
 * - filesystem access is isolated via FakeFilesystem helper
 */
final class DictManagerTest extends TestCase {
    private FakeFilesystem $fileSystem;

    protected function setUp(): void {
        parent::setUp();

        $this->fileSystem = new FakeFilesystem('dict_manager');

        $f3 = \Base::instance();
        $f3->clear('DICT_TEST_KEY');
        $f3->set('LOCALES', $this->fileSystem->getRoot() . '/');
        $f3->set('LANGUAGE', 'en');
    }

    protected function tearDown(): void {
        $this->fileSystem->cleanup();
        parent::tearDown();
    }

    public function testLoadExistingDictionaryFile(): void {
        $this->fileSystem->put(
            'en/Additional/test.php',
            <<<'PHP'
<?php
return [
    'DICT_TEST_KEY' => 'test-value',
];
PHP
        );

        DictManager::load('test');

        $value = \Base::instance()->get('DICT_TEST_KEY');

        $this->assertSame('test-value', $value);
    }

    public function testLoadIgnoresMissingFile(): void {
        DictManager::load('missing');

        $value = \Base::instance()->get('DICT_TEST_KEY');

        $this->assertNull($value);
    }

    public function testLoadIgnoresFileReturningFalse(): void {
        $this->fileSystem->put(
            'en/Additional/invalid.php',
            <<<'PHP'
<?php
return false;
PHP
        );

        DictManager::load('invalid');

        $value = \Base::instance()->get('DICT_TEST_KEY');

        $this->assertNull($value);
    }
}
