<?php

namespace App\Helpers;

use App\Role;
use Illuminate\Support\Facades\Auth;

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
     * @return bool
     */
    public function isAdmin() {
        if (Auth::user()->role_id === $this->getAdminRoleId()) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isModerator() {
        if (Auth::user()->role_id === $this->getModeratorRoleId()) {
            return true;
        }
        return false;
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