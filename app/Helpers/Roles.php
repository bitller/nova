<?php

namespace App\Helpers;

use App\Role;

/**
 * Role helper
 *
 * @author Alexandru Bugarin <alexandru.bugarin@gmail.com>
 */
class Roles {

    /**
     * Administrator level
     *
     * @var string
     */
    protected $adminLevel = '1';

    /**
     * Moderator level
     *
     * @var string
     */
    protected $moderatorLevel = '2';

    /**
     * Normal user level
     *
     * @var string
     */
    protected $userLevel = '3';

    /**
     * Get admin role id
     *
     * @return int
     */
    public function getAdminRoleId() {
        return $this->getRoleId($this->adminLevel);
    }

    /**
     * Get moderator role id
     *
     * @return int
     */
    public function getModeratorRoleId() {
        return $this->getRoleId($this->moderatorLevel);
    }

    /**
     * Get normal user role id
     *
     * @return int
     */
    public function getUserRoleId() {
        return $this->getRoleId($this->userLevel);
    }

    /**
     * Get role id for the given $level
     *
     * @param int $level
     * @return int
     */
    private function getRoleId($level) {
        return Role::where('level', $level)->value('id');
    }

}