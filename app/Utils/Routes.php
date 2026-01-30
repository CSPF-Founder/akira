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

namespace Tirreno\Utils;

class Routes {
    private static function getF3(): \Base {
        return \Base::instance();
    }

    public static function getCurrentRequestOperator(): \Tirreno\Models\Operator|false|null {
        return self::getF3()->get('CURRENT_USER');
    }

    public static function setCurrentRequestOperator(): void {
        self::getF3()->set('CURRENT_USER', self::getCurrentSessionOperator());
    }

    public static function getCurrentSessionOperator(): \Tirreno\Models\Operator|false|null {
        $model = new \Tirreno\Models\Operator();
        $loggedInOperatorId = \Tirreno\Utils\Conversion::intValCheckEmpty(self::getF3()->get('SESSION.active_user_id'));

        return $loggedInOperatorId ? $model->getOperatorById($loggedInOperatorId) : null;
    }

    public static function redirectIfUnlogged(string $targetPage = '/'): void {
        if (!boolval(self::getCurrentRequestOperator())) {
            self::getF3()->reroute($targetPage);
        }
    }

    public static function redirectIfLogged(): void {
        if (boolval(self::getCurrentRequestOperator())) {
            self::getF3()->reroute('/');
        }
    }

    public static function callExtra(string $method, mixed ...$extra): string|array|null {
        $method = \Base::instance()->get('EXTRA_' . $method);

        return $method && is_callable($method) ? $method(...$extra) : null;
    }
}
