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

namespace Tirreno\Controllers\Admin\Data;

class Data extends \Tirreno\Controllers\Admin\Base\Data {
    // POST requests
    public function enrichEntity(): array {
        $controller = new \Tirreno\Controllers\Admin\Enrichment\Navigation();

        return $controller->enrichEntity();
    }

    public function saveRule(): array {
        $controller = new \Tirreno\Controllers\Admin\Rules\Navigation();

        return $controller->saveRule();
    }

    public function switchApplication(): array {
        $f3 = \Base::instance();
        $apiKeyId = (int) $f3->get('REQUEST.apiKeyId');

        $success = \Tirreno\Utils\ApiKeys::setActiveApiKey($apiKeyId);

        return ['success' => $success];
    }

    public function createApplication(): array {
        $f3 = \Base::instance();
        $name = trim((string) $f3->get('REQUEST.name'));
        $currentOperator = \Tirreno\Utils\Routes::getCurrentRequestOperator();

        if (!$currentOperator) {
            return ['success' => false, 'error' => 'Not authenticated'];
        }

        [$isOwner, $apiKeys] = \Tirreno\Utils\ApiKeys::getOperatorApiKeys($currentOperator->id);

        if (!$isOwner) {
            return ['success' => false, 'error' => 'Only owners can create applications'];
        }

        $model = new \Tirreno\Models\ApiKeys();
        $newKeyId = $model->addWithName([
            'quote' => time(),
            'operator_id' => $currentOperator->id,
            'name' => $name,
        ]);

        if ($newKeyId > 0) {
            \Tirreno\Utils\ApiKeys::setActiveApiKey($newKeyId);
            return ['success' => true, 'apiKeyId' => $newKeyId];
        }

        return ['success' => false, 'error' => 'Failed to create application'];
    }

    public function renameApplication(): array {
        $f3 = \Base::instance();
        $apiKeyId = (int) ($f3->get('REQUEST.apiKeyId') ?: \Tirreno\Utils\ApiKeys::getActiveApiKeyId());
        $name = trim((string) $f3->get('REQUEST.name'));
        $currentOperator = \Tirreno\Utils\Routes::getCurrentRequestOperator();

        if (!$currentOperator) {
            return ['success' => false, 'error' => 'Not authenticated'];
        }

        $model = new \Tirreno\Models\ApiKeys();
        $success = $model->updateName($apiKeyId, $currentOperator->id, $name);

        return ['success' => $success];
    }

    public function removeFromBlacklist(): array {
        $controller = new \Tirreno\Controllers\Admin\Blacklist\Navigation();

        return $controller->removeItemFromList();
    }

    public function removeFromWatchlist(): array {
        $controller = new \Tirreno\Controllers\Admin\Watchlist\Navigation();

        return $controller->removeUserFromList();
    }

    public function manageUser(): array {
        $controller = new \Tirreno\Controllers\Admin\User\Navigation();

        return $controller->manageUser();
    }

    // GET requests
    public function checkRule(): array {
        $controller = new \Tirreno\Controllers\Admin\Rules\Navigation();

        return $controller->checkRule();
    }

    public function getTimeFrameTotal(): array {
        $controller = new \Tirreno\Controllers\Admin\Totals\Navigation();

        return $controller->getTimeFrameTotal();
    }

    public function getCountries(): array {
        $controller = new \Tirreno\Controllers\Admin\Countries\Navigation();

        return $controller->getList();
    }

    public function getMap(): array {
        $controller = new \Tirreno\Controllers\Admin\Countries\Navigation();

        return $controller->getMap();
    }

    public function getIps(): array {
        $controller = new \Tirreno\Controllers\Admin\IPs\Navigation();

        return $controller->getList();
    }

    public function getEvents(): array {
        $controller = new \Tirreno\Controllers\Admin\Events\Navigation();

        return $controller->getList();
    }

    public function getLogbook(): array {
        $controller = new \Tirreno\Controllers\Admin\Logbook\Navigation();

        return $controller->getList();
    }

    public function getUsers(): array {
        $controller = new \Tirreno\Controllers\Admin\Users\Navigation();

        return $controller->getList();
    }

    public function getUserAgents(): array {
        $controller = new \Tirreno\Controllers\Admin\UserAgents\Navigation();

        return $controller->getList();
    }

    public function getDevices(): array {
        $controller = new \Tirreno\Controllers\Admin\Devices\Navigation();

        return $controller->getList();
    }

