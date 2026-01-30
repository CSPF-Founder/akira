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

namespace Sensor\Entity;

class LogbookEntity {
    public const ERROR_TYPE_SUCCESS = 0;
    public const ERROR_TYPE_VALIDATION_ERROR = 1;
    public const ERROR_TYPE_CRITICAL_VALIDATION_ERROR = 2;
    public const ERROR_TYPE_CRITICAL_ERROR = 3;
    public const ERROR_TYPE_RATE_LIMIT_EXCEEDED = 4;

    public function __construct(
        public int $apiKeyId,
        public string $ip,
        public ?int $eventId,
        public int $errorType,
        public ?string $errorText,
        public string $raw,
        public ?string $started,
    ) {
    }
}
