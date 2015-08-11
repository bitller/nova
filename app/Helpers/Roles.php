<?php

namespace App\Helpers;

use App\Role;

class Roles {

    protected $adminLevel = '1';

    protected $moderatorLevel = '2';

    protected $userLevel = '3';

    public function getAdminRoleId() {
        return $this->getRoleId($this->adminLevel);
    }

    public function getModeratorRoleId() {
        return $this->getRoleId($this->moderatorLevel);
    }

    public function getUserRoleId() {
        return $this->getRoleId($this->userLevel);
    }

    private function getRoleId($level) {
        return Role::where('level', $level)->value('id');
    }

}