    public function getResources(): array {
        $controller = new \Tirreno\Controllers\Admin\Resources\Navigation();

        return $controller->getList();
    }

    public function getDashboardStat(): array {
        $controller = new \Tirreno\Controllers\Admin\Home\Navigation();

        return $controller->getDashboardStat();
    }

    public function getTopTen(): array {
        $controller = new \Tirreno\Controllers\Admin\Home\Navigation();

        return $controller->getTopTen();
    }

    public function getChart(): array {
        $controller = new \Tirreno\Controllers\Admin\Home\Navigation();

        return $controller->getChart();
    }

    public function getEventDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\Events\Navigation();

        return $controller->getEventDetails();
    }

    public function getFieldEventDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\FieldAuditTrail\Navigation();

        return $controller->getFieldEventDetails();
    }

    public function getLogbookDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\Logbook\Navigation();

        return $controller->getLogbookDetails();
    }

    public function getEmailDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\Emails\Navigation();

        return $controller->getEmailDetails();
    }

    public function getPhoneDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\Phones\Navigation();

        return $controller->getPhoneDetails();
    }

    public function getUserDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\UserDetails\Navigation();

        return $controller->getUserDetails();
    }

    public function getUserEnrichmentDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\UserDetails\Navigation();

        return $controller->getUserEnrichmentDetails();
    }

    public function getNotCheckedEntitiesCount(): array {
        $controller = new \Tirreno\Controllers\Admin\Enrichment\Navigation();

        return $controller->getNotCheckedEntitiesCount();
    }

    public function getEmails(): array {
        $controller = new \Tirreno\Controllers\Admin\Emails\Navigation();

        return $controller->getList();
    }

    public function getPhones(): array {
        $controller = new \Tirreno\Controllers\Admin\Phones\Navigation();

        return $controller->getList();
    }

    public function getFieldAuditTrail(): array {
        $controller = new \Tirreno\Controllers\Admin\FieldAuditTrail\Navigation();

        return $controller->getList();
    }

    public function getFieldAudits(): array {
        $controller = new \Tirreno\Controllers\Admin\FieldAudits\Navigation();

        return $controller->getList();
    }

    public function getUserScoreDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\User\Navigation();

        return $controller->getUserScoreDetails();
    }

    public function getIsps(): array {
        $controller = new \Tirreno\Controllers\Admin\ISPs\Navigation();

        return $controller->getList();
    }

    public function getDomains(): array {
        $controller = new \Tirreno\Controllers\Admin\Domains\Navigation();

        return $controller->getList();
    }

    public function getReviewUsersQueue(): array {
        $controller = new \Tirreno\Controllers\Admin\ReviewQueue\Navigation();

        return $controller->getList();
    }

    public function getReviewUsersQueueCount(): array {
        $controller = new \Tirreno\Controllers\Admin\ReviewQueue\Navigation();

        return $controller->setNotReviewedCount(false);     // no cache
    }

    public function getBlacklistUsersCount(): array {
        $controller = new \Tirreno\Controllers\Admin\Blacklist\Navigation();

        return $controller->setBlacklistUsersCount(false);  // no cache
    }

    public function getIspDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\ISP\Navigation();

        return $controller->getIspDetails();
    }

    public function getIpDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\IP\Navigation();

        return $controller->getIpDetails();
    }

    public function getDeviceDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\Devices\Navigation();

        return $controller->getDeviceDetails();
    }

    public function getUserAgentDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\UserAgent\Navigation();

        return $controller->getUserAgentDetails();
    }

    public function getDomainDetails(): array {
        $controller = new \Tirreno\Controllers\Admin\Domain\Navigation();

        return $controller->getDomainDetails();
    }

    public function getSearchResults(): array {
        $controller = new \Tirreno\Controllers\Admin\Search\Navigation();

        return $controller->getSearchResults();
    }

    public function getBlacklist(): array {
        $controller = new \Tirreno\Controllers\Admin\Blacklist\Navigation();

        return $controller->getList();
    }

    public function getUsageStats(): array {
        $controller = new \Tirreno\Controllers\Admin\Api\Navigation();

        return $controller->getUsageStats();
    }

    public function getCurrentTime(): array {
        $controller = new \Tirreno\Controllers\Admin\Home\Navigation();

        return $controller->getCurrentTime();
    }
}
