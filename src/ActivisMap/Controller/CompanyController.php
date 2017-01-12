<?php
/**
 * Created by PhpStorm.
 * User: ander
 * Date: 10/01/17
 * Time: 18:25
 */

namespace ActivisMap\Controller;

use ActivisMap\Base\EntityController;
use ActivisMap\Entity\Company;
use ActivisMap\Entity\Event;
use ActivisMap\Entity\UserCompany;
use ActivisMap\Util\Roles;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class CompanyController
 * @package ActivisMap\Controller
 * @Route("/v1/company")
 */
class CompanyController extends EntityController {

    protected function getRepositoryName() {
        return 'ActivisMap:Company';
    }

    /**
     * @Route("")
     * @Method("POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createCompany(Request $request) {
        $params = $this->checkParams($request, array('name', 'email'));

        $name = $params['name'];
        $email = $params['email'];

        $coms = $this->getRepository()
            ->findBy(array('email' => $email));

        if (count($coms) > 0) {
            throw new HttpException(401, 'Company email already exist');
        }

        $company = new Company($name);
        $company->setEmail($email);

        $this->setImage($request, 'logo', $company);

        $this->save($company);

        $superAdmin = $this->getUser();
        $role = $company->getUserRoles($superAdmin);
        $role->addRole(Roles::ROLE_SUPER_ADMIN);

        $this->save($role);

        return $this->rest($role->getUserView());
    }

    /**
     * @Route("/{identifier}")
     * @Method("POST")
     * @param Request $request
     * @param $identifier
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function updateCompany(Request $request, $identifier) {
        $user = $this->getUser();
        $company = $this->getCompany($identifier);

        $roles = $company->getUserRoles($user);

        if (!$roles->isGrantedFor(Roles::ROLE_SUPER_ADMIN)) {
            throw new HttpException(401, 'You do not have necessary permissions');
        }

        $this->setImage($request, 'logo');

        $request->request->remove('roles');

        /** @var Company $company */
        $company = $this->updateAction($request, $company->getId());

        return $this->rest($company->getBaseView());
    }

    /**
     * @Route("/{identifier}")
     * @MEthod("DELETE")
     * @param Request $request
     * @param $identifier
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteCompany(Request $request, $identifier) {
        $user = $this->getUser();
        $company = $this->getCompany($identifier);

        $roles = $company->getUserRoles($user);

        if (!$roles->isGrantedFor(Roles::ROLE_SUPER_ADMIN)) {
            throw new HttpException(401, 'You do not have necessary permissions');
        }

        return $this->deleteAction($company->getId());
    }

    /**
     * @Route("/{identifier}/events")
     * @Method("GET")
     * @param Request $request
     * @param $identifier
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCompanyEvents(Request $request, $identifier) {
        $params = $this->checkParams($request, array(), array('offset', 'limit'));
        $company = $this->getCompany($identifier);

        $offset = 0;
        if (array_key_exists('offset', $params)) {
            $offset = intval($params['offset']);
        }

        $limit = 0;
        if (array_key_exists('limit', $params)) {
            $limit = intval($params['limit']);
        }

        $events = $this->getEventRepository()
            ->createQueryBuilder('e')
            ->where('e.company = :company_id')
            ->setParameter('company_id', $company->getId())
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()->getResult();

        $eventsView = array();

        /** @var Event $e */
        foreach ($events as $e) {
            $eventsView[] = $e->getBaseView();
        }

        return $this->rest($eventsView);
    }

    /**
     * @Route("/{identifier}/users")
     * @Method("GET")
     * @param Request $request
     * @param $identifier
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCompanyUsers(Request $request, $identifier) {
        $params = $this->checkParams($request, array(), array('offset', 'limit'));
        $company = $this->getCompany($identifier);

        $offset = 0;
        if (array_key_exists('offset', $params)) {
            $offset = intval($params['offset']);
        }

        $limit = 0;
        if (array_key_exists('limit', $params)) {
            $limit = intval($params['limit']);
        }

        $roles = $this->getCompanyRolesRepository()
            ->createQueryBuilder('e')
            ->where('e.company = :company_id')
            ->setParameter('company_id', $company->getId())
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->getQuery()->getResult();

        $usersView = array();

        /** @var UserCompany $e */
        foreach ($roles as $e) {
            $usersView[] = $e->getCompanyView();
        }

        return $this->rest($usersView);
    }

    /**
     * @Route("/{identifier}/roles")
     * @Route("POST")
     * @param Request $request
     * @param $identifier
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setUserRole(Request $request, $identifier) {
        $params = $this->checkParams($request, array('role', 'user_id'));
        $company = $this->getCompany($identifier);
        $role = strtoupper($params['role']);

        if (!Roles::isValidRole($role)) {
            throw new HttpException(400, 'Role "' . $params['role'] . ' is not valid role.');
        }

        $admin = $this->getUser();
        $adminRole = $company->getUserRoles($admin)->getMaxRole();

        $user = $this->getUser($params['user_id']);
        $userRoles = $company->getUserRoles($user);
        $userRole = $userRoles->getMaxRole();

        if (!Roles::canChangeRole($adminRole, $userRole, $role)) {
            throw new HttpException(401, 'You do not have necessary permissions');
        }

        $userRoles->setRoles(array($role));

        $this->save($userRoles);

        return $this->rest($userRoles->getCompanyView());
    }
}