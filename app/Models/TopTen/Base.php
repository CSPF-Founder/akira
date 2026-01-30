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

namespace Tirreno\Models\TopTen;

class Base extends \Tirreno\Models\BaseSql {
    public function getQueryParams(int $apiKey, ?array $dateRange): array {
        $queryParams = [':api_key' => $apiKey];

        $endDate = $dateRange['endDate'] ?? null;
        $startDate = $dateRange['startDate'] ?? null;

        if ($startDate && $endDate) {
            $queryParams[':end_time'] = $dateRange['endDate'];
            $queryParams[':start_time'] = $dateRange['startDate'];
        }

        return $queryParams;
    }

    public function getQueryConditions(?array $dateRange): array {
        $conditions = ['event.key = :api_key'];

        $endDate = $dateRange['endDate'] ?? null;
        if ($endDate) {
            $conditions[] = 'event.time >= :start_time';
            $conditions[] = 'event.time <= :end_time';
        }

        return $conditions;
    }
}
