<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 27/07/16
 * Time: 22:00
 */

namespace ActivisMap\Util;


class Roles {

    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_PUBLISHER = 'ROLE_PUBLISHER';

    /**
     * @param string $role
     * @return bool
     */
    public static function isValidRole($role) {
        $role = strtoupper($role);

        switch ($role) {
            case Roles::ROLE_SUPER_ADMIN:
            case Roles::ROLE_ADMIN:
            case Roles::ROLE_PUBLISHER:
                return true;
            default:
                return false;
        }
    }

    /**
     * @param $srcRole
     * @param $targetRole
     * @param $upgradeRole
     * @return bool
     */
    public static function canChangeRole($srcRole, $targetRole, $upgradeRole) {
        $srcRole = strtoupper($srcRole);
        $targetRole = strtoupper($targetRole);
        $upgradeRole = strtoupper($upgradeRole);

        if ($srcRole == Roles::ROLE_SUPER_ADMIN) {
            return true;
        }

        if ($srcRole == Roles::ROLE_ADMIN && $upgradeRole == Roles::ROLE_PUBLISHER) {
            if ($targetRole == Roles::ROLE_SUPER_ADMIN || $targetRole == Roles::ROLE_ADMIN) {
                return false;
            }
            return true;
        }

        if ($srcRole == Roles::ROLE_PUBLISHER) {
            return false;
        }

        return false;
    }

    /**
     * @param array $roles
     * @return null|string
     */
    public static function getMaxRole(array $roles = array()) {

        $maxRole = null;

        foreach ($roles as $r) {
            $r = strtoupper($r);
            if ($r == Roles::ROLE_SUPER_ADMIN) {
                $maxRole = Roles::ROLE_SUPER_ADMIN;
                break;
            } else if ($r == Roles::ROLE_ADMIN && $maxRole != Roles::ROLE_SUPER_ADMIN) {
                $maxRole = Roles::ROLE_ADMIN;
            } else if ($maxRole != Roles::ROLE_ADMIN) {
                $maxRole = Roles::ROLE_PUBLISHER;
            }

        }

        return $maxRole;
    }
}