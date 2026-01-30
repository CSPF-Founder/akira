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

namespace Tirreno\Controllers\Admin\User;

class Navigation extends \Tirreno\Controllers\Admin\Base\Navigation {
    public function __construct() {
        parent::__construct();

        $this->controller = new Data();
        $this->page = new Page();
    }

    public function manageUser(): array {
        $accountId  = \Tirreno\Utils\Conversion::getIntRequestParam('userId');
        $cmd        = \Tirreno\Utils\Conversion::getStringRequestParam('type');
        $hasAccess  = $this->controller->checkIfOperatorHasAccess($accountId, $this->apiKey);

        if (!$hasAccess) {
            $this->f3->error(404);
        }

        $successCode = false;

        switch ($cmd) {
            case 'add':
                $this->controller->addToWatchlist($accountId, $this->apiKey);
                $successCode = \Tirreno\Utils\ErrorCodes::USER_ADDED_TO_WATCHLIST;
                break;

            case 'remove':
                $this->controller->removeFromWatchlist($accountId, $this->apiKey);
                $successCode = \Tirreno\Utils\ErrorCodes::USER_REMOVED_FROM_WATCHLIST;
                break;

            case 'fraud':
                $this->controller->addToBlacklistQueue($accountId, true, false, true, $this->apiKey);   // recalculate
                $successCode = \Tirreno\Utils\ErrorCodes::USER_FRAUD_FLAG_SET;
                break;

            case 'legit':
                $this->controller->addToBlacklistQueue($accountId, false, false, true, $this->apiKey);  // recalculate
                $successCode = \Tirreno\Utils\ErrorCodes::USER_FRAUD_FLAG_UNSET;
                break;

            case 'reviewed':
                $this->controller->setReviewedFlag($accountId, true, $this->apiKey);
                $successCode = \Tirreno\Utils\ErrorCodes::USER_REVIEWED_FLAG_SET;
                break;
        }

        return ['success' => $successCode];
    }

    public function getUserScoreDetails(): array {
        $userId = \Tirreno\Utils\Conversion::getIntRequestParam('userId');

        return $this->controller->getUserScoreDetails($userId, $this->apiKey);
    }
}
