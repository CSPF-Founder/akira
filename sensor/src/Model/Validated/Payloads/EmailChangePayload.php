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

namespace Sensor\Model\Validated\Payloads;

class EmailChangePayload extends \Sensor\Model\Validated\BaseArray {
    public function __construct(mixed $value) {
        $this->requiredFields = [
            'new_value',
        ];

        $this->optionalFields = [
            'old_value',
        ];

        $this->set = false;
        $this->dump = true;

        parent::__construct($value);
    }
}
