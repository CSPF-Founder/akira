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

namespace Tirreno\Controllers\Pages;

class Logout extends Base {
    public $page = 'Logout';

    public function getPageParams(): array {
        $pageParams = [
            'HTML_FILE'     => 'logout.html',
            'JS'            => 'user_main.js',
        ];

        if ($this->isPostRequest()) {
            $params = $this->extractRequestParams(['token']);

            $errorCode = \Tirreno\Utils\Access::CSRFTokenValid($params, $this->f3);

            if (!$errorCode) {
                $this->f3->clear('SESSION');
                session_commit();

                $this->f3->reroute('/');
            }

            $pageParams['ERROR_CODE'] = $errorCode;
        }

        return parent::applyPageParams($pageParams);
    }
}
