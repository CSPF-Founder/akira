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

use Tirreno\Utils\Assets\RulesClasses;
use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Tirreno\Utils\Assets\RulesClasses.
 *
 * Covered (unit-testable without refactor):
 * - RulesClasses::getRuleClass() (pure mapping + broken override)
 * - RulesClasses::getRuleTypeByUid() (pure mapping by UID prefix)
 *
 * Not covered (recommended to refactor first):
 * - RulesClasses::getUserScoreClass() (depends on Constants::get() thresholds; hard global/static dependency)
 * - RulesClasses::getRulesClasses() (filesystem scan + include_once + reflection; heavy side effects)
 * - RulesClasses::getSingleRuleObject() (filesystem + include_once + reflection + error_log side effects)
 * - RulesClasses::getAllRulesObjects() (depends on getRulesClasses() + instantiation side effects)
 *
 * @todo Refactor:
 * - extract score thresholds provider behind an interface:
 *   UserScoreThresholdsProviderInterface (lowInf/lowSup/mediumInf/mediumSup/highInf)
 * - extract rule discovery/loading behind interfaces:
 *   RulesFilesystemScannerInterface, RuleClassLoaderInterface, RuleFactoryInterface.
 * - after that, getUserScoreClass()/getRulesClasses()/getSingleRuleObject() become deterministic and properly unit-testable.
 */
final class RulesClassesTest extends TestCase {
    /**
     * @dataProvider ruleClassProvider
     */
    public function testGetRuleClassReturnsExpectedClass(?int $value, bool $broken, string $expected): void {
        $result = RulesClasses::getRuleClass($value, $broken);

        $this->assertSame($expected, $result);
    }

    public static function ruleClassProvider(): array {
        return [
            'broken overrides everything' => [
                20,
                true,
                'broken',
            ],
            'null value uses default 0 => none' => [
                null,
                false,
                'none',
            ],
            'explicit 0 => none' => [
                0,
                false,
                'none',
            ],
            '-20 => positive' => [
                -20,
                false,
                'positive',
            ],
            '10 => medium' => [
                10,
                false,
                'medium',
            ],
            '20 => high' => [
                20,
                false,
                'high',
            ],
            '70 => extreme' => [
                70,
                false,
                'extreme',
            ],
            'unknown value => none' => [
                999,
                false,
                'none',
            ],
        ];
    }

    /**
     * @dataProvider ruleTypeProvider
     */
    public function testGetRuleTypeByUidReturnsExpectedType(string $uid, string $expected): void {
        $result = RulesClasses::getRuleTypeByUid($uid);

        $this->assertSame($expected, $result);
    }

    public static function ruleTypeProvider(): array {
        return [
            'A => Account takeover' => [
                'A01',
                'Account takeover',
            ],
            'B => Behaviour' => [
                'B12',
                'Behaviour',
            ],
            'C => Country' => [
                'C999',
                'Country',
            ],
            'D => Device' => [
                'D01',
                'Device',
            ],
            'E => Email' => [
                'E02',
                'Email',
            ],
            'I => IP' => [
                'I77',
                'IP',
            ],
            'R => Reuse' => [
                'R01',
                'Reuse',
            ],
            'P => Phone' => [
                'P10',
                'Phone',
            ],
            'X => Extra' => [
                'X01',
                'Extra',
            ],
            'unknown prefix falls back to first char' => [
                'Z01',
                'Z',
            ],
            'single-letter uid returns that letter' => [
                'Q',
                'Q',
            ],
        ];
    }
}
