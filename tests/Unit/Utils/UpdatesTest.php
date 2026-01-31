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

use PHPUnit\Framework\TestCase;

/**
 * Unit tests for Tirreno\Utils\Updates.
 *
 * Covered (unit-testable without refactor):
 * - None.
 *
 * Not covered (unstable without refactor):
 * - Updates::syncUpdates():
 *   - instantiates \App\Models\Updates($f3) and calls checkDb(...) (DB required)
 *   - may instantiate controller and call updateRules(...) (side effects)
 *   - Routes::callExtra('UPDATES') is unreachable in unit test because DB-dependent code executes before it
 *
 * @todo Refactor:
 * - extract UpdatesApplierInterface (wrap Models\Updates::checkDb)
 * - extract RulesUpdaterInterface (wrap controller updateRules)
 * - inject dependencies (avoid new ... inside method)
 * - make hook call invokable independently (or accept a callable)
 */
final class UpdatesTest extends TestCase {
    public function testSyncUpdatesIsNotUnitTestableWithoutRefactor(): void {
        $reason = 'Updates::syncUpdates() performs DB-dependent work before calling Routes::callExtra(), '
            . 'so the hook is unreachable without refactor/DI.';

        $this->markTestSkipped($reason);
    }
}
