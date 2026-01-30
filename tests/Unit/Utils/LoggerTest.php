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

use Tirreno\Utils\Logger;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Tirreno\Utils\Logger.
 *
 * Covered (unit-testable without refactor):
 * - Logger::logCronLine() (pure formatting)
 *
 * Not covered (recommended to refactor first):
 * - Logger::log() (hard dependency on F3 \Log + filesystem write side effect)
 * - Logger::logSql() (hard dependency on F3 \Log + filesystem write side effect)
 *
 * @todo Refactor:
 * - extract side-effecting collaborator behind an interface:
 *   LogWriterInterface (or LogFactoryInterface) with write(string $message): void
 * - then Logger::log() / logSql() become deterministic and properly unit-testable without filesystem.
 */
final class LoggerTest extends TestCase {
    /**
     * @dataProvider cronLineProvider
     */
    public function testLogCronLineFormatsAsExpected(string $message, string $cronName, string $expected): void {
        $result = Logger::logCronLine($message, $cronName);

        $this->assertSame($expected, $result);
    }

    public static function cronLineProvider(): array {
        return [
            'simple' => [
                'Started',
                'cronA',
                '[cronA] Started' . PHP_EOL,
            ],
            'message with spaces' => [
                'Hello world',
                'job',
                '[job] Hello world' . PHP_EOL,
            ],
            'message with punctuation' => [
                'Done!',
                'cronB',
                '[cronB] Done!' . PHP_EOL,
            ],
            'empty message' => [
                '',
                'cronC',
                '[cronC] ' . PHP_EOL,
            ],
        ];
    }
}
