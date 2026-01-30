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

namespace Tirreno\Crons;

class LogbookRotation extends Base {
    public function process(): void {
        $this->addLog('Start logbook rotation.');

        $model = new \Tirreno\Models\ApiKeys();
        $keys = $model->getAllApiKeyIds();
        // rotate events for unauthorized requests
        $keys[] = ['id' => null];

        $model = new \Tirreno\Models\Logbook();
        $cnt = 0;
        foreach ($keys as $key) {
            $cnt += $model->rotateRequests($key['id']);
        }

        $this->addLog(sprintf('Deleted %s events for %s keys in logbook.', $cnt, count($keys)));
    }
}